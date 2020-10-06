<?php

if (!function_exists('exe')) {

    /**
     * @param string|null $command
     * @param null $param
     * @return \Lar\Layout\Respond
     */
    function exe(string $command = null, $param = null) {

        $return = respond(true);

        if ($command) {

            $return->put($command, $param);
        }

        return $return;
    }
}

if (!function_exists('respond')) {

    /**
     * @param bool $new
     * @return \Lar\Layout\Respond
     */
    function respond(bool $new = false) {

        if ($new) {

            return new \Lar\Layout\Respond();
        }

        else {

            return \Lar\Layout\Respond::glob();
        }
    }
}

if (!function_exists('remake_lang_url')) {

    /**
     * @param string $lang
     * @param string|null $url
     * @return string
     */
    function remake_lang_url(string $lang, string $url = null) {

        if (!$url) {

            $url = url()->current();
        }

        return preg_replace("/(.*\:\/\/.*\/)(".\App::getLocale().")(.*)/", "$1{$lang}$3", $url);
    }
}
