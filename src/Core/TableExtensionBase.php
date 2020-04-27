<?php

namespace Lar\Layout\Core;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Lar\Layout\Tags\TD;
use Lar\Layout\Tags\TR;

abstract class TableExtensionBase implements Renderable
{

    /**
     * @var Model|array|string|int
     */
    public $row;

    /**
     * @var TD
     */
    public $td;

    /**
     * @var TR
     */
    public $tr;

    /**
     * @var mixed
     */
    protected $field;

    /**
     * TableTest constructor.
     *
     * @param $field
     */
    public function __construct($field = "id")
    {

        $this->field = $field;
    }

    /**
     * Get row field
     *
     * @return array|Model|int|mixed|string
     */
    public function rowField () {

        if (is_array($this->row) || is_object($this->row)) {

            return multi_dot_call($this->row, $this->field);
        }

        else {

            return $this->row;
        }
    }

    /**
     * Injected row getter
     *
     * @param string|null $name
     * @param null $default
     * @return array|Model|int|mixed|string|null
     */
    public function row(string $name = null, $default = null)
    {
        if ($name) {

            if ((is_array($this->row) || is_object($this->row)) && isset($this->row[$name])) {

                return $this->row[$name];
            }

            else {

                return $default;
            }
        }

        return $this->row;
    }

    /**
     * Injected model getter
     *
     * @return array|Model|int|string
     */
    public function model()
    {
        if ($this->row instanceof Model) {

            return $this->row;
        }

        else {

            new \Exception("This function only from Model injects, sorry! Use the \"row()\" method");
        }
    }
}
