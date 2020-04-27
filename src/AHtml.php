<?php

namespace Lar\Layout;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Lar\Layout\Core\AHtmlCompiler;

/**
 * Class AHtml
 *
 * @package App\Layouts
 */
class AHtml implements Renderable, Htmlable
{
    /**
     * @var array
     */
    private $data;

    /**
     * AHtml constructor.
     *
     * @param string $condition
     * @throws \Exception
     */
    public function __construct(string $condition)
    {
        try {
            $this->data = eval("return {$condition};");
        }
        catch (\Exception $exception) {

            dd($exception);
        }

        if ($this->data instanceof Arrayable) {

            $this->data = $this->data->toArray();
        }

        if (!is_array($this->data)) {

            throw new \Exception("Undefined conditions!");
        }
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return AHtmlCompiler::compile($this->data);
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param string $condition
     * @return AHtml
     * @throws \Exception
     */
    public static function create(string $condition)
    {
        return new static($condition);
    }
}
