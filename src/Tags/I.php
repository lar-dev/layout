<?php

namespace Lar\Layout\Tags;

use Lar\Layout\Abstracts\Component;
use Lar\Layout\Traits\FontAwesome;

class I extends Component
{
    use FontAwesome;

    /**
     * Tag element
     *
     * @var string
     */
    protected $element = "i";

    /**
     * @param  string  $icon
     * @return $this
     */
    public function icon(string $icon)
    {
        $this->attr('class', $icon);

        return $this;
    }
}