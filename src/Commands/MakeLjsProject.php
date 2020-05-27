<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;

/**
 * Class MakeLjsProject
 * @package Lar\Layout\Commands
 */
class MakeLjsProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ljs-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command from make lar ljs project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $path = config('layout.resource_js_path', 'js');

        if (!is_dir(resource_path($path))) {

            mkdir(resource_path($path), 0777, true);
        }

        if (!is_dir(resource_path($path.'/components'))) {

            mkdir(resource_path($path.'/components'), 0777, true);
        }

        if (!is_dir(resource_path($path.'/executors'))) {

            mkdir(resource_path($path.'/executors'), 0777, true);
        }

        if (!is_dir(resource_path($path.'/watchers'))) {

            mkdir(resource_path($path.'/watchers'), 0777, true);
        }

        $resource_json = resource_path($path.'/lar_resources.json');

        if (!is_file($resource_json)) {

            $rf = <<<JSON
{
    "state_watchers": [],
    "executors": [],
    "vue_components": {}
}
JSON;

            file_put_contents($resource_json, $rf);
        }

        $resource_file = resource_path($path.'/lar_resource.js');

        if (!is_file($resource_file)) {

            $data = file_get_contents(__DIR__ . "/Stumbs/lar_resource");

            file_put_contents(resource_path($path.'/lar_scripts.js'), file_get_contents(__DIR__ . "/Stumbs/lar_scripts"));
            $this->info("Lar script file [resources/{$path}/lar_scripts.js] created!");

            file_put_contents(resource_path($path.'/lar_instance.js'), file_get_contents(__DIR__ . "/Stumbs/lar_instance"));
            $this->info("Lar instance file [resources/{$path}/lar_instance.js] created!");

            file_put_contents(resource_path($path.'/lar_methods.js'), file_get_contents(__DIR__ . "/Stumbs/lar_methods"));
            $this->info("Lar instance file [resources/{$path}/lar_methods.js] created!");

            file_put_contents(resource_path($path.'/app.js'), '');
            $this->info("Laravel application file [resources/{$path}/app.js] created!");

            $file_data = is_file(resource_path($path.'/app.js')) ? file_get_contents(resource_path($path.'/app.js')) : '';

            if (!preg_match('/require\s*\(.*lar_resource .*\)/', $file_data)) {

                file_put_contents(
                    resource_path($path.'/app.js'),
                    $file_data . "\nrequire('./lar_resource.js')"
                );

                $this->info(" > Required this file in you [resources/{$path}/app.js]!");
            }

            file_put_contents($resource_file, $data);
            $this->info("Lar resources file [resources/{$path}/lar_resource.js] created!");
        }

        else {

            $this->error("LJS project already exists!");
        }
    }

    /**
     * @param string $name
     * @param string $file
     * @return bool|int
     */
    public static function addVueComponent(string $name, string $file)
    {
        return static::addLineInToResource("ljs.vue.component('{$name}', require('./{$file}').default);");
    }

    /**
     * @param string $file
     * @return bool|int
     */
    public static function addExecutor(string $file)
    {
        return static::addLineInToResource("ljs.regExec(require('./{$file}'));", true);
    }

    /**
     * @param string $line
     * @param bool $prepend
     * @return bool|int
     */
    public static function addLineInToResource(string $line, bool $prepend = false)
    {
        $resource_file = resource_path('js/lar_resource.js');

        if (!is_file($resource_file)) {

            \Artisan::call("layout:make:vue-project");
        }

        $data = file_get_contents($resource_file);

        if (preg_match('/const\sload.*\{(.*)\}\;/sU', $data, $m)) {

            $add_line = !$prepend ? "\n    " . trim($m[1]) . "\n    {$line}\n" : "\n    {$line}\n    " . trim($m[1]) . "\n";

            $data = str_replace($m[1], $add_line, $data);

            return file_put_contents($resource_file, $data);
        }

        return 0;
    }
}
