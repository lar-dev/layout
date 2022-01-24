<?php

namespace Lar\Layout\Respond;

/**
 * Trait Systems.
 *
 * @package Lar\Layout\Respond
 */
trait Vue
{
    /**
     * @return $this
     */
    public function vue()
    {
        $this->put('vue::init');

        return $this;
    }
}
