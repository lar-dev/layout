<?php

namespace Lar\Layout\Respond;

/**
 * Trait jQueryDecoratorTrait
 *
 * @package Lar\Layout\Respond
 */
trait AlertSystemsTrait
{
    /**
     * toast:success
     *
     * @param $text
     * @param null $title
     * @return $this
     */
    public function toast_success($text, $title = null)
    {
        return $this->toast("success", $text, $title);
    }

    /**
     * toast:warning
     *
     * @param $text
     * @param null $title
     * @return $this
     */
    public function toast_warning($text, $title = null)
    {
        return $this->toast("warning", $text, $title);
    }

    /**
     * toast:info
     *
     * @param $text
     * @param null $title
     * @return $this
     */
    public function toast_info($text, $title = null)
    {
        return $this->toast("info", $text, $title);
    }

    /**
     * toast:error
     *
     * @param $text
     * @param null $title
     * @return $this
     */
    public function toast_error($text, $title = null)
    {
        return $this->toast("error", $text, $title);
    }

    /**
     * @param $type
     * @param $text
     * @param null $title
     * @return $this
     */
    public function toast($type, $text, $title = null)
    {
        $this->put("toast::{$type}", $title ? [[__($text), __($title)]] : __($text));

        return $this;
    }
}