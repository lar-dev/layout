<?php

namespace Lar\Layout\Tags;

use Lar\Layout\Abstracts\Component;

class HTML extends Component
{
    /**
     * Tag element.
     *
     * @var string
     */
    protected $element = 'html';

    /**
     * HTML constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->setLang(\App::getLocale());
    }
}
