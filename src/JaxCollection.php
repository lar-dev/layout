<?php

namespace Lar\Layout;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class JaxCollection
 *
 * @package Lar\Layout
 */
class JaxCollection extends Collection
{
    /**
     * @var Respond
     */
    protected $parent;

    /**
     * @param Respond|null $parent
     * @return Respond|null
     */
    public function parent($parent = null)
    {
        if (!$this->parent && $parent) {

            $this->parent = $parent;
        }

        return $this->parent;
    }

    /**
     * @param array $data
     * @return JaxCollection
     */
    public function onDone($data)
    {
        $this->put("onDoneData", $data);

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function onSuccess($data)
    {
        $this->put("onSuccessData", $data);

        return $this;
    }

    /**
     * @param array $data
     * @return JaxCollection
     */
    public function onError($data)
    {
        $this->put("onErrorData", $data);

        return $this;
    }

    /**
     * @param $name
     * @param mixed ...$params
     * @return JaxCollection
     * @throws \Exception
     */
    public function call($name, ...$params)
    {
        foreach ($params as $key => $param) {

            if ($param instanceof Model) {

                $params[$key] = ee_model($param);
            }
        }

        return $this->put($name, $params);
    }

    /**
     * Post params
     *
     * @param array $params
     * @return JaxCollection
     */
    public function params(array $params)
    {
        return $this->put("params", $params);
    }

    /**
     * @param array $params
     * @return JaxCollection
     */
    public function mergeParams(array $params)
    {
        $arr = [];

        if ($this->has("params")) {

            $arr = $this->get("params");
        }

        return $this->params(array_merge($arr, $params));
    }

    /**
     * @param array $params
     * @return JaxCollection
     */
    public function withRequest(array $params = [])
    {
        return $this->params(request()->toArray())->mergeParams($params);
    }

    /**
     * @return $this
     */
    public function withGet()
    {
        $this->put("withGet", true);

        return $this;
    }

    /**
     * @param $part
     * @param mixed ...$parts
     * @return $this
     */
    public function with($part, ...$parts)
    {
        if (!is_array($part)) {

            $part = func_get_args();
        }

        $collect = [];

        if ($this->has('with')) {

            $collect = $this->get('with');
        }

        $this->put('with', array_merge($collect, $part));

        return $this;
    }

    /**
     * Make execute counter
     *
     * @param string $name
     * @param int $count_start
     * @return $this
     */
    public function counter(string $name, int $count_start = 0)
    {
        $collect = [];

        if ($this->has('counter')) {

            $collect = $this->get('counter');
        }

        $collect[$name] = $count_start;

        $this->put('counter', $collect);

        return $this;
    }

    /**
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return $this->parent->render();
    }
}
