<?php

namespace Lar\Layout\Respond;

use Lar\Layout\Respond;
use Route;

/**
 * Trait Systems.
 *
 * @package Lar\Layout\Respond
 */
trait Systems
{
    /**
     * @param $data
     * @return $this
     */
    public function console_error($data)
    {
        $this->put('ljs._error', $data);

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function console_info($data)
    {
        $this->put('ljs._info', $data);

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function console_log($data)
    {
        $this->put('ljs._log', $data);

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function console_warn($data)
    {
        $this->put('ljs._warn', $data);

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function console_clear()
    {
        $this->put('console.clear');

        return $this;
    }

    /**
     * @param $link
     * @param  array  $params
     * @param  bool  $absolute
     * @return $this
     */
    public function change_link($link, array $params = [], bool $absolute = true)
    {
        if (Route::has($link)) {
            $link = route($link, $params, $absolute);
        }

        $this->put('ljs.$nav.change_url', $link);

        return $this;
    }

    /**
     * @param  int  $ms
     * @return Respond
     */
    public function time_out(int $ms)
    {
        $respond = new Respond($this->parent);

        $this->put('timer::out', [$ms => $respond]);

        return $respond;
    }
}
