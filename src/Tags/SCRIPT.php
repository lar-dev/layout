<?php

namespace Lar\Layout\Tags;

use Lar\Layout\Abstracts\Component;
use Lar\Tagable\Tag;

class SCRIPT extends Component
{
    /**
     * Tag element.
     *
     * @var string
     */
    protected $element = 'script';

    /**
     * Set path in to src for asset.
     *
     * @param  string  $path
     * @return $this|Component|Tag
     */
    public function asset($path)
    {
        $this->setSrc(asset($path));
        $this->attr('data-turbolinks-track', 'reload');

        return $this;
    }
}
