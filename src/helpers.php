<?php

use Lar\Layout\Respond;

if (!function_exists('exe')) {
    /**
     * @param  string|null  $command
     * @param  null  $param
     * @return Respond
     */
    function exe(string $command = null, $param = null)
    {
        $return = respond(true);

        if ($command) {
            $return->put($command, $param);
        }

        return $return;
    }
}

if (!function_exists('respond')) {
    /**
     * @param  bool  $new
     * @return Respond
     */
    function respond(bool $new = false)
    {
        if ($new) {
            return new Respond();
        } else {
            return Respond::glob();
        }
    }
}

if (!function_exists('remake_lang_url')) {
    /**
     * @param  string  $lang
     * @param  string|null  $url
     * @return string
     */
    function remake_lang_url(string $lang, string $url = null)
    {
        if (!$url) {
            $url = url()->current();
        }

        return preg_replace("/(.*\:\/\/.*\/)(".App::getLocale().')(.*)/', "$1{$lang}$3", $url);
    }
}

if (!function_exists('is_embedded_call')) {
    /**
     * @param  mixed  $subject
     * @return bool
     */
    function is_embedded_call($subject)
    {
        return is_string($subject) ? class_exists($subject) : is_callable($subject);
    }
}
