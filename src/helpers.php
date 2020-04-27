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

if (! function_exists("config_file_wrapper")) {

    /**
     * File config wrapper from save
     *
     * @param array $data
     * @param bool $compress
     * @param int $max_chars
     * @return string
     */
    function config_file_wrapper(array $data = [], bool $compress = false, int $max_chars = 0)
    {
        return array_entity($data)->setMinimized($compress)->setMaxChars($max_chars)->wrap('php:return')->render();
    }
}

if (!function_exists("pars_description_from_doc")) {

    /**
     * Pars PHP Doc for getting the description in one line.
     *
     * @param string|\Illuminate\Contracts\Support\Renderable $doc
     * @param string $glue
     * @return string
     */
    function pars_description_from_doc($doc, string $glue = " ") {

        return \Lar\EntityCarrier\Core\Entities\DocumentorEntity::parseDescription($doc, $glue);
    }
}

if (!function_exists("pars_return_from_doc")) {

    /**
     * Pars RETURN.
     *
     * @param string|\Illuminate\Contracts\Support\Renderable $doc
     * @return string
     */
    function pars_return_from_doc($doc) {

        return \Lar\EntityCarrier\Core\Entities\DocumentorEntity::parseReturn($doc);
    }
}

if (!function_exists('refl_param_entity')) {

    /**
     * @param ReflectionParameter $item
     * @param bool $no_types
     * @param bool $no_values
     * @return string
     */
    function refl_param_entity (\ReflectionParameter $item, $no_types = false, $no_values = false) {

        return \Lar\EntityCarrier\Core\Entities\ParamEntity::buildFromReflection($item, $no_types, $no_values)->render();
    }
}

if (!function_exists('refl_params_entity')) {

    /**
     * @param array|\ReflectionParameter|\ReflectionFunction|\ReflectionMethod|\Closure $params
     * @param bool $no_types
     * @param bool $no_values
     * @return string
     */
    function refl_params_entity($params, $no_types = false, $no_values = false) {

        return \Lar\EntityCarrier\Core\Entities\ParamEntity::buildFromReflection($params, $no_types, $no_values)->render();
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
