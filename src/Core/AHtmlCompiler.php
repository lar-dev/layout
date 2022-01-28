<?php

namespace Lar\Layout\Core;

use Lar\Tagable\Tag;

/**
 * Class AHtmlCompiler.
 *
 * @package Lar\Layout\Core
 */
class AHtmlCompiler
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $build = '';

    /**
     * AHtmlCompiler constructor.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param  array  $data
     * @return string
     */
    public static function compile(array $data)
    {
        return (new static($data))->runBuild()->get();
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->build;
    }

    /**
     * @return $this
     */
    public function runBuild()
    {
        $this->build = $this->build($this->data);

        return $this;
    }

    /**
     * @param  array|string  $data
     * @param  int  $level
     * @return string
     */
    private function build($data, int $level = 0)
    {
        $return = '';

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_int($key)) {
                    $return .= $value;
                } elseif (!Tag::hasComponent($key)) {
                    $close = is_tag_closing($key);

                    if (is_string($value)) {
                        $return .= $close ? "<{$key}>" : "<{$key}/>";

                        $return .= $value;
                    } elseif (is_array($value)) {
                        $v_content = '';
                        $v_attrs = [];

                        foreach ($value as $v_key => $v_value) {
                            if (is_numeric($v_key) && is_array($v_value)) {
                                $v_content .= $this->build($v_value, $level + 1);
                            } elseif (is_numeric($v_key)) {
                                if (preg_match('/^\.([a-zA-Z0-9\_\-]+)/', $v_value, $m)) {
                                    $this->addVarToArr($v_attrs, 'class', $m[1], true);
                                } elseif (preg_match('/^\#([a-zA-Z0-9\_\-]+)/', $v_value, $m)) {
                                    $this->addVarToArr($v_attrs, 'id', $m[1]);
                                } else {
                                    $this->addVarToArr($v_attrs, $v_value);
                                }
                            } elseif ($v_key === 'data' && is_array($v_value)) {
                                foreach ($v_value as $k => $i) {
                                    $this->addVarToArr($v_attrs, "data-{$k}", $i);
                                }
                            } else {
                                $this->addVarToArr($v_attrs, $v_key, $v_value);
                            }
                        }

                        $p = count($v_attrs) ? ' ' : '';

                        $v_attrs2 = [];

                        foreach ($v_attrs as $v_a_k => $v_attr) {
                            if (is_string($v_attr) || is_numeric($v_attr)) {
                                $v_attrs2[] = "$v_a_k=\"{$v_attr}\"";
                            } elseif (is_null($v_attr)) {
                                $v_attrs2[] = $v_a_k;
                            } elseif (is_array($v_attr)) {
                                $v_attrs2[] = "$v_a_k='".json_encode($v_attr)."'";
                            }
                        }

                        $v_attrs = implode(' ', $v_attrs2);

                        $return .= $close ? "<{$key}{$p}{$v_attrs}>" : "<{$key}{$p}{$v_attrs}/>";

                        $return .= $v_content;
                    }

                    if ($close) {
                        $return .= "</{$key}>";
                    }
                }
            }
        }

        return $return;
    }

    /**
     * @param $arr
     * @param $name
     * @param $value
     * @param  bool  $append
     * @return void
     */
    protected function addVarToArr(&$arr, $name, $value = null, bool $append = false)
    {
        if (isset($arr[$name]) && $append) {
            $arr[$name] .= ' '.$value;
        } else {
            $arr[$name] = $value;
        }
    }
}
