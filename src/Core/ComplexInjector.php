<?php

namespace Lar\Layout\Core;

use Lar\Layout\Executor;
use Lar\Layout\Layout;
use Lar\Tagable\Tag;

class ComplexInjector {

    /**
     * ComplexInjector constructor.
     *
     * @param array $complex
     */
    public function __construct(array $complex)
    {
        foreach ($complex as $method => $data) {

            if (method_exists($this, $method)) {

                $this->{$method}($data);
            }
        }
    }

    /**
     * @param array $data
     */
    public function components(array $data)
    {
        Tag::injectCollection($data, true);
    }

    /**
     * @param array $data
     */
    public function layouts(array $data)
    {
        Layout::injectCollection($data);
    }

    /**
     * @param array $data
     */
    public function jax_executors(array $data)
    {
        Executor::injectCollection($data);
    }
}
