<?php

namespace Lar\Layout\Core;

use Lar\Tagable\Tag;

final class Dom
{
    /**
     * Collection recursive builder and imploding
     *
     * @return string
     * @throws \Exception
     */
    public static function buildCollect()
    {
        $html = Tag::$doctype;

        $closes = [];

        if (Tag::$collect) {

            foreach (Tag::$collect as $key => $item) {

                /** @var Tag $item */
                if (!$item->isRendered()) {

                    $html .= $item->render();

                    if ($item instanceof Tag && $item->opened_mode)
                        $closes[] = $item->getElement();
                }
            }

            foreach (array_reverse($closes) as $close)
            {
                $html .= Tag::$lecoe.$close.Tag::$rces;
            }
        }

        return $html;
    }

    /**
     * Tag storage
     *
     * @return \Illuminate\Support\Collection
     */
    public static function storage()
    {
        return Tag::$storage;
    }
}
