<?php

namespace Lar\Layout\Traits;

use Lar\Layout\Respond;

/**
 * Trait LjsDataAttributes
 * @package Lar\Layout\Traits
 */
trait LjsDataAttributes
{
    /**
     * @param  string|null  $command
     * @param  array  $props
     * @return Respond
     */
    public function dataClick(string $command = null, $props = [])
    {
        if ($this->hasAttribute('data-click')) {

            $respond = $this->getAttribute('data-click');
        }

        else {

            $respond = new Respond();
        }

        if ($command) {

            $respond->put($command, $props);
        }

        $this->setDatas(['click' => $respond]);

        return $respond;
    }

    /**
     * @param  string|null  $command
     * @param  array  $props
     * @return Respond
     */
    public function dataLoad(string $command = null, $props = [])
    {
        if ($this->hasAttribute('data-load')) {

            $respond = $this->getAttribute('data-load');
        }

        else {

            $respond = new Respond();
        }

        if ($command) {

            $respond->put($command, $props);
        }

        $this->setDatas(['load' => $respond]);

        return $respond;
    }
}
