<?php

namespace Lar\Layout\Tags;

use Exception;
use Lar\Layout\Abstracts\Component;

class A extends Component
{
    /**
     * Tag element.
     *
     * @var string
     */
    protected $element = 'a';

    /**
     * Set href by rout name.
     *
     * @param $route
     * @param  array  $params
     * @return $this
     */
    public function route($route, $params = [])
    {
        $this->setHref(route($route, $params));

        return $this;
    }

    /**
     * Set href asset.
     *
     * @param  string  $url
     * @return $this|Component
     */
    public function asset($url)
    {
        $this->setHref(asset($url));

        return $this;
    }

    /**
     * Set Target blank attribute.
     *
     * @return $this
     * @throws Exception
     */
    public function targetBlank()
    {
        $this->attr('target', '_blank');

        return $this;
    }

    /**
     * Set onclick attribute.
     *
     * @param  string  $value
     * @return $this|Component
     * @throws Exception
     */
    public function setOnclick($value = '')
    {
        $this->setHref(':js');

        $this->attr('onclick', $value);

        return $this;
    }

    /**
     * Set no Pjax state from "a" tag.
     *
     * @return $this
     * @throws Exception
     */
    public function noPjax()
    {
        $this->attr(['no-pjax' => '']);

        return $this;
    }

    /**
     * Set empty click.
     *
     * @return $this
     */
    public function emptyClick()
    {
        $this->setHref(':js');

        return $this;
    }
}
