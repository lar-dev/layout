<?php

namespace Lar\Layout\Tags;

use Lar\Layout\Abstracts\Component;

class INPUT extends Component
{
    /**
     * Tag element
     *
     * @var string
     */
    protected $element = "input";

    /**
     * Rewrite input to the hidden state
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function hidden($name, $value)
    {
        $this->typeHidden()->setName($name)->setValue($value);

        return $this;
    }

    /**
     * @return $this
     */
    public function typeButton()
    {
        $this->setType("button");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeCheckbox()
    {
        $this->setType("checkbox");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeColor()
    {
        $this->setType("color");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeDate()
    {
        $this->setType("date");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeDatetimeLocal()
    {
        $this->setType("datetime-local");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeEmail()
    {
        $this->setType("email");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeFile()
    {
        $this->setType("file");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeHidden()
    {
        $this->setType("hidden");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeImage()
    {
        $this->setType("image");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeMonth()
    {
        $this->setType("month");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeNumber()
    {
        $this->setType("number");

        return $this;
    }

    /**
     * @return $this
     */
    public function typePassword()
    {
        $this->setType("password");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeRadio()
    {
        $this->setType("radio");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeRange()
    {
        $this->setType("range");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeReset()
    {
        $this->setType("reset");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeSearch()
    {
        $this->setType("search");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeTel()
    {
        $this->setType("tel");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeText()
    {
        $this->setType("text");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeTime()
    {
        $this->setType("time");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeUrl()
    {
        $this->setType("url");

        return $this;
    }

    /**
     * @return $this
     */
    public function typeWeek()
    {
        $this->setType("week");

        return $this;
    }
}
