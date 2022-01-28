<?php

namespace Lar\Layout\Commands;

use Exception;
use Illuminate\Console\Command;
use Lar\Tagable\Tag;
use Psr\SimpleCache\InvalidArgumentException;
use Str;

/**
 * Class compList.
 *
 * @package Lar\Layout\Commands\Component
 */
class ComponentList extends Command
{
    /**
     * @var string
     */
    protected $signature = 'component:list';

    /**
     * @var string
     */
    protected $description = 'Component list';

    /**
     * Handler.
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function handle()
    {
        $list = Tag::$components;

        $i = 0;

        $this->table(['№', 'Name', 'Blade Name', 'Class'], $list->map(function ($item, $key) use (&$i) {
            $i++;

            $vue = (property_exists($item, 'is_vue'));

            return [
                $vue ? "<info>{$i}</info>" : $i,
                $vue ? "<info>{$key}</info>" : $key,
                $vue ? '<info>'.Str::camel($key).'</info>' : Str::camel($key),
                $vue ? "<info>Vue:{$item}</info>" : $item,
            ];
        }));
    }
}
