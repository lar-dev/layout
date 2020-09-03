<?php

namespace Lar\Layout\Traits;

use Lar\Layout\Core\HTMLCustomCommand;

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
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click(string $command, $value = null) {
        return $this->addDataRule('click', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_jax(string $command, $value = null) {
        return $this->addDataRule('click-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_delete(string $command, $value = null) {
        return $this->addDataRule('click-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_get(string $command, $value = null) {
        return $this->addDataRule('click-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_post(string $command, $value = null) {
        return $this->addDataRule('click-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_put(string $command, $value = null) {
        return $this->addDataRule('click-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_click_head(string $command, $value = null) {
        return $this->addDataRule('click-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit(string $command, $value = null) {
        return $this->addDataRule('submit', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_jax(string $command, $value = null) {
        return $this->addDataRule('submit-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_delete(string $command, $value = null) {
        return $this->addDataRule('submit-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_get(string $command, $value = null) {
        return $this->addDataRule('submit-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_post(string $command, $value = null) {
        return $this->addDataRule('submit-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_put(string $command, $value = null) {
        return $this->addDataRule('submit-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_submit_head(string $command, $value = null) {
        return $this->addDataRule('submit-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick(string $command, $value = null) {
        return $this->addDataRule('dblclick', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_jax(string $command, $value = null) {
        return $this->addDataRule('dblclick-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_delete(string $command, $value = null) {
        return $this->addDataRule('dblclick-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_get(string $command, $value = null) {
        return $this->addDataRule('dblclick-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_post(string $command, $value = null) {
        return $this->addDataRule('dblclick-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_put(string $command, $value = null) {
        return $this->addDataRule('dblclick-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_dblclick_head(string $command, $value = null) {
        return $this->addDataRule('dblclick-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change(string $command, $value = null) {
        return $this->addDataRule('change', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_jax(string $command, $value = null) {
        return $this->addDataRule('change-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_delete(string $command, $value = null) {
        return $this->addDataRule('change-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_get(string $command, $value = null) {
        return $this->addDataRule('change-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_post(string $command, $value = null) {
        return $this->addDataRule('change-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_put(string $command, $value = null) {
        return $this->addDataRule('change-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_change_head(string $command, $value = null) {
        return $this->addDataRule('change-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur(string $command, $value = null) {
        return $this->addDataRule('blur', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_jax(string $command, $value = null) {
        return $this->addDataRule('blur-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_delete(string $command, $value = null) {
        return $this->addDataRule('blur-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_get(string $command, $value = null) {
        return $this->addDataRule('blur-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_post(string $command, $value = null) {
        return $this->addDataRule('blur-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_put(string $command, $value = null) {
        return $this->addDataRule('blur-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_blur_head(string $command, $value = null) {
        return $this->addDataRule('blur-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus(string $command, $value = null) {
        return $this->addDataRule('focus', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_jax(string $command, $value = null) {
        return $this->addDataRule('focus-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_delete(string $command, $value = null) {
        return $this->addDataRule('focus-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_get(string $command, $value = null) {
        return $this->addDataRule('focus-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_post(string $command, $value = null) {
        return $this->addDataRule('focus-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_put(string $command, $value = null) {
        return $this->addDataRule('focus-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_focus_head(string $command, $value = null) {
        return $this->addDataRule('focus-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange(string $command, $value = null) {
        return $this->addDataRule('formchange', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_jax(string $command, $value = null) {
        return $this->addDataRule('formchange-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_delete(string $command, $value = null) {
        return $this->addDataRule('formchange-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_get(string $command, $value = null) {
        return $this->addDataRule('formchange-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_post(string $command, $value = null) {
        return $this->addDataRule('formchange-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_put(string $command, $value = null) {
        return $this->addDataRule('formchange-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_formchange_head(string $command, $value = null) {
        return $this->addDataRule('formchange-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput(string $command, $value = null) {
        return $this->addDataRule('forminput', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_jax(string $command, $value = null) {
        return $this->addDataRule('forminput-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_delete(string $command, $value = null) {
        return $this->addDataRule('forminput-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_get(string $command, $value = null) {
        return $this->addDataRule('forminput-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_post(string $command, $value = null) {
        return $this->addDataRule('forminput-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_put(string $command, $value = null) {
        return $this->addDataRule('forminput-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_forminput_head(string $command, $value = null) {
        return $this->addDataRule('forminput-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input(string $command, $value = null) {
        return $this->addDataRule('input', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_jax(string $command, $value = null) {
        return $this->addDataRule('input-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_delete(string $command, $value = null) {
        return $this->addDataRule('input-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_get(string $command, $value = null) {
        return $this->addDataRule('input-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_post(string $command, $value = null) {
        return $this->addDataRule('input-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_put(string $command, $value = null) {
        return $this->addDataRule('input-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_input_head(string $command, $value = null) {
        return $this->addDataRule('input-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown(string $command, $value = null) {
        return $this->addDataRule('keydown', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_jax(string $command, $value = null) {
        return $this->addDataRule('keydown-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_delete(string $command, $value = null) {
        return $this->addDataRule('keydown-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_get(string $command, $value = null) {
        return $this->addDataRule('keydown-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_post(string $command, $value = null) {
        return $this->addDataRule('keydown-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_put(string $command, $value = null) {
        return $this->addDataRule('keydown-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keydown_head(string $command, $value = null) {
        return $this->addDataRule('keydown-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress(string $command, $value = null) {
        return $this->addDataRule('keypress', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_jax(string $command, $value = null) {
        return $this->addDataRule('keypress-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_delete(string $command, $value = null) {
        return $this->addDataRule('keypress-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_get(string $command, $value = null) {
        return $this->addDataRule('keypress-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_post(string $command, $value = null) {
        return $this->addDataRule('keypress-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_put(string $command, $value = null) {
        return $this->addDataRule('keypress-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keypress_head(string $command, $value = null) {
        return $this->addDataRule('keypress-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup(string $command, $value = null) {
        return $this->addDataRule('keyup', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_jax(string $command, $value = null) {
        return $this->addDataRule('keyup-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_delete(string $command, $value = null) {
        return $this->addDataRule('keyup-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_get(string $command, $value = null) {
        return $this->addDataRule('keyup-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_post(string $command, $value = null) {
        return $this->addDataRule('keyup-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_put(string $command, $value = null) {
        return $this->addDataRule('keyup-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_keyup_head(string $command, $value = null) {
        return $this->addDataRule('keyup-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown(string $command, $value = null) {
        return $this->addDataRule('mousedown', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_jax(string $command, $value = null) {
        return $this->addDataRule('mousedown-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_delete(string $command, $value = null) {
        return $this->addDataRule('mousedown-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_get(string $command, $value = null) {
        return $this->addDataRule('mousedown-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_post(string $command, $value = null) {
        return $this->addDataRule('mousedown-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_put(string $command, $value = null) {
        return $this->addDataRule('mousedown-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousedown_head(string $command, $value = null) {
        return $this->addDataRule('mousedown-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove(string $command, $value = null) {
        return $this->addDataRule('mousemove', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_jax(string $command, $value = null) {
        return $this->addDataRule('mousemove-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_delete(string $command, $value = null) {
        return $this->addDataRule('mousemove-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_get(string $command, $value = null) {
        return $this->addDataRule('mousemove-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_post(string $command, $value = null) {
        return $this->addDataRule('mousemove-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_put(string $command, $value = null) {
        return $this->addDataRule('mousemove-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousemove_head(string $command, $value = null) {
        return $this->addDataRule('mousemove-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout(string $command, $value = null) {
        return $this->addDataRule('mouseout', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_jax(string $command, $value = null) {
        return $this->addDataRule('mouseout-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_delete(string $command, $value = null) {
        return $this->addDataRule('mouseout-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_get(string $command, $value = null) {
        return $this->addDataRule('mouseout-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_post(string $command, $value = null) {
        return $this->addDataRule('mouseout-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_put(string $command, $value = null) {
        return $this->addDataRule('mouseout-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseout_head(string $command, $value = null) {
        return $this->addDataRule('mouseout-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover(string $command, $value = null) {
        return $this->addDataRule('mouseover', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_jax(string $command, $value = null) {
        return $this->addDataRule('mouseover-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_delete(string $command, $value = null) {
        return $this->addDataRule('mouseover-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_get(string $command, $value = null) {
        return $this->addDataRule('mouseover-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_post(string $command, $value = null) {
        return $this->addDataRule('mouseover-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_put(string $command, $value = null) {
        return $this->addDataRule('mouseover-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseover_head(string $command, $value = null) {
        return $this->addDataRule('mouseover-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup(string $command, $value = null) {
        return $this->addDataRule('mouseup', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_jax(string $command, $value = null) {
        return $this->addDataRule('mouseup-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_delete(string $command, $value = null) {
        return $this->addDataRule('mouseup-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_get(string $command, $value = null) {
        return $this->addDataRule('mouseup-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_post(string $command, $value = null) {
        return $this->addDataRule('mouseup-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_put(string $command, $value = null) {
        return $this->addDataRule('mouseup-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mouseup_head(string $command, $value = null) {
        return $this->addDataRule('mouseup-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel(string $command, $value = null) {
        return $this->addDataRule('mousewheel', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_jax(string $command, $value = null) {
        return $this->addDataRule('mousewheel-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_delete(string $command, $value = null) {
        return $this->addDataRule('mousewheel-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_get(string $command, $value = null) {
        return $this->addDataRule('mousewheel-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_post(string $command, $value = null) {
        return $this->addDataRule('mousewheel-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_put(string $command, $value = null) {
        return $this->addDataRule('mousewheel-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_mousewheel_head(string $command, $value = null) {
        return $this->addDataRule('mousewheel-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover(string $command, $value = null) {
        return $this->addDataRule('hover', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_jax(string $command, $value = null) {
        return $this->addDataRule('hover-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_delete(string $command, $value = null) {
        return $this->addDataRule('hover-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_get(string $command, $value = null) {
        return $this->addDataRule('hover-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_post(string $command, $value = null) {
        return $this->addDataRule('hover-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_put(string $command, $value = null) {
        return $this->addDataRule('hover-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_hover_head(string $command, $value = null) {
        return $this->addDataRule('hover-head', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load(string $command, $value = null) {
        return $this->addDataRule('load', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_jax(string $command, $value = null) {
        return $this->addDataRule('load-jax', $command, $value, 'props');
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_delete(string $command, $value = null) {
        return $this->addDataRule('load-delete', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_get(string $command, $value = null) {
        return $this->addDataRule('load-get', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_post(string $command, $value = null) {
        return $this->addDataRule('load-post', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_put(string $command, $value = null) {
        return $this->addDataRule('load-put', $command, $value);
    }

    /**
     * @param $command
     * @param $value
     * @return $this
     */
    public function on_load_head(string $command, $value = null) {
        return $this->addDataRule('load-head', $command, $value);
    }

    /**
     * @param  string  $event
     * @param  string|object  $command
     * @param  null  $value
     * @param  string  $param_type
     * @return $this
     */
    public function addDataRule(string $event, $command, $value = null, string $param_type = "params")
    {
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

        } else if (is_object($command)) {

            if ($command instanceof HTMLCustomCommand) {

                $command = $command->render();
            }

            else {

                return $this;
            }
        }

        if (is_array($value)) {
            foreach ($value as $key => $item) {
                if (is_array($item)) { $value[$key] = json_encode($item); }
            }
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