<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Lar\Layout\Executor;
use Lar\Tagable\Tag;

/**
 * Class compList
 *
 * @package Lar\Layout\Commands\Component
 */
class JaxList extends Command
{
    /**
     * @var string
     */
    protected $signature = "jax:list {--name= : Enter show nane}";

    /**
     * @var string
     */
    protected $description = "Executor list";

    /**
     * Handler
     */
    public function handle () {

        $list = collect(Executor::executorList());

        $i = 0;

        $this->table(["№", "Name", "Class"], $list->map(function ($item, $key) use (&$i) {

            $i++;

            return [
                $i,
                $key,
                $item
            ];
        }));
    }
}
