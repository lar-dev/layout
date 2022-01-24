<?php

namespace Lar\Layout\Core;

use Lar\Tagable\Tag;

final class Dom
{
    /**
     * Collection recursive builder and imploding.
     *
     * @return string
     * @throws \Exception
     */
    public static function buildCollect()
    {
        $html = Tag::$doctype;

        if (Tag::$collect) {
            $html .= Tag::$collect->first()->render();
        }

        return $html;
    }

    /**
     * Tag storage.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function storage()
    {
        return Tag::$storage;
    }
}
