<?php

namespace Lar\Layout\Components;

use Lar\Layout\Abstracts\Component;

/**
 * Class CSS
 * @package Lar\Layout\Components
 * @component cssLink
 */
class CSS extends Component
{
    /**
     * Tag element
     *
     * @var string
     */
    protected $element = "link";

    /**
     * Script constructor.
     *
     * @param null $href
     * @throws \Exception
     */
    public function __construct($href = null)
    {
        parent::__construct();

        $this->setRel("stylesheet");
        $this->setType("text/css");
        $this->attr('data-turbolinks-track', 'reload');

        if ($href) $this->setHref($href);
    }

    /**
     * Set href by asset
     *
     * @param string $path
     * @return $this|Component
     */
    public function asset($path)
    {
        $this->setHref(asset($path));

        return $this;
    }
}
