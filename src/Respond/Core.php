<?php

namespace Lar\Layout\Respond;

use Lar\Layout\Respond;

/**
 * Trait Core
 *
 * @package Lar\Layout\Respond
 */
trait Core {

    /**
     * Global instance
     *
     * @var Respond
     */
    private static $instance_glob;

    /**
     * Access to global instance
     *
     * @return Respond
     */
    static function glob() {

        if (!static::$instance_glob) {

            static::$instance_glob = new Respond();
        }

        return static::$instance_glob;
    }
}
