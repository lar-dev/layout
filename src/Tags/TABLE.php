<?php

namespace Lar\Layout\Tags;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Lar\Layout\Abstracts\Component;
use Lar\Tagable\Events\onRender;
use Lar\Tagable\Tag;

class TABLE extends Component implements onRender
{
    /**
     * Tag element
     *
     * @var string
     */
    protected $element = "table";

    /**
     * Link on tbody
     *
     * @var TBODY
     */
    protected $tbody;

    /**
     * Columns array
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Table rows
     *
     * @var null|array
     */
    protected $rows;

    /**
     * Model linc
     *
     * @var Model|Collection
     */
    public $model;

    /**
     * Model pagination
     *
     * @var LengthAwarePaginator
     */
    public $page;

    /**
     * Default num items in page
     *
     * @var int
     */
    public $default_num_page = 5;

    /**
     * @var int
     */
    public $min_num_page = 1;

    /**
     * @var int
     */
    public $max_num_page = 100;

    /**
     * @var array
     */
    public static $column_macros = [];

    /**
     * @var array
     */
    public static $column_extensions = [];

    /**
     * @var string
     */
    private $order_by_field = "id";

    /**
     * @var string
     */
    private $order_by_type = "asc";

    /**
     * @var bool
     */
    protected $auto_tbody = true;

    /**
     * TABLE constructor.
     *
     * @param mixed ...$params
     * @throws \Exception
     */
    public function __construct(...$params)
    {
        parent::__construct();

        $this->when($params);

        if ($this->auto_tbody) {
            $this->tbody()->haveLink($this->tbody);
        }
    }

    /**
     * @return TBODY
     */
    public function getTbody()
    {
        return $this->tbody;
    }

    /**
     * @param mixed ...$when
     * @return $this|CAPTION
     * @throws \Exception
     */
    public function caption(...$when)
    {
        return $this->prepEnd()->caption(...$when);
    }

    /**
     * @param $field
     * @param string $type
     * @return $this
     */
    public function orderBy($field, $type = "asc")
    {
        $this->order_by_field = $field;

        $this->order_by_type = strtolower($type) == 'asc' || strtolower($type) == 'desc' ? strtolower($type) : 'asc';

        return $this;
    }

    /**
     * Set model in to component
     *
     * @param Relation|Builder|Model|\Illuminate\Support\Collection|string $model
     * @param string|null $order_field
     * @param string|null $order_type
     * @return $this
     */
    public function setModel($model, string $order_field = null, string $order_type = null)
    {
        $req = request();

        if ($order_field) {

            $this->order_by_field = $order_field;
        }

        if ($order_type) {

            $this->order_by_type = $order_type;
        }

        if ($req->has('type')) {

            $this->order_by_type = $req->get('type');
        }

        if ($model instanceof Relation || $model instanceof Builder || $model instanceof Model) {

            $this->callEvent("paginate_model", [
                get_class($model) => $model,
                'model' => $model
            ], function ($last) use (&$model) {

                if ($last instanceof Relation || $last instanceof Builder || $last instanceof Model) {

                    $model = $last;
                }
            });

            $id = !$this->hasAttribute("id") ? $this->getModelName($model) : $this->getId();

            if ($req->has($id)) {

                $this->order_by_field = $req->get($id);
            }

            $this->model = $model->orderBy($this->order_by_field, $this->order_by_type)->paginate($this->getNumPage());
        }
        else if ($model instanceof \Illuminate\Support\Collection) {

            $this->callEvent("paginate_collect", [
                get_class($model) => $model,
                'model' => $model
            ], function ($last) use (&$model) {

                if ($last instanceof \Illuminate\Support\Collection) {

                    $model = $last;
                }
            });

            $id = !$this->hasAttribute("id") ? $this->getModelName($model) : $this->getId();

            if ($req->has($id)) {

                $this->order_by_field = $req->get($id);
            }

            $model = $model->{strtolower($this->order_by_type) == "asc" ? "sortBy" : "sortByDesc"}($this->order_by_field);

            $this->model = $model->paginate($this->getNumPage());
        }
        else {

            $this->model = $model;
        }

        if (!$this->hasAttribute("id") && isset($id) && $id) {

            $this->setId($id);
        }

        else if (!$this->hasAttribute("id") && isset($this->model[0])) {

            $this->setId($this->getModelName($this->model[0]));
        }

        return $this;
    }

    /**
     * @param $model
     * @return string|false
     */
    protected function getModelName($model)
    {
        if ($model instanceof Model) {

            return strtolower(
                preg_replace('/.*\\\\([A-Za-z\_][0-9A-Za-z\_]+)$/', '$1', get_class($model))
            );
        }

        else if ($model instanceof Builder) {

            return strtolower(
                preg_replace('/.*\\\\([A-Za-z\_][0-9A-Za-z\_]+)$/', '$1', get_class($model->getModel()))
            );
        }

        else if ($model instanceof Relation) {

            return strtolower(
                preg_replace('/.*\\\\([A-Za-z\_][0-9A-Za-z\_]+)$/', '$1', get_class($model->getModel()))
            );
        }

        else if (is_object($model)) {

            return strtolower(
                preg_replace('/.*\\\\([A-Za-z\_][0-9A-Za-z\_]+)$/', '$1', get_class($model))
            );
        }

        else {

            return $this->getUnique();
        }
    }

    /**
     * Get table num page
     *
     * @return int
     */
    public function getNumPage()
    {
        return on_num_page($this->default_num_page, $this->min_num_page, $this->max_num_page);
    }

    /**
     * @param int $default
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function rowsOnPage(int $default = 5, int $min = 1, int $max = 100)
    {
        $this->default_num_page = $default;

        $this->min_num_page = $min;

        $this->max_num_page = $max;

        return $this;
    }

    /**
     * Add headers
     *
     * @param array $headers
     * @return $this
     * @throws \Exception
     */
    public function headers($headers = [])
    {

        $this->prepEnd()->thead()->tr()->when(function (TR $tr) use ($headers){

            foreach ($headers as $item) {

                $th = $tr->th();

                if ($item instanceof \Closure) {

                    $item = embedded_call($item, [
                        TH::class => $th
                    ]);
                }

                $th->appEnd($item);

                $this->callEvent(['header', $item], [
                    TH::class => $th,
                ]);
            }
        });

        return $this;
    }

    /**
     * @param $title
     * @param \Closure $closure
     * @return $this
     */
    public function addHeaderEvent($title, \Closure $closure)
    {
        $this->addEvent(['header', $title], $closure);

        return $this;
    }

    /**
     * @param array $rows
     */
    public function rows($rows = [])
    {
        foreach ($rows as $row) {

            $tr = $this->tbody->tr();

            foreach ($row as $column) {

                $tr->td($column == 0 ? ' 0' : $column);
            }
        }
    }

    /**
     * @param string $class
     * @throws \ReflectionException
     */
    static function addMacroClass(string $class) {

        if (class_exists($class)) {

            $refl = new \ReflectionClass($class);

            $class = new $class();

            foreach ($refl->getMethods() as $method) {

                if ($method->isPublic()) {

                    static::addMacro($method->getName(), $class, $method->getName());
                }
            }
        }
    }

    /**
     * Add macro
     *
     * @param $name
     * @param $object
     * @param string|null $method
     */
    static function addMacro($name, $object, string $method = null) {

        if ($object instanceof \Closure) {

            static::$column_macros[$name] = $object;
        }

        else {

            if (!$method) {

                $method = $name;
            }

            static::$column_macros[$name] = [$object, $method];
        }
    }

    /**
     * @param  string  $name
     * @param $params
     * @throws \Exception
     * @return mixed
     */
    public static function callMacro(string $name, ...$params)
    {
        if (!isset(static::$column_macros[$name])) {

            throw new \Exception("Macro [{$name}] not found!");
        }

        $data = static::$column_macros[$name];

        if (is_array($data)) {

            return $data[0]->{$data[1]}(...$params);
        }

        return $data(...$params);
    }

    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return mixed
     * @throws \Exception
     */
    public static function customCallMacro(string $name, array $arguments)
    {
        if (!isset(static::$column_macros[$name])) {

            throw new \Exception("Macro [{$name}] not found!");
        }

        return embedded_call(static::$column_macros[$name], $arguments);
    }

    /**
     * Register Extension
     *
     * @param string $name
     * @param string $class
     */
    static function registerExtension(string $name, string $class) {

        static::$column_extensions[$name] = $class;
    }

    /**
     * Register many Extensions
     *
     * @param array $names
     */
    static function registerExtensions(array $names) {

        foreach ($names as $name => $class) {

            static::registerExtension($name, $class);
        }
    }

    /**
     * @param $title
     * @param $field
     * @param  bool  $prepend
     * @param  bool  $th
     * @return TD
     */
    public function column($title, $field, bool $prepend = false, bool $th = false)
    {
        $params = [];

        $ext = false;

        $add = [];

        if (is_string($field) && preg_match('/(.*)\:(.*)/', $field,$m)) {

            $m1 = array_reverse(explode(":", $m[1]));

            $field = $m1[0];

            unset($m1[0]);

            foreach ($m1 as $cnum => $item) {

                $props = [];

                if (preg_match('/(.*)\((.*)\)$/', $item, $cm)) {

                    $item = $cm[1];
                    $props = explode(",", $cm[2]);
                }

                if (isset(static::$column_macros[$item])) {

                    $add['chain'][$cnum] = static::$column_macros[$item];
                    $add['chain_props'][$cnum] = $props;
                }
            }

            if (isset($m[2])) {

                $params = explode(",", $m[2]);
            }
        }

        if (is_string($field) && isset(static::$column_macros[$field])) {

            $field = static::$column_macros[$field];
        }

        if (is_string($field) && isset(static::$column_extensions[$field])) {

            if (class_exists(static::$column_extensions[$field])) {

                $field = static::$column_extensions[$field];

                $ext = true;
            }
        }

        $num = !$prepend ? count($this->columns) : -count($this->columns);

        $this->columns[$num] =  ['th' => $title, 'td' => $this->createTD($field, $params, $ext, $add, $th), 'order' => $num];

        return $this->columns[$num];
    }

    /**
     * @param  \Closure|array|string  $wrapper
     * @param  array  $params
     * @param  bool  $ext
     * @param  array  $add
     * @param  bool  $th
     * @return Component
     */
    public function createTD($wrapper, array $params = [], bool $ext = false, array $add = [], $th = false)
    {
        $func = function (Component $td) use ($wrapper, $params, $ext, $add) {

            $td->tr_field = !$ext ? $wrapper : (new $wrapper(...$params));

            $td->params = $params;

            foreach ($add as $key => $val) {
                $td->{$key} = $val;
            }

            $td->ext = $ext;
        };

        if (!$th) {
            return TD::create($func);
        } else {
            return TH::create($func)->attr(['scope' => 'row']);
        }
    }

    /**
     * Push a new row data
     *
     * @param $data
     * @return $this
     */
    public function pushRow($data)
    {
        if (!$this->rows) {

            $this->rows = [];
        }

        $this->rows[] = $data;

        return $this;
    }

    /**
     * @param $call
     * @return $this
     */
    public function beforeCreateColumns($call)
    {
        $this->addEvent('before_create_columns', $call);

        return $this;
    }

    /**
     * @param $call
     * @return $this
     */
    public function afterCreateColumns($call)
    {
        $this->addEvent('after_create_columns', $call);

        return $this;
    }

    /**
     * Function execute on render component
     *
     * @return mixed
     * @throws \Exception
     */
    public function onRender()
    {
        $iteration = 0;

        $last = $this->callEvent(
            "before_create_columns", [],
            function ($last) {

                if (is_array($last)) {

                    $this->columns = array_merge($last, $this->columns);
                }
            }
        );

        if (count($this->columns)) {

            $this->columns = collect($this->columns)->sortBy('order');

            $this->headers($this->columns->pluck('th')->toArray());

            $collect = null;

            $create = function (TR $tr, $row, $iteration) {

                foreach ($this->columns as $column) {

                    $th = $column['th'];

                    $column = $column['td'];

                    $title = $th;

                    $field = $column->tr_field;

                    $column->content();

                    if (is_string($field)) {

                        if (Tag::$components->has($field)) {

                            $field = Tag::$components->get($field);

                            $field = new $field($row);
                        }

                        else {

                            $field = multi_dot_call($row, $field);
                        }
                    }

                    else if ($field instanceof \Closure) {

                        $field = embedded_call($field, [
                            'row' => $row,
                            'model' => $row,
                            'column' => $column,
                            'props' => isset($column->params) ? $column->params : [],
                            'iteration' => $iteration,
                            'i' => $iteration,
                            'title' => $title,
                            'label' => $title,
                            TD::class => $column,
                            TR::class => $tr,
                            (is_object($row) ? get_class($row) : gettype($row)) => $row,
                        ]);
                    }

                    else if (is_array($field)) {

                        if (isset($field[0]) && (is_object($field[0]) || is_string($field[0]))) {

                            $obj = is_string($field[0]) ? new $field[0]() : $field[0];

                            $method = "__invoke";

                            $method_params = $column->params;

                            if (isset($field[1])) {

                                if (is_array($field[1])) {

                                    if (isset($field[1][0]) && is_string($field[1][0])) {

                                        $method = $field[1][0];

                                        unset($field[1][0]);
                                    }

                                    $method_params = array_merge($method_params, $field[1]);
                                }

                                else if (is_string($field[1])) {

                                    $method = $field[1];
                                }
                            }

                            $f_name = $method_params[0] ?? $method;
                            $f = multi_dot_call($row, $f_name);

                            if(isset($method_params[0])) { unset($method_params[0]); $method_params = array_values($method_params); }
                            
                            $field = embedded_call([$obj, $method], [
                                'model' => $row,
                                'value' => $f,
                                'field' => $f_name,
                                'column' => $column,
                                'props' => $method_params,
                                'iteration' => $iteration,
                                'i' => $iteration,
                                'title' => $title,
                                TD::class => $column,
                                TR::class => $tr,
                                (is_object($row) ? get_class($row) : gettype($row)) => $row,
                            ]);

                            if (isset($column->chain)) {

                                foreach ($column->chain as $kk => $item) {

                                    $field = embedded_call($item, [
                                        'model' => $row,
                                        'value' => $field,
                                        'field' => $f_name,
                                        'column' => $column,
                                        'props' => $column->chain_props[$kk],
                                        'iteration' => $iteration,
                                        'i' => $iteration,
                                        'title' => $title,
                                        TD::class => $column,
                                        TR::class => $tr,
                                        (is_object($row) ? get_class($row) : gettype($row)) => $row,
                                    ]);
                                }
                            }
                        }
                    }

                    $tr->appEnd($column->appEnd($field === 0 || $field === '0' ? ' 0' : $field)->render());
                }
            };

            if ($this->model) {

                if ($this->model instanceof Model) {

                    $collect = [$this->model];

                }

                else if ($this->model instanceof Collection) {

                    $collect = $this->model;
                }

                else if ($this->model instanceof LengthAwarePaginator) {

                    $collect = $this->model->getCollection();
                }

                if ($collect) {

                    $this->tbody->mapCollect($collect, function (TR $tr, $row) use ($create, &$iteration) {

                        $create($tr, $row, $iteration);

                        $iteration++;
                    });
                }
            }

            else if (is_array($this->rows)) {

                $this->tbody->mapCollect($this->rows, function (TR $tr, $row) use ($create, &$iteration) {

                    $create($tr, $row, $iteration);

                    $iteration++;
                });
            }

            else {

                $this->tbody->mapCollect([0], function (TR $tr, $row) use ($create, &$iteration) {

                    $create($tr, $row, $iteration);

                    $iteration++;
                });
            }

            if ($iteration) {

                $iteration--;
            }
        }

        $this->callEvent('after_create_columns', [
            "iteration" => $iteration,
            "i" => $iteration,
            "row_count" => $iteration,
            "column_count" => count($this->columns),
            "last" => $last,
            "model" => $this->model,
            (is_object($this->model) ? get_class($this->model) : gettype($this->model)) => $this->model
        ]);
    }

    /**
     * Get table column count
     *
     * @return int
     */
    public function columnCount()
    {
        return count($this->columns);
    }

    /**
     * @return string
     */
    public function getOrderField()
    {
        return $this->order_by_field;
    }

    /**
     * @return string
     */
    public function getOrderType()
    {
        return $this->order_by_type;
    }
}
