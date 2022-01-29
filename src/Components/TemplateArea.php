<?php

namespace Lar\Layout\Components;

use Lar\Layout\Tags\SPAN;

class TemplateArea extends SPAN
{
    /**
     * Col constructor.
     * @param  string|null  $id
     * @param  bool  $autoload
     * @param  mixed  ...$params
     */
    public function __construct(string $id, bool $autoload = false, ...$params)
    {
        parent::__construct();

        $data = ['tpl' => $id];

        if ($autoload) {
            $data['load'] = 'tpl::replaceTo';

            $data['load-params'] = $id;
        }

        $this->setDatas($data);

        $this->when($params);
    }
}
