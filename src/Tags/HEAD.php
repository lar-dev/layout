<?php

namespace Lar\Layout\Tags;

use Lar\Layout\Abstracts\Component;

class HEAD extends Component
{
    /**
     * Tag element.
     *
     * @var string
     */
    protected $element = 'head';

    /**
     * Create charset meta tag.
     *
     * @param string $charset
     * @return $this
     */
    public function charset($charset = 'utf-8')
    {
        $this->meta()->setCharset($charset);

        return $this;
    }

    /**
     * Create csrf token meta tag.
     *
     * @return $this
     */
    public function csrfToken()
    {
        $this->meta()->setName('csrf-token')->setContent(csrf_token());

        return $this;
    }
}
