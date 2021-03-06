<?php

namespace Lar\Layout\Components;

use Exception;

/**
 * Class Script.
 *
 * @package Lar\Layout\Components
 * @component linkScript2
 */
class Script extends \Lar\Layout\Tags\SCRIPT
{
    /**
     * Tag element.
     *
     * @var string
     */
    protected $element = 'script';

    /**
     * Script constructor.
     *
     * @param  null  $src
     * @throws Exception
     */
    public function __construct($src = null)
    {
        parent::__construct();

        if ($src) {
            $this->setSrc($src);
            $this->attr('data-turbolinks-track', 'reload');
        }
    }
}
