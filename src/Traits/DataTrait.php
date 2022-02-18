<?php

namespace Lar\Layout\Traits;

use Lar\Layout\Core\HTMLCustomCommand;

/**
 * Trait DataTrait.
 * @package Lar\Layout\Traits
 */
trait DataTrait
{
    /**
     * Data rules.
     * @var array
     */
    protected $data = [];

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click(string|array $command, $value = null)
    {
        return $this->addDataRule('click', $command, $value);
    }

    /**
     * @param  string  $event
     * @param  string|object|array  $command
     * @param  null  $value
     * @param  string  $param_type
     * @return $this
     */
    public function addDataRule(string $event, $command, $value = null, string $param_type = 'params')
    {
        if (is_array($command)) {

            $this->data[$event] = json_encode($command);

            return $this;
        }

        if (is_string($command) && class_exists($command)) {
            $val = [];

            if (is_array($value) ? $value : []) {
                $val = $value;
                $value = null;
            }

            $cmd = new $command($val);

            if ($cmd instanceof HTMLCustomCommand) {
                $command = $cmd->render();
            }
        } elseif (is_object($command)) {
            if ($command instanceof HTMLCustomCommand) {
                $command = $command->render();
            } else {
                return $this;
            }
        }

        if (is_array($value)) {
            foreach ($value as $key => $item) {
                if (is_array($item)) {
                    $value[$key] = json_encode($item);
                }
            }
            $value = implode(' && ', $value);
        }

        $value = (string) $value;

        $this->data[$event] = $command;

        if ($value) {
            $this->data["{$event}-{$param_type}"] = $value;
        }

        return $this;
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('click-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('click-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_get(string|array $command, $value = null)
    {
        return $this->addDataRule('click-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_post(string|array $command, $value = null)
    {
        return $this->addDataRule('click-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_put(string|array $command, $value = null)
    {
        return $this->addDataRule('click-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_head(string|array $command, $value = null)
    {
        return $this->addDataRule('click-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit(string|array $command, $value = null)
    {
        return $this->addDataRule('submit', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('submit-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('submit-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_get(string|array $command, $value = null)
    {
        return $this->addDataRule('submit-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_post(string|array $command, $value = null)
    {
        return $this->addDataRule('submit-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_put(string|array $command, $value = null)
    {
        return $this->addDataRule('submit-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_head(string|array $command, $value = null)
    {
        return $this->addDataRule('submit-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick(string|array $command, $value = null)
    {
        return $this->addDataRule('dblclick', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('dblclick-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('dblclick-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_get(string|array $command, $value = null)
    {
        return $this->addDataRule('dblclick-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_post(string|array $command, $value = null)
    {
        return $this->addDataRule('dblclick-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_put(string|array $command, $value = null)
    {
        return $this->addDataRule('dblclick-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_head(string|array $command, $value = null)
    {
        return $this->addDataRule('dblclick-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change(string|array $command, $value = null)
    {
        return $this->addDataRule('change', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('change-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('change-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_get(string|array $command, $value = null)
    {
        return $this->addDataRule('change-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_post(string|array $command, $value = null)
    {
        return $this->addDataRule('change-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_put(string|array $command, $value = null)
    {
        return $this->addDataRule('change-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_head(string|array $command, $value = null)
    {
        return $this->addDataRule('change-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur(string|array $command, $value = null)
    {
        return $this->addDataRule('blur', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('blur-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('blur-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_get(string|array $command, $value = null)
    {
        return $this->addDataRule('blur-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_post(string|array $command, $value = null)
    {
        return $this->addDataRule('blur-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_put(string|array $command, $value = null)
    {
        return $this->addDataRule('blur-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_head(string|array $command, $value = null)
    {
        return $this->addDataRule('blur-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus(string|array $command, $value = null)
    {
        return $this->addDataRule('focus', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('focus-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('focus-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_get(string|array $command, $value = null)
    {
        return $this->addDataRule('focus-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_post(string|array $command, $value = null)
    {
        return $this->addDataRule('focus-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_put(string|array $command, $value = null)
    {
        return $this->addDataRule('focus-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_head(string|array $command, $value = null)
    {
        return $this->addDataRule('focus-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange(string|array $command, $value = null)
    {
        return $this->addDataRule('formchange', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('formchange-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('formchange-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_get(string|array $command, $value = null)
    {
        return $this->addDataRule('formchange-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_post(string|array $command, $value = null)
    {
        return $this->addDataRule('formchange-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_put(string|array $command, $value = null)
    {
        return $this->addDataRule('formchange-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_head(string|array $command, $value = null)
    {
        return $this->addDataRule('formchange-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput(string|array $command, $value = null)
    {
        return $this->addDataRule('forminput', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('forminput-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('forminput-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_get(string|array $command, $value = null)
    {
        return $this->addDataRule('forminput-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_post(string|array $command, $value = null)
    {
        return $this->addDataRule('forminput-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_put(string|array $command, $value = null)
    {
        return $this->addDataRule('forminput-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_head(string|array $command, $value = null)
    {
        return $this->addDataRule('forminput-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input(string|array $command, $value = null)
    {
        return $this->addDataRule('input', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('input-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('input-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_get(string|array $command, $value = null)
    {
        return $this->addDataRule('input-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_post(string|array $command, $value = null)
    {
        return $this->addDataRule('input-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_put(string|array $command, $value = null)
    {
        return $this->addDataRule('input-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_head(string|array $command, $value = null)
    {
        return $this->addDataRule('input-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown(string|array $command, $value = null)
    {
        return $this->addDataRule('keydown', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('keydown-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('keydown-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_get(string|array $command, $value = null)
    {
        return $this->addDataRule('keydown-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_post(string|array $command, $value = null)
    {
        return $this->addDataRule('keydown-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_put(string|array $command, $value = null)
    {
        return $this->addDataRule('keydown-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_head(string|array $command, $value = null)
    {
        return $this->addDataRule('keydown-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress(string|array $command, $value = null)
    {
        return $this->addDataRule('keypress', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('keypress-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('keypress-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_get(string|array $command, $value = null)
    {
        return $this->addDataRule('keypress-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_post(string|array $command, $value = null)
    {
        return $this->addDataRule('keypress-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_put(string|array $command, $value = null)
    {
        return $this->addDataRule('keypress-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_head(string|array $command, $value = null)
    {
        return $this->addDataRule('keypress-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup(string|array $command, $value = null)
    {
        return $this->addDataRule('keyup', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('keyup-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('keyup-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_get(string|array $command, $value = null)
    {
        return $this->addDataRule('keyup-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_post(string|array $command, $value = null)
    {
        return $this->addDataRule('keyup-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_put(string|array $command, $value = null)
    {
        return $this->addDataRule('keyup-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_head(string|array $command, $value = null)
    {
        return $this->addDataRule('keyup-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown(string|array $command, $value = null)
    {
        return $this->addDataRule('mousedown', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('mousedown-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('mousedown-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_get(string|array $command, $value = null)
    {
        return $this->addDataRule('mousedown-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_post(string|array $command, $value = null)
    {
        return $this->addDataRule('mousedown-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_put(string|array $command, $value = null)
    {
        return $this->addDataRule('mousedown-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_head(string|array $command, $value = null)
    {
        return $this->addDataRule('mousedown-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove(string|array $command, $value = null)
    {
        return $this->addDataRule('mousemove', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('mousemove-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('mousemove-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_get(string|array $command, $value = null)
    {
        return $this->addDataRule('mousemove-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_post(string|array $command, $value = null)
    {
        return $this->addDataRule('mousemove-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_put(string|array $command, $value = null)
    {
        return $this->addDataRule('mousemove-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_head(string|array $command, $value = null)
    {
        return $this->addDataRule('mousemove-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseout', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseout-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseout-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_get(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseout-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_post(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseout-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_put(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseout-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_head(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseout-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseover', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseover-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseover-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_get(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseover-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_post(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseover-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_put(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseover-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_head(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseover-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseup', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseup-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseup-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_get(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseup-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_post(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseup-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_put(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseup-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_head(string|array $command, $value = null)
    {
        return $this->addDataRule('mouseup-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel(string|array $command, $value = null)
    {
        return $this->addDataRule('mousewheel', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('mousewheel-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('mousewheel-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_get(string|array $command, $value = null)
    {
        return $this->addDataRule('mousewheel-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_post(string|array $command, $value = null)
    {
        return $this->addDataRule('mousewheel-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_put(string|array $command, $value = null)
    {
        return $this->addDataRule('mousewheel-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_head(string|array $command, $value = null)
    {
        return $this->addDataRule('mousewheel-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover(string|array $command, $value = null)
    {
        return $this->addDataRule('hover', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('hover-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('hover-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_get(string|array $command, $value = null)
    {
        return $this->addDataRule('hover-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_post(string|array $command, $value = null)
    {
        return $this->addDataRule('hover-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_put(string|array $command, $value = null)
    {
        return $this->addDataRule('hover-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_head(string|array $command, $value = null)
    {
        return $this->addDataRule('hover-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load(string|array $command, $value = null)
    {
        return $this->addDataRule('load', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_jax(string|array $command, $value = null)
    {
        return $this->addDataRule('load-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_delete(string|array $command, $value = null)
    {
        return $this->addDataRule('load-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_get(string|array $command, $value = null)
    {
        return $this->addDataRule('load-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_post(string|array $command, $value = null)
    {
        return $this->addDataRule('load-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_put(string|array $command, $value = null)
    {
        return $this->addDataRule('load-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_head(string|array $command, $value = null)
    {
        return $this->addDataRule('load-head', $command, $value);
    }
}
