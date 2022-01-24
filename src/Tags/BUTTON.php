<?php

namespace Lar\Layout\Tags;

use Lar\Layout\Abstracts\Component;
use Lar\LteAdmin\Components\ButtonsContent;

class BUTTON extends Component
{
    /**
     * Tag element.
     *
     * @var string
     */
    protected $element = 'button';

    /**
     * @param  array  $params
     * @param  array  $unset
     * @return $this
     */
    public function location(array $params = [], array $unset = [])
    {
        $this->on_click('doc::location', urlWithGet($params, $unset));

        return $this;
    }

    /**
     * @param  string|null  $method
     * @return $this
     */
    public function toPageMethod(string $method = null)
    {
        if ($method) {
            $this->location(['method' => $method]);
        } else {
            $this->location([], ['method']);
        }

        return $this;
    }
}
