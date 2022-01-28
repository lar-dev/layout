<?php

namespace Lar\Layout\Core;

use Exception;
use Illuminate\Support\Collection;
use Lar\Tagable\Tag;

final class Dom
{
    /**
     * Collection recursive builder and imploding.
     *
     * @return string
     * @throws Exception
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
     * @return Collection
     */
    public static function storage()
    {
        return Tag::$storage;
    }
}
