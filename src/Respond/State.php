<?php

namespace Lar\Layout\Respond;

/**
 * Trait Systems.
 *
 * @package Lar\Layout\Respond
 */
trait State
{
    /**
     * @param  string  $name
     * @param $value
     * @return $this
     */
    public function state(string $name, $value)
    {
        $this->put('$state.set', [$name, $value]);

        return $this;
    }

    /**
     * @param  string  $name
     * @param $value
     * @return $this
     */
    public function state_delete(string $name)
    {
        $this->put('$state.delete', $name);

        return $this;
    }
}
