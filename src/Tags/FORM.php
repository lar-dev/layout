<?php

namespace Lar\Layout\Tags;

use Exception;
use Lar\Layout\Abstracts\Component;
use Lar\Tagable\Events\onRender;

/**
 * Class FORM.
 * @package Lar\Layout\Tags
 */
class FORM extends Component implements onRender
{
    /**
     * Tag element.
     *
     * @var string
     */
    protected $element = 'form';

    /**
     * Function execute on render component.
     *
     * @return mixed
     * @throws Exception
     */
    public function onRender()
    {
        if (!$this->hasAttribute('method')) {
            $this->setMethod('get');
        }
    }

    /**
     * Restore component in to log uot form.
     */
    public function logOutForm()
    {
        $this->route('logout')->post()->setId('logout-form')->hide();
    }

    /**
     * Set POST Method.
     *
     * @return $this
     */
    public function post()
    {
        $this->setMethod('post');

        return $this;
    }

    /**
     * Set action by rout name.
     *
     * @param $route
     * @param  array  $parameters
     * @param  bool  $absolute
     * @return $this
     */
    public function route($route, $parameters = [], $absolute = true)
    {
        $this->setAction(route($route, $parameters, $absolute));

        return $this;
    }

    /**
     * Set action asset.
     *
     * @param  string  $url
     * @return $this|Component
     */
    public function asset($url)
    {
        $this->setAction(asset($url));

        return $this;
    }
}
