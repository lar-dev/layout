<?php

namespace Lar\Layout\Respond;

use Illuminate\Contracts\Support\Renderable;
use Lar\Tagable\Tag;

/**
 * Trait jQueryDecoratorTrait
 *
 * @package Lar\Layout\Respond
 */
trait jQueryDecoratorTrait
{
    /**
     * New jQuery decorator
     *
     * @param  string|null  $selector
     * @return \Lar\Layout\Respond\jQuery
     */
    public function jq(string $selector = null)
    {
        return new jQuery($this, $selector);
    }

    /**
     * Submit parent form
     *
     * @return \Lar\Layout\Respond
     */
    public function submit()
    {
        return $this->jq('parent:form')->submit()->respond;
    }
}
