<?php

namespace Lar\Layout\Tags;

use Lar\Layout\Abstracts\Component;

class BUTTON extends Component
{
    /**
     * Tag element.
     *
     * @var string
     */
    protected $element = 'button';

    /**
     * @param  string|null  $method
     * @return $this
     */
    public function queryMethod(string $method = null)
    {
        if ($method) {
            $this->location(['method' => $method]);
        } else {
            $this->location([], ['method']);
        }

        return $this;
    }

    /**
     * @param  array  $params
     * @param  array  $unset
     * @return $this
     */
    public function location(array $params = [], array $unset = [])
    {
        $this->on_click('doc::location', urlWithGet($params, $unset));

        return $this;
    }

    /**
     * @param  string|array  $name
     * @param  int  $value
     * @return $this
     */
    public function switchQuery(string|array $name, $value = 1)
    {
        if (request()->has($name)) {
            $this->location([], (array)$name);
        } else {
            $this->location(array_fill_keys((array)$name, $value));
        }

        return $this;
    }

    public function setQuery(string|array $name, $value = 1)
    {
        $this->location(array_fill_keys((array)$name, $value));
        return $this;
    }

    public function forgetQuery(string|array $name)
    {
        $this->location([], (array)$name);
        return $this;
    }
}
