<?php

namespace Lar\Layout;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Lar\Layout\Interfaces\GuardExecutor;
use Lar\LJS\LJS;

class Executor
{
    /**
     * Array custom include executor
     *
     * @var array
     */
    static protected $custom = [];

    /**
     * @var array
     */
    static protected $custom_namespace = [];

    /**
     * Rout params and request
     *
     * @var array
     */
    protected $requests = [];

    /**
     * Executor constructor.
     */
    public function __construct()
    {
        $params = \Route::current()->parameters;

        foreach (\Route::current()->parameterNames as $parameterName) {

            $this->requests[$parameterName] = isset($params[$parameterName]) ? $params[$parameterName] : null;
        }
    }

    /**
     * @param $collection
     */
    static function injectCollection ($collection) {

        if (is_array($collection) || $collection instanceof Collection) {

            static::$custom = array_merge(static::$custom, $collection);
        }
    }

    /**
     * @param string $name
     * @param $namespace
     */
    static function addExecutor (string $name, $namespace = null) {

        if (!$namespace) {

            if (class_exists($name)) {

                $n = $name::$name;

                if ($n) {

                    static::$custom[$n] = $name;
                }
            }
        }

        else {

            static::$custom[$name] = $namespace;
        }
    }

    /**
     * @param string $name
     * @param $namespace
     * @return $this
     */
    public function addExec(string $name, $namespace)
    {
        static::addExecutor($name, $namespace);

        return $this;
    }

    /**
     * @param string $namespace
     */
    static function addExecutorsNamespace (string $namespace) {

        static::$custom_namespace[] = $namespace;
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function addExecNamespace(string $namespace)
    {
        static::addExecutorsNamespace($namespace);

        return $this;
    }

    /**
     * Route functional
     *
     * @param $component
     * @param Request $request
     * @return string
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        if (!$request->ajax() && !$request->get("_with_executor", false)) {

            abort(405);
        }

        if ($request->has("_exec")) {

            $data = $request->_exec;

            if (is_string($data)) {

                $data = json_decode($data, 1);
            }
        }

        if (!isset($data)) {

            return response(["toast:error" => "Error command, undefined data"], 417);
        }

        if (!is_array($data)) {

            return response(["toast:error" => "Error command decrypt"], 417);
        }

        $_list = (is_file(app()->bootstrapPath("jax_executors.php")) ? include app()->bootstrapPath("jax_executors.php") : []);

        $_list = array_merge($_list, static::$custom);

        $_namespaces = array_merge((is_file(app()->bootstrapPath("jax_namespaces.php")) ? include app()->bootstrapPath("jax_namespaces.php") : []), static::$custom_namespace);

        $_namespaces[] = "\\App\\Http\\JaxExecutors";

        $response = [];

        $headers = [];

        $status = 406;

        foreach ($data as $exec => $params) {

            $exec = preg_replace("/^([0-9\:]+)\:/", "", $exec);

            if (isset($_list[$exec])) {

                $exec = $_list[$exec];
            }

            else {

                $_t_name = implode("\\", array_map("ucfirst", explode(".", $exec)));

                foreach ($_namespaces as $namespace) {

                    $_tmp_class = trim($namespace, "\\") . "\\" . $_t_name;

                    if (class_exists($_tmp_class)) {

                        $exec = $_tmp_class;

                        break;
                    }
                }
            }

            if (class_exists($exec)) {

                $obj = new $exec;

                if (method_exists($obj, 'access') && !$obj->access()) {

                    if (method_exists($obj, 'default')) {

                        $status = 200;

                        $result = custom_closure_call([$obj, 'default'], [
                            'executor' => $this,
                            static::class => $this
                        ]);

                        if ($result !== null) {

                            if ($result instanceof Arrayable) {

                                $result = $result->toArray();

                            } else if ($result instanceof Htmlable) {

                                $result = $result->toHtml();

                            } else if ($result instanceof Renderable) {

                                $result = $result->render();
                            }

                            if (!is_array($result)) {

                                $result = [$result];
                            }

                            JaxExecutor::respond()->justMerge($result);
                        }
                    }
                    
                    continue;
                }

                if ($obj instanceof JaxExecutor) {

                    foreach ($this->requests as $key => $request) {

                         $obj->{$key} = $request;
                    }

                    try {

                        if (is_array($params)) {

                            foreach ($params as $method => $param) {

                                if ($obj->isStop()) {

                                    break;
                                }

                                if (method_exists($obj, $method)) {

                                    if ($param === null || $param === 'null') {

                                        $param = [];
                                    }

                                    $param = array_scripts($param);

                                    if (!is_array($param)) {

                                        $param = [$param];
                                    }

                                    $result = custom_closure_call([$obj, $method], array_merge([
                                        'params' => $param,
                                        'executor' => $this,
                                        static::class => $this
                                    ], $param));

                                    if ($result !== null) {

                                        if ($result instanceof Arrayable) {

                                            $result = $result->toArray();

                                        } else if ($result instanceof Htmlable) {

                                            $result = $result->toHtml();

                                        } else if ($result instanceof Renderable) {

                                            $result = $result->render();
                                        }

                                        if (!is_array($result)) {

                                            $result = [$result];
                                        }

                                        JaxExecutor::respond()->justMerge($result);
                                    }

                                    if ($obj->isStop()) {

                                        break;
                                    }

                                } else {

                                    JaxExecutor::respond()->toast_error("Undefined method [{$method}]!");
                                }
                            }
                        }

                        else if (method_exists($obj, "__invoke")) {

                            $params = array_scripts($params);

                            if (!is_array($params)) {

                                $params = [$params];
                            }

                            $d = custom_closure_call([$obj, '__invoke'], [
                                'params' => $params
                            ], $params);

                            if ($d !== null) {

                                if ($d instanceof Arrayable) {

                                    $d = $d->toArray();

                                } else if ($d instanceof Htmlable) {

                                    $d = $d->toHtml();

                                } else if ($d instanceof Renderable) {

                                    $d = $d->render();
                                }

                                if (is_array($d)) {

                                    $d = [$d];
                                }

                                JaxExecutor::respond()->justMerge($d);
                            }
                        }

                        $headers = array_merge($headers, $obj->getResponseHeaders());

                        JaxExecutor::respond()->merge($obj->response());

                        $status = $obj->getResponseStatus();
                    }

                    catch (\Exception $exception) {

                        if (\App::isLocal()) {

                            throw $exception;
                        }

                        else {

                            $status = 500;

                            JaxExecutor::respond()->toast_error("System Error [{$exec}]");

                            \Log::error($exception);
                        }
                    }

                }

                else {

                    $status = 417;

                    JaxExecutor::respond()->toast_error("Undefined executor [{$exec}]");
                }
            }
        }

        $ljs_render = \LJS::render();

        if (!empty($ljs_render)) {

            JaxExecutor::respond()->jq()->eval($ljs_render);
        }

        return response(
            JaxExecutor::respond()->merge($response)->merge(Respond::glob()),
            $status,
            $headers
        );
    }

    /**
     * @return array
     */
    public static function executorList()
    {
        return static::$custom;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }
}
