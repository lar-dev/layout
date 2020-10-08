<?php

namespace Lar\Layout\Abstracts;

use Lar\Layout\Components\CSS;
use Lar\Layout\Components\LjsScripts;
use Lar\Layout\Components\LjsStyles;
use Lar\Layout\Core\LConfigs;
use Lar\Layout\Tags\BODY;
use Lar\Layout\Tags\HEAD;
use Lar\Layout\Tags\HTML;
use Lar\Layout\Tags\LINK;
use Lar\Layout\Tags\META;
use Lar\Layout\Tags\TITLE;
use Lar\LJS\LJS;

/**
 * Class LayoutComponent
 * @package Lar\Layout\Abstracts
 */
class LayoutComponent extends HTML
{
    /**
     * Layout name
     *
     * @var string
     */
    protected $name = "app";

    /**
     * Title object
     *
     * @var TITLE
     */
    protected $title;

    /**
     * Head tag link
     *
     * @var HEAD
     */
    protected $head;

    /**
     * Metas Quick Infusion
     *
     * @var array
     */
    protected $metas = [];

    /**
     * Links Quick Infusion
     *
     * @var array
     */
    protected $links = [];

    /**
     * Body tag link
     *
     * @var BODY
     */
    protected $body;

    /**
     * Container object link
     *
     * @var Component
     */
    public $container;

    /**
     * Default title from head
     *
     * @var string
     */
    protected $default_title = "Layout";

    /**
     * Header Collection styles
     *
     * @var array
     */
    protected $head_styles = [];

    /**
     * Header links
     *
     * @var array
     */
    protected $head_links = [];

    /**
     * Header Collection scripts
     *
     * @var array
     */
    protected $head_scripts = [];

    /**
     * HTML Down Collection scripts
     *
     * @var array
     */
    protected $body_scripts = [];

    /**
     * PJax id selector
     *
     * @var bool|string
     */
    protected $pjax = false;

    /**
     * @var array
     */
    protected $js_lang = [];

    /**
     * LayoutComponent constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->makeDefaultTitle();

        foreach ($this->js_lang as $lib) {

            $this->head_scripts[] = "locales/" . \App::getLocale() . "/{$lib}.js";
        }

        $this->initLayout();
    }

    /**
     * Make default title from methods
     */
    protected function makeDefaultTitle()
    {
        $route = \Route::currentRouteName();
        if ($route) {
            $route = preg_replace('/[^a-z0-9]/', '_', $route);
            $route = str_replace('__', '_', $route);
            $method = \Str::camel("title_{$route}");
            if (method_exists($this, $method)) {
                $this->default_title = $this->{$method}();
            }
        }
    }

    /**
     * @throws \Exception
     */
    protected function initLayout()
    {
        if ($this->pjax) {

            $this->metas[] = [
                ['http-equiv' => 'x-pjax-version', 'content' => 'v0']
            ];
        }

        $this->head()->charset()->haveLink($this->head)->name($this->name.":head")
            ->title($this->default_title)->haveLink($this->title)->name($this->name.":title");

        $this->assetInjects();

        $this->body()->haveLink($this->body)->haveLink($this->container)->name($this->name.":body");

        $this->assetsBottomInject();

        $this->toExecute("init_scripts")
            ->toExecute("metaConfigs")
            ->toExecute("createConsole");
    }

    /**
     * Inject Layout assets
     *
     * @throws \Exception
     */
    protected function assetInjects()
    {
        $this->head->mapCollect($this->metas, function (META $meta, $row) {

            $meta->when([$row]);
        });

        $this->head->mapCollect($this->links, function (LINK $link, $row) {

                $link->when([$row]);
            })
            ->mapCollect($this->head_links, function (LINK $link, $row) {

                $link->when($row);
            })
            ->when(function (HEAD $head) {

                foreach ($this->head_styles as $key => $css) {

                    if ($key === 'ljs' && is_array($css)) {

                        $head->appEnd(LjsStyles::create($css));
                    }

                    else if ($css === 'ljs') {

                        $head->appEnd(LjsStyles::create());
                    }

                    else if (is_array($css)) {

                        $head->appEnd(CSS::create($css));

                    } else {

                        if (strpos($css, "://") === false) {

                            $head->appEnd(CSS::create()->asset($css));

                        } else {

                            $head->appEnd(CSS::create()->setHref($css));
                        }
                    }
                }
            })
            ->when(function (HEAD $head) {

                foreach ($this->head_scripts as $key => $script) {

                    if ($key === 'ljs' && is_array($script)) {

                        $head->appEnd(LjsScripts::create($script));
                    }

                    else if (is_array($script)) {

                        $head->script($script);

                    } else {

                        if (strpos($script, "://") === false) {

                            $head->script()->asset($script);

                        } else {

                            $head->script()->setSrc($script);
                        }
                    }
                }
            });
    }

    /**
     * Asset bottom assets
     *
     * @throws \Exception
     */
    protected function assetsBottomInject()
    {
        if (
            config('app.debug') &&
            ( config('debugbar.enabled') === null || config('debugbar.enabled') === true ) &&
            class_exists("Barryvdh\\Debugbar\\LaravelDebugbar")
        ) {

            if (isset($this->body_scripts['ljs']) && !in_array('vue', $this->body_scripts['ljs'])) {
                $this->body_scripts['ljs'][] = 'vue';
            }

            $this->body_scripts[] = 'ljs/plugins/ptty.jquery.js';
            $this->body_scripts['ljs'][] = 'debug';
        }

        $this->body->toBottom()->when(function (BODY $body) {

                foreach ($this->body_scripts as $key => $script) {

                    if ($key === 'ljs' && is_array($script)) {

                        $body->appEnd(LjsScripts::create($script));
                    }

                    else if (is_array($script)) {

                        $body->script($script);

                    } else {

                        if (strpos($script, "://") === false) {

                            $body->script()->asset($script);

                        } else {

                            $body->script()->setSrc($script);
                        }
                    }
                }
            })->toBottom();
    }

    /**
     * Add meta config
     *
     * @param string $name
     * @param $value
     * @return $this
     */
    protected function config(string $name, $value)
    {
        LConfigs::add($name, $value);

        return $this;
    }

    /**
     * On render executor.
     *
     * @throws \Exception
     */
    protected function init_scripts() {

        $ljs = new LJS(static::class);

        $obj = $this->body;

        if (request()->pjax()) {

            $obj = $this->container;
        }

        $obj->script(["data-exec-on-popstate" => ""]);
        //$obj->toBottom()->script(["data-exec-on-popstate" => ""]);
    }

    /**
     * Set container
     *
     * @param Component $component
     * @return $this
     */
    public function setContainer(Component $component)
    {
        $this->container = $component;

        return $this;
    }

    /**
     * Add data in to layout content
     *
     * @param $data
     * @return void
     * @throws \Exception
     */
    public function setInContent($data)
    {
        $this->container->appEnd($data);
    }

    /**
     * Create meta configs
     */
    public function metaConfigs()
    {
        if ($this->pjax) {

            $this->config("pjax-container", "#" . $this->pjax);
        }

        $this->head->appEnd(LConfigs::render());
    }

    /**
     * @return string
     */
    public function getDefaultTitle()
    {
        return $this->default_title;
    }
}
