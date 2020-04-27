<?php

namespace Lar\Layout\Tags;

use Lar\Layout\Abstracts\Component;
use Lar\Layout\Core\Dom;
use Lar\Tagable\Events\onRender;

/**
 * Class FORM
 * @package Lar\Layout\Tags
 */
class FORM extends Component implements onRender
{
    /**
     * Tag element
     *
     * @var string
     */
    protected $element = "form";

    /**
     * Function execute on render component
     *
     * @return mixed
     * @throws \Exception
     */
    public function onRender()
    {
        if (!$this->hasAttribute('method')) {

            $this->setMethod("get");
        }

        if (strtolower($this->getAttribute("method")) != 'get') {

            $this->appEnd(csrf_field());
        }
    }

    /**
     * Add hiddens inputs
     *
     * @param array $hidden_datas
     */
    public function hiddens(array $hidden_datas)
    {
        foreach ($hidden_datas as $name => $value) {

            $this->input()->hidden($name, $value);
        }
    }

    /**
     * Set action by rout name
     *
     * @param $route
     * @param array $parameters
     * @param bool $absolute
     * @return $this
     */
    public function route($route, $parameters = [], $absolute = true)
    {
        $this->setAction(route($route, $parameters, $absolute));

        return $this;
    }

    /**
     * Set POST Method
     *
     * @return $this
     */
    public function post()
    {
        $this->setMethod("post");

        return $this;
    }

    /**
     * Restore component in to log uot form
     */
    public function logOutForm()
    {
        $this->route("logout")->post()->setId("logout-form")->hide();
    }

    /**
     * Set action asset
     *
     * @param string $url
     * @return $this|Component
     */
    public function asset($url)
    {
        $this->setAction(asset($url));

        return $this;
    }
}
