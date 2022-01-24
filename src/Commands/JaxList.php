<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Lar\LJS\JaxController;

/**
 * Class compList.
 *
 * @package Lar\Layout\Commands\Component
 */
class JaxList extends Command
{
    /**
     * @var string
     */
    protected $signature = 'jax:list';

    /**
     * @var string
     */
    protected $description = 'Executor list';

    /**
     * Handler.
     */
    public function handle()
    {
        $list = collect(JaxController::$list);

        $i = 0;

        $this->table(['№', 'Name', 'Class'], $list->map(function ($item, $key) use (&$i) {
            $i++;

            return [
                $i,
                $key,
                $item,
            ];
        }));
    }
}
