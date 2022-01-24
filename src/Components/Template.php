<?php

namespace Lar\Layout\Components;

/**
 * Class Template.
 * @package Lar\LteAdmin\Components
 */
class Template extends \Lar\Layout\Tags\TEMPLATE
{
    /**
     * Col constructor.
     * @param  string|null  $id
     * @param  mixed  ...$params
     */
    public function __construct(string $id, ...$params)
    {
        parent::__construct();

        $this->setDatas(['tpl' => $id]);

        $this->when($params);
    }
}
