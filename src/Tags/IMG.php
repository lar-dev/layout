<?php

namespace Lar\Layout\Tags;

use Lar\Layout\Abstracts\Component;

class IMG extends Component
{
    /**
     * Tag element
     *
     * @var string
     */
    protected $element = "img";

    /**
     * Set asset src
     *
     * @param $path
     * @return $this
     */
    public function asset($path)
    {
        $this->setSrc(asset($path));

        return $this;
    }
}
