<?php

namespace Lar\Layout;

use Lar\Developer\Commands\Dump\GenerateBladeHelpers;
use Lar\Layout\Components\LjsScripts;
use Lar\Layout\Components\LjsStyles;
use Lar\Layout\Components\Template;
use Lar\Layout\Components\TemplateArea;
use Lar\Layout\Core\LConfigs;
use Lar\Layout\Traits\BladeDirectivesHelpers;
use Lar\Tagable\Core\HTML5Library;
use Lar\Tagable\Tag;

/**
 * Class BladeDirectives
 *
 * @package Lar\Layout
 */
class BladeDirectives
{
    use BladeDirectivesHelpers;

    /**
     * @var array
     */
    public static $_last_vue_state = [];

    /**
     * Lives ids
     *
     * @var array
     */
    public static $_lives = [];

    /**
     * Attribute watches ids
     *
     * @var array
     */
    public static $_attr_watches = [];

    /**
     * BladeDirectives constructor.
     * @param  JaxCollection|null  $with
     */
    public function __construct(...$with)
    {
        foreach (config('layout.blade_drivers', []) as $driver) {

            $this->{$driver}();
        }

        $this->info()->ljs_injector();
        $this->tpl();
    }

    protected function tpl()
    {
        \Blade::directive('tplarea', function ($attrs = '') {

            $class = TemplateArea::class;

            return "<?php echo \\{$class}::create({$attrs}); ?>";
        });

        \Blade::directive('tpl', function ($attrs = '') {

            $class = Template::class;

            return "<?php echo \\{$class}::create({$attrs})->openMode(); ?>";
        });

        \Blade::directive('endtpl', function ($attrs = '') {

            return "</template>";
        });

        GenerateBladeHelpers::$just[] = 'endtpl';
        GenerateBladeHelpers::$just[] = 'endtplarea';
    }

    protected function ljs_injector()
    {
        \Blade::directive('ljsScripts', function ($plugins = "") {

            if (!preg_match('/^\[.*\]$/', $plugins)) { $plugins = "[{$plugins}]"; }

            return '<?php echo ' . LjsScripts::class . "::create({$plugins}); ?>";
        });

        \Blade::directive('ljsStyles', function ($plugins = "") {

            if (!preg_match('/^\[.*\]$/', $plugins)) { $plugins = "[{$plugins}]"; }

            return '<?php echo ' . LjsStyles::class . "::create({$plugins}); ?>";
        });

        \Blade::directive('ljsConfigs', function () {

            return '<?php echo ' . LConfigs::class . "::render(); ?>";
        });
    }

    /**
     * 'click', 'submit', 'dblclick', 'change', 'blur', 'focus',
     * 'formchange', 'forminput', 'input', 'keydown', 'keypress',
     * 'keyup', 'mousedown', 'mousemove', 'mouseout', 'mouseover',
     * 'mouseup', 'mousewheel', 'load'
     */
    public function events()
    {
        $needle = ['click', 'submit', 'dblclick', 'change', 'blur', 'focus',
            'formchange', 'forminput', 'input', 'keydown', 'keypress',
            'keyup', 'mousedown', 'mousemove', 'mouseout', 'mouseover',
            'mouseup', 'mousewheel', 'load'];

        foreach ($needle as $item) {

            \Blade::directive($item, function ($conditions) use ($item) {

                return "data-{$item}='<?php echo {$conditions}; ?>'";
            });
        }

        \Blade::directive('parse', function (){

            return "data-parse";
        });

        \Blade::directive('parsed', function (){

            return "data-parsed";
        });
    }

    /**
     * LJS tag
     */
    public function ljs()
    {
        $ljs = function ($data = "") {

            return "data-ljs=\"<?php echo " . trim((string)$data) . "; ?>\"";
        };

        \Blade::directive('ljs', $ljs);
        \Blade::directive('j', $ljs);

        \Blade::directive('ahtml', function ($condition) {

            dd(AHtml::create($condition)->render());

            return "";
        });
    }

    /**
     * Href from any tag
     */
    public function href()
    {
        \Blade::directive('href', function ($conditions) {

            return "data-href=\"<?php echo route({$conditions}); ?>\"";
        });
    }

    /**
     * Create watch on attributes
     */
    public function attr_watch()
    {
        \Blade::directive('attrWatch', function ($conditions) {

            return "<?php echo \\" . static::class . "::createAttributeWatcher({$conditions}); ?>";
        });
    }

    /**
     * Live tag
     */
    public function live()
    {
        \Blade::directive('live', function ($conditions) {

            return "<?php echo \\" . static::class . "::createLiveTag({$conditions}); ?>";
        });

        \Blade::directive('watch', function ($conditions) {

            return "<?php echo \\" . static::class . "::createLiveTag({$conditions}); ?>";
        });
    }

    /**
     * Vue tag
     */
    public function vue()
    {
        \Blade::directive('vue', function ($conditions) {

            return "<?php echo \\" . static::class . "::vueTagOpen({$conditions}); ?>";
        });

        \Blade::directive('endvue', function () {

            return "<?php echo \\" . static::class . "::vueTagClose(); ?>";
        });
    }

    /**
     * Include all components
     */
    public function components()
    {
        foreach (Tag::getComponents() as $key => $item) {

            \Blade::directive(\Str::camel($key), function ($data) use ($item, $key) {

                return "<?php echo (new {$item}({$data}))->render(); ?>";
            });
        }
    }

    /**
     * HTML5 tags
     */
    public function html5()
    {
        HTML5Library::init();

        /*foreach (HTML5Library::$tags as $key => $tag) {

            if ($key === 'section') {

                continue;
            }

            \Blade::directive($key, function ($data) use ($key) {

                return "<?php echo (new " . Component::getClassNameByTag($key) . "({$data}))->render(); ?>";
            });
        }*/

        return $this;
    }

    /**
     * Create controller info variables
     */
    protected function info()
    {
        app('view')->composer('*', function (\Illuminate\View\View $view) {

            $route = app('request')->route();

            if ($route) {

                $action = $route->getAction();

                if (isset($action['controller'])) {

                    $controller = class_basename($action['controller']);

                    if (!preg_match('/\@/', $controller)) { $controller .= "@__invoke"; }

                    $class = explode('@', $controller)[0];

                    list($controller, $action) = explode('@', $controller);

                    $view->with(['root' => (object)[
                        'controller' => $controller,
                        'action' => $action,
                        'class' => $class
                    ]]);
                }
            }
        });

        return $this;
    }
}
