<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

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
    protected $name = 'ljs-project';

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
        if (!is_dir($this->rp())) {

            mkdir($this->rp(), 0777, true);
        }

        if (!is_dir($this->rp('/components'))) {

            mkdir($this->rp('/components'), 0777, true);
        }

        if (!is_dir($this->rp('/executors'))) {

            mkdir($this->rp('/executors'), 0777, true);
        }

        if (!is_dir($this->rp('/watchers'))) {

            mkdir($this->rp('/watchers'), 0777, true);
        }

        $resource_file = $this->rp('/lar_resource.js');

        if (!is_file($resource_file)) {

            $resource_json = $this->rp('/lar_resources.json');

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

            $data = file_get_contents(__DIR__ . "/Stumbs/lar_resource");

            file_put_contents($this->rp('/lar_scripts.js'), file_get_contents(__DIR__ . "/Stumbs/lar_scripts"));
            $this->info("Lar script file [/lar_scripts.js] created!");

            file_put_contents($this->rp('/lar_instance.js'), file_get_contents(__DIR__ . "/Stumbs/lar_instance"));
            $this->info("Lar instance file [/lar_instance.js] created!");

            file_put_contents($this->rp('/lar_methods.js'), file_get_contents(__DIR__ . "/Stumbs/lar_methods"));
            $this->info("Lar instance file [/lar_methods.js] created!");

            file_put_contents($this->rp('/app.js'), '');
            $this->info("Laravel application file [/app.js] created!");

            $file_data = is_file($this->rp('/app.js')) ? file_get_contents($this->rp('/app.js')) : '';

            if (!preg_match('/require\s*\(.*lar_resource .*\)/', $file_data)) {

                file_put_contents(
                    $this->rp('/app.js'),
                    $file_data . "\nrequire('./lar_resource.js')"
                );

                $this->info(" > Required this file in you [/app.js]!");
            }

            file_put_contents($resource_file, $data);
            $this->info("Lar resources file [/lar_resource.js] created!");
        }

        else {

            $this->error("LJS project already exists!");
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['dir', 'd', InputOption::VALUE_OPTIONAL, 'Directory of creation'],
        ];
    }

    /**
     * @param  string  $path
     * @return string
     */
    protected function rp(string $path = "")
    {
        if ($this->option('dir')) {

            return "/". trim(base_path($this->option('dir') . '/' . trim($path, '/')), '/');
        }
        return "/". trim(resource_path(config('layout.resource_js_path', 'js') . '/' . trim($path, '/')), '/');
    }
}
