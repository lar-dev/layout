<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;

class MakeVueProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:ljs-project';

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
        if (!is_dir(resource_path('js'))) {

            mkdir(resource_path('js'), 0777, true);
        }

        $resource_file = resource_path('js/lar_resource.js');

        if (!is_file($resource_file)) {

            $data = file_get_contents(__DIR__ . "/Stumbs/lar_resource");

            file_put_contents(resource_path('js/lar_scripts.js'), file_get_contents(__DIR__ . "/Stumbs/lar_scripts"));
            $this->info("Lar script file [resources/js/lar_scripts.js] created!");

            file_put_contents(resource_path('js/lar_instance.js'), file_get_contents(__DIR__ . "/Stumbs/lar_instance"));
            $this->info("Lar instance file [resources/js/lar_instance.js] created!");

            file_put_contents(resource_path('js/lar_methods.js'), file_get_contents(__DIR__ . "/Stumbs/lar_methods"));
            $this->info("Lar instance file [resources/js/lar_methods.js] created!");

            file_put_contents(resource_path('js/app.js'), '');
            $this->info("Laravel application file [resources/js/app.js] created!");

            $file_data = file_get_contents(resource_path('js/app.js'));

            if (!preg_match('/require\s*\(.*lar_resource .*\)/', $file_data)) {

                file_put_contents(
                    resource_path('js/app.js'),
                    $file_data . "\nrequire('./lar_resource.js')"
                );

                $this->info(" > Required this file in you [resources/js/app.js]!");
            }

            file_put_contents($resource_file, $data);
            $this->info("Lar resources file [resources/js/lar_resource.js] created!");
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
