<?php

namespace Lar\Layout\Tags;

use Exception;
use Lar\Layout\Abstracts\Component;

class TABLE extends Component
{
    /**
     * Tag element.
     *
     * @var string
     */
    protected $element = 'table';

    /**
     * TABLE constructor.
     *
     * @param  mixed  ...$params
     * @throws Exception
     */
    public function __construct(...$params)
    {
        parent::__construct();

        $this->when($params);
    }
}
