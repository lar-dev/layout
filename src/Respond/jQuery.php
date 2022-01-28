<?php

namespace Lar\Layout\Respond;

use Illuminate\Contracts\Support\Renderable;
use Lar\Layout\Respond;

/**
 * Class jQuery.
 *
 * @package Lar\Layout\Respond
 */
class jQuery
{
    /**
     * @var Respond
     */
    public $respond;

    /**
     * @var string
     */
    private $selector;

    /**
     * jQuery constructor.
     * @param  Respond  $respond
     * @param  string|null  $selector
     */
    public function __construct(Respond $respond, string $selector = null)
    {
        $this->respond = $respond;
        $this->selector = $selector;
    }

    /**
     * After.
     *
     * Insert content, specified by the parameter, after each element in the set of matched elements.
     *
     * @param  string  $selector
     * @param $data
     * @return $this
     */
    public function after($data)
    {
        if (is_object($data) && method_exists($data, 'render')) {
            $data = $data->render();
        }

        return $this->make('after', $data);
    }

    /**
     * Make command.
     *
     * @param  string  $method
     * @param  mixed  ...$props
     * @return $this
     */
    public function make(string $method, ...$props)
    {
        if ($this->selector) {
            $this->respond->put("$::{$method}", array_merge([$this->selector], $props));
        } else {
            $this->respond->put("$:{$method}", $props);
        }

        return $this;
    }

    /**
     * Add class.
     *
     * @param  string  $class
     * @return $this
     */
    public function add_class(string $class)
    {
        return $this->make('addClass', $class);
    }

    /**
     * Append.
     *
     * @param  mixed  $data
     * @return $this
     */
    public function append($data)
    {
        if (is_object($data) && method_exists($data, 'render')) {
            $data = $data->render();
        }

        return $this->make('append', $data);
    }

    /**
     * Append to.
     *
     * @param  string  $selector
     * @return $this
     */
    public function append_to(string $selector)
    {
        return $this->make('appendTo', $selector);
    }

    /**
     * Attr.
     *
     * @param  string  $attribute
     * @param  string|null  $value
     * @return $this
     */
    public function attr(string $attribute, string $value = null)
    {
        if ($value !== null) {
            return $this->make('attr', $attribute, $value);
        }

        return $this->make('attr', $attribute);
    }

    /**
     * CSS.
     *
     * @param  string  $prop
     * @param  string|null  $value
     * @return $this
     */
    public function css(string $prop, string $value = null)
    {
        if ($value !== null) {
            return $this->make('css', $prop, $value);
        }

        return $this->make('css', $prop);
    }

    /**
     * Data.
     *
     * @param  string  $data_name
     * @param  string|null  $value
     * @return $this
     */
    public function data(string $data_name, string $value = null)
    {
        if ($value !== null) {
            return $this->make('data', $data_name, $value);
        }

        return $this->make('data', $data_name);
    }

    /**
     * Detach.
     *
     * The .detach() method is the same as .remove(), except that .detach() keeps all jQuery
     * data associated with the removed elements. This method is useful when removed elements
     * are to be reinserted into the DOM at a later time.
     *
     * @return $this
     */
    public function detach()
    {
        return $this->make('detach');
    }

    /**
     * Empty.
     *
     * This method removes not only child (and other descendant) elements, but also any text within
     * the set of matched elements. This is because, according to the DOM specification, any string
     * of text within an element is considered a child node of that element.
     *
     * @return $this
     */
    public function empty()
    {
        return $this->make('empty');
    }

    /**
     * Eq.
     *
     * Reduce the set of matched elements to the one at the specified index.
     *
     * @param  int  $num
     * @return $this
     */
    public function eq(int $num = 1)
    {
        return $this->make('eq', $num);
    }

    /**
     * Before.
     *
     * @param  string  $data
     * @return $this
     */
    public function before(string $data)
    {
        return $this->make('before', $data);
    }

    /**
     * Blur.
     *
     * Trigger that event on an element.
     *
     * @return $this
     */
    public function blur()
    {
        return $this->make('blur');
    }

    /**
     * Change.
     *
     * Trigger that event on an element.
     *
     * @return $this
     */
    public function change()
    {
        return $this->make('change');
    }

    /**
     * Click.
     *
     * Trigger that event on an element.
     *
     * @return $this
     */
    public function click()
    {
        return $this->make('click');
    }

    /**
     * Contextmenu.
     *
     * Trigger that event on an element.
     *
     * @return $this
     */
    public function contextmenu()
    {
        return $this->make('contextmenu');
    }

    /**
     * Dblclick.
     *
     * Trigger that event on an element.
     *
     * @return $this
     */
    public function dblclick()
    {
        return $this->make('dblclick');
    }

    /**
     * Fade in.
     *
     * Display the matched elements by fading them to opaque.
     *
     * @param  null  $duration
     * @return $this
     */
    public function fade_in($duration = null)
    {
        if ($duration !== null) {
            return $this->make('fadeIn', $duration);
        }

        return $this->make('fadeIn');
    }

    /**
     * Fade out.
     *
     * Hide the matched elements by fading them to transparent.
     *
     * @param  null|string|int  $duration
     * @return $this
     */
    public function fade_out($duration = null)
    {
        if ($duration !== null) {
            return $this->make('fadeOut', $duration);
        }

        return $this->make('fadeOut');
    }

    /**
     * Fade to.
     *
     * Adjust the opacity of the matched elements.
     *
     * @param  string|int  $duration
     * @param  int  $opacity
     * @return $this
     */
    public function fade_to($duration, int $opacity)
    {
        return $this->make('fadeTo', $duration, $opacity);
    }

    /**
     * Fade toggle.
     *
     * Display or hide the matched elements by animating their opacity.
     *
     * @param  null|string|int  $duration
     * @return $this
     */
    public function fade_toggle($duration = null)
    {
        if ($duration !== null) {
            return $this->make('fadeToggle', $duration);
        }

        return $this->make('fadeToggle');
    }

    /**
     * Focus.
     *
     * Bind an event handler to the “focus” JavaScript event, or trigger that event on an element.
     *
     * @return $this
     */
    public function focus()
    {
        return $this->make('focus');
    }

    /**
     * Height.
     *
     * Get/Set the current computed height for the first element in the set of matched elements.
     *
     * @param  null|int|string  $height
     * @return $this
     */
    public function height($height = null)
    {
        if ($height !== null) {
            return $this->make('height', $height);
        }

        return $this->make('height');
    }

    /**
     * Hide.
     *
     * Hide the matched elements.
     *
     * @param  null|int|string  $duration
     * @return $this
     */
    public function hide($duration = null)
    {
        if ($duration !== null) {
            return $this->make('hide', $duration);
        }

        return $this->make('hide');
    }

    /**
     * Html.
     *
     * Get/Set the HTML contents of the first element in the set of matched elements or set the
     * HTML contents of every matched element.
     *
     * @param  mixed  $data
     * @return $this
     */
    public function html($data = null)
    {
        if ($data !== null) {
            if (is_object($data) && method_exists($data, 'render')) {
                $data = $data->render();
            }

            return $this->make('html', $data);
        }

        return $this->make('html');
    }

    /**
     * Inner height.
     *
     * @param  null|int|string  $value
     * @return $this
     */
    public function inner_height($value = null)
    {
        if ($value !== null) {
            return $this->make('innerHeight', $value);
        }

        return $this->make('innerHeight');
    }

    /**
     * Inner width.
     *
     * Get the current computed inner width for the first element in the set of matched elements,
     * including padding but not border.
     *
     * @param  null|int|string  $value
     * @return $this
     */
    public function inner_width($value = null)
    {
        if ($value !== null) {
            return $this->make('innerWidth', $value);
        }

        return $this->make('innerWidth');
    }

    /**
     * Insert after.
     *
     * Insert every element in the set of matched elements after the target.
     *
     * @param  string  $selector
     * @return $this
     */
    public function insert_after(string $selector)
    {
        return $this->make('insertAfter', $selector);
    }

    /**
     * Insert before.
     *
     * Insert every element in the set of matched elements before the target.
     *
     * @param  string  $selector
     * @return $this
     */
    public function insert_before(string $selector)
    {
        return $this->make('insertBefore', $selector);
    }

    /**
     * Keydown.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function keydown()
    {
        return $this->make('keydown');
    }

    /**
     * Keypress.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function keypress()
    {
        return $this->make('keypress');
    }

    /**
     * Keyup.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function keyup()
    {
        return $this->make('keyup');
    }

    /**
     * Mousedown.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function mousedown()
    {
        return $this->make('mousedown');
    }

    /**
     * Mousemove.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function mousemove()
    {
        return $this->make('mousemove');
    }

    /**
     * Mouseout.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function mouseout()
    {
        return $this->make('mouseout');
    }

    /**
     * Mouseover.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function mouseover()
    {
        return $this->make('mouseover');
    }

    /**
     * Mouseup.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function mouseup()
    {
        return $this->make('mouseup');
    }

    /**
     * Prepend.
     *
     * Insert content, specified by the parameter, to the beginning of each element in the set of matched elements.
     *
     * @param  mixed  $data
     * @return $this
     */
    public function prepend($data)
    {
        if (is_object($data) && method_exists($data, 'render')) {
            $data = $data->render();
        }

        return $this->make('prepend', $data);
    }

    /**
     * Prepend to.
     *
     * Insert every element in the set of matched elements to the beginning of the target.
     *
     * @param  string  $selector
     * @return $this
     */
    public function prepend_to(string $selector)
    {
        return $this->make('prependTo', $selector);
    }

    /**
     * Remove.
     *
     * Remove the set of matched elements from the DOM.
     *
     * @param  string|null  $selector
     * @return $this
     */
    public function remove(string $selector = null)
    {
        if ($selector !== null) {
            return $this->make('remove', $selector);
        }

        return $this->make('remove');
    }

    /**
     * Remove attr.
     *
     * Remove an attribute from each element in the set of matched elements.
     *
     * @param  string  $attribute
     * @return $this
     */
    public function remove_attr(string $attribute)
    {
        return $this->make('removeAttr', $attribute);
    }

    /**
     * Remove class.
     *
     * Remove a single class, multiple classes, or all classes from each element in the set of matched elements.
     *
     * @param  string  $class
     * @return $this
     */
    public function remove_class(string $class)
    {
        return $this->make('removeClass', $class);
    }

    /**
     * Remove data.
     *
     * Remove a previously-stored piece of data.
     *
     * @param  string  $name
     * @return $this
     */
    public function remove_data(string $name)
    {
        return $this->make('removeData', $name);
    }

    /**
     * Replace all.
     *
     * Replace each target element with the set of matched elements.
     *
     * @param  string  $selector
     * @return $this
     */
    public function replace_all(string $selector)
    {
        return $this->make('replaceAll', $selector);
    }

    /**
     * Replace with.
     *
     * Replace each element in the set of matched elements with the provided new content and return the set of
     * elements that was removed.
     *
     * @param $data
     * @return $this
     */
    public function replace_with($data)
    {
        if (is_object($data) && method_exists($data, 'render')) {
            $data = $data->render();
        }

        return $this->make('replaceWith', $data);
    }

    /**
     * Resize.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function resize()
    {
        return $this->make('resize');
    }

    /**
     * Scroll.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function scroll()
    {
        return $this->make('scroll');
    }

    /**
     * Select.
     *
     * trigger that event on an element.
     *
     * @return $this
     */
    public function select()
    {
        return $this->make('select');
    }

    /**
     * Scroll left.
     *
     * Get/Set the current horizontal position of the scroll bar for the first element in the set of matched elements.
     *
     * @param  int|null  $value
     * @return $this
     */
    public function scroll_left(int $value = null)
    {
        if ($value !== null) {
            return $this->make('scrollLeft', $value);
        }

        return $this->make('scrollLeft');
    }

    /**
     * Scroll top.
     *
     * Get/Set the current vertical position of the scroll bar for the first element in the set of matched
     * elements or set the vertical position of the scroll bar for every matched element.
     *
     * @param  int|null  $value
     * @return $this
     */
    public function scroll_top(int $value = null)
    {
        if ($value !== null) {
            return $this->make('scrollTop', $value);
        }

        return $this->make('scrollTop');
    }

    /**
     * Show.
     *
     * Display the matched elements.
     *
     * @param  null|string|int  $duration
     * @return $this
     */
    public function show($duration = null)
    {
        if ($duration !== null) {
            return $this->make('show', $duration);
        }

        return $this->make('show');
    }

    /**
     * Slide down.
     *
     * Display the matched elements with a sliding motion.
     *
     * @param  null  $duration
     * @return $this
     */
    public function slide_down($duration = null)
    {
        if ($duration !== null) {
            return $this->make('slideDown', $duration);
        }

        return $this->make('slideDown');
    }

    /**
     * Slide toggle.
     *
     * Display or hide the matched elements with a sliding motion.
     *
     * @param  null  $duration
     * @return $this
     */
    public function slide_toggle($duration = null)
    {
        if ($duration !== null) {
            return $this->make('slideToggle', $duration);
        }

        return $this->make('slideToggle');
    }

    /**
     * Slide up.
     *
     * Hide the matched elements with a sliding motion.
     *
     * @param  null  $duration
     * @return $this
     */
    public function slide_up($duration = null)
    {
        if ($duration !== null) {
            return $this->make('slideUp', $duration);
        }

        return $this->make('slideUp');
    }

    /**
     * Submit.
     *
     * Bind an event handler to the “submit” JavaScript event, or trigger that event on an element.
     *
     * @return $this
     */
    public function submit()
    {
        return $this->make('submit');
    }

    /**
     * Text.
     *
     * Set the content of each element in the set of matched elements to the specified text.
     *
     * @param  mixed  $data
     * @return $this
     */
    public function text($data = null)
    {
        if ($data !== null) {
            if (is_object($data) && method_exists($data, 'render')) {
                $data = $data->render();
            }

            return $this->make('text', $data);
        }

        return $this->make('text');
    }

    /**
     * Toggle.
     *
     * Display or hide the matched elements.
     *
     * @param  mixed  $duration
     * @return $this
     */
    public function toggle($duration = null)
    {
        if ($duration !== null) {
            return $this->make('toggle', $duration);
        }

        return $this->make('toggle');
    }

    /**
     * Toggle class.
     *
     * Add or remove one or more classes from each element in the set of matched elements,
     * depending on either the class's presence or the value of the state argument.
     *
     * @param  string  $class
     * @return $this
     */
    public function toggle_class(string $class)
    {
        return $this->make('toggleClass', $class);
    }

    /**
     * Trigger.
     *
     * Execute all handlers and behaviors attached to the matched elements for the given event type.
     *
     * @param  string  $event_name
     * @return $this
     */
    public function trigger(string $event_name)
    {
        return $this->make('trigger', $event_name);
    }

    /**
     * Trigger handler.
     *
     * Execute all handlers attached to an element for an event.
     *
     * @param  string  $event_name
     * @return $this
     */
    public function trigger_handler(string $event_name)
    {
        return $this->make('triggerHandler', $event_name);
    }

    /**
     * Val.
     *
     * Set the value of each element in the set of matched elements.
     *
     * @param  mixed  $data
     * @return $this
     */
    public function val($data = null)
    {
        if ($data !== null) {
            if (is_object($data) && method_exists($data, 'render')) {
                $data = $data->render();
            }

            return $this->make('val', $data);
        }

        return $this->make('val');
    }

    /**
     * Width.
     *
     * Get/Set the current computed height for the first element in the set of matched elements.
     *
     * @param  null|string|int  $width
     * @return $this
     */
    public function width($width = null)
    {
        if ($width !== null) {
            return $this->make('width', $width);
        }

        return $this->make('width');
    }

    /**
     * @param  string  $attribute_name
     * @param  string  $value
     * @param  string|null  $selector
     * @return $this
     */
    public function attribute(string $attribute_name, string $value, string $selector = null)
    {
        if ($selector !== null) {
            $this->respond->put('$::attribute', [$selector, $attribute_name, $value]);
        } else {
            $this->respond->put('$::attribute', [$attribute_name, $value]);
        }

        return $this;
    }

    /**
     * @param  array  $values
     * @param  string|null  $selector
     * @return $this
     */
    public function attributes(array $values, string $selector = null)
    {
        if ($selector !== null) {
            $this->respond->put('$::attribute', [$selector, $values]);
        } else {
            $this->respond->put('$::attribute', [$values]);
        }

        return $this;
    }

    /**
     * @param  array  $values
     * @return $this
     */
    public function manyAttributes(array $values)
    {
        $this->respond->put('$::manyAttributes', $values);

        return $this;
    }

    /**
     * globalEval.
     *
     * @param $data
     * @return $this
     */
    public function eval($data)
    {
        if ($data instanceof Renderable) {
            $data = $data->render();
        }

        $this->respond->put('$::eval', $data);

        return $this;
    }

    /**
     * @param  string|null  $selector
     * @return jQuery
     */
    public function jq(string $selector = null)
    {
        return $this->respond->jq($selector);
    }

    /**
     * @param $name
     * @param $arguments
     * @return jQuery
     */
    public function __call($name, $arguments)
    {
        return $this->make($name, ...$arguments);
    }
}
