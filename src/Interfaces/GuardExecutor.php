<?php

namespace Lar\Layout\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface GuardExecutor
 *
 * @package Lar\Layout\Intefaces
 */
interface GuardExecutor
{
    /**
     * Defender in all methods. In order to create an exception,
     * you must create a public property (public $un_guard = ["method_name"]) with an array of names.
     * Then this method will be checked only according to the instructions described below.
     *
     * In order to create a defender only for a method,
     * use the instruction (method_name => guard_method_name)
     *
     * @param Request $request
     * @return bool
     */
    public function guard_executor(Request $request) : bool;
}
