<?php

namespace Lar\Layout\Traits;

/**
 * Trait DataTrait
 * @package Lar\Layout\Traits
 */
trait DataTrait {

    /**
     * Data rules
     * @var array
     */
    protected $data = [];

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_hover_jax(string $command, $value = null)
    {
        return $this->addDataRule('hover-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_hover(string $command, $value = null)
    {
        return $this->addDataRule('hover', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mousewheel_jax(string $command, $value = null)
    {
        return $this->addDataRule('mousewheel-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mousewheel(string $command, $value = null)
    {
        return $this->addDataRule('mousewheel', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mouseup_jax(string $command, $value = null)
    {
        return $this->addDataRule('mouseup-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mouseup(string $command, $value = null)
    {
        return $this->addDataRule('mouseup', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mouseout_jax(string $command, $value = null)
    {
        return $this->addDataRule('mouseout-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mouseout(string $command, $value = null)
    {
        return $this->addDataRule('mouseout', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mousemove_jax(string $command, $value = null)
    {
        return $this->addDataRule('mousemove-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mousemove(string $command, $value = null)
    {
        return $this->addDataRule('mousemove', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mousedown_jax(string $command, $value = null)
    {
        return $this->addDataRule('mousedown-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_mousedown(string $command, $value = null)
    {
        return $this->addDataRule('mousedown', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_keyup_jax(string $command, $value = null)
    {
        return $this->addDataRule('keyup-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_keyup(string $command, $value = null)
    {
        return $this->addDataRule('keyup', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_keypress_jax(string $command, $value = null)
    {
        return $this->addDataRule('keypress-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_keypress(string $command, $value = null)
    {
        return $this->addDataRule('keypress', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_keydown_jax(string $command, $value = null)
    {
        return $this->addDataRule('keydown-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_keydown(string $command, $value = null)
    {
        return $this->addDataRule('keydown', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_input_jax(string $command, $value = null)
    {
        return $this->addDataRule('input-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_input(string $command, $value = null)
    {
        return $this->addDataRule('input', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_forminput_jax(string $command, $value = null)
    {
        return $this->addDataRule('forminput-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_forminput(string $command, $value = null)
    {
        return $this->addDataRule('forminput', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_formchange_jax(string $command, $value = null)
    {
        return $this->addDataRule('formchange-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_formchange(string $command, $value = null)
    {
        return $this->addDataRule('formchange', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_focus_jax(string $command, $value = null)
    {
        return $this->addDataRule('focus-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_focus(string $command, $value = null)
    {
        return $this->addDataRule('focus', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_blur_jax(string $command, $value = null)
    {
        return $this->addDataRule('blur-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_blur(string $command, $value = null)
    {
        return $this->addDataRule('blur', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_change_jax(string $command, $value = null)
    {
        return $this->addDataRule('change-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_change(string $command, $value = null)
    {
        return $this->addDataRule('change', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_dblclick_jax(string $command, $value = null)
    {
        return $this->addDataRule('dblclick-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_dblclick(string $command, $value = null)
    {
        return $this->addDataRule('dblclick', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_submit_jax(string $command, $value = null)
    {
        return $this->addDataRule('submit-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_submit(string $command, $value = null)
    {
        return $this->addDataRule('submit', $command, $value);
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_click_jax(string $command, $value = null)
    {
        return $this->addDataRule('click-jax', $command, $value, 'props');
    }

    /**
     * @param  string  $command
     * @param  null  $value
     * @return $this
     */
    public function on_click(string $command, $value = null)
    {
        return $this->addDataRule('click', $command, $value);
    }

    /**
     * @param  string  $event
     * @param  string  $command
     * @param  null  $value
     * @param  string  $param_type
     * @return $this
     */
    public function addDataRule(string $event, string $command, $value = null, string $param_type = "params")
    {
        if (is_array($value)) {
            $value = implode(" && ", $value);
        }

        $value = (string)$value;

        $this->data[$event] = $command;

        if ($value) {

            $this->data["{$event}-{$param_type}"] = $value;
        }

        return $this;
    }
}