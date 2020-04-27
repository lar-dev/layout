<?php

namespace Lar\Layout;

use Illuminate\Http\Request;

/**
 * Class AjaxExecutor
 *
 * @package Lar\Layout
 */
abstract class JaxExecutor extends RespondDoc
{
    /**
     * Response status
     *
     * @var int
     */
    protected $status = 200;

    /**
     * Response headers
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Response data
     *
     * @var array
     */
    protected $response = [];

    /**
     * Stop point
     *
     * @var bool
     */
    private $stop = false;

    /**
     * Executor respond
     *
     * @var Respond
     */
    static $respond;

    /**
     * No guard methods
     *
     * @var array
     */
    public $un_guard = [];

    /**
     * @var bool
     */
    static $name = false;

    /**
     * @var Request
     */
    public $request;

    public function validate($validate_data, array $validate_rules, array $messages = [])
    {

    }

    /**
     * Request accessor
     *
     * @return Request
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * Executor response
     *
     * @return array
     */
    public function response() : array {

        return $this->response;
    }

    /**
     * Response status getter
     *
     * @return int
     */
    public function getResponseStatus(): int
    {
        return $this->status;
    }

    /**
     * Response headers getter
     *
     * @return array
     */
    public function getResponseHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Add response
     *
     * @param $data
     * @return $this
     */
    public function addToResponse($data)
    {
        $this->response = array_merge_recursive($this->response, $data);

        return $this;
    }

    /**
     * Set stop marker
     *
     * @param array $stopResponse
     * @return $this
     */
    public function stop($stopResponse = [])
    {
        $this->addToResponse($stopResponse);

        $this->status = 410;

        $this->stop = true;

        return $this;
    }

    /**
     * Check stop marker
     *
     * @return bool
     */
    public function isStop()
    {
        return $this->stop;
    }
    /**
     * Put rule
     *
     * @param $key
     * @param mixed $value
     * @return $this
     */
    public function put($key, $value = null)
    {
        static::respond()->put($key, $value);

        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {

        return static::respond()->{$name}(...$arguments);
    }

    /**
     * @return Respond
     */
    static function respond () {

        if (!static::$respond) {

            static::$respond = new Respond();
        }

        return static::$respond;
    }
}
