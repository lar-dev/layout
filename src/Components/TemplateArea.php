<?php

namespace Lar\Layout\Components;

use Lar\Layout\Tags\SPAN;

/**
 * Class Template
 * @package Lar\LteAdmin\Components
 */
class TemplateArea extends SPAN
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