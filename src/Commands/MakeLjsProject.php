<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeLjsProject.
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
        $dirs = ['', '/components', '/executors', '/watchers'];

        foreach ($dirs as $dir) {
            $dir = $this->rp($dir);

            if (! is_dir($dir)) {
                mkdir($dir, 0777, true);
                $this->info("Folder [{$dir}] created!");
            }
        }

        $files = [
            '/components/Components.js' => 'Components',
            '/lar_scripts.js' => 'lar_scripts',
            '/lar_instance.js' => 'lar_instance',
            '/lar_methods.js' => 'lar_methods',
            '/lar_resources.json' => 'lar_resources',
            '/lar_resource.js' => 'lar_resource',
            '/app.js' => null,
        ];

        foreach ($files as $path => $stub) {
            $path = $this->rp($path);

            if (! is_file($path)) {
                file_put_contents($path, $stub ? file_get_contents(__DIR__."/Stumbs/{$stub}") : '');
                $this->info("Script file [{$path}] created!");
            }
        }

        $file_data = file_get_contents($this->rp('/app.js'));

        if (! preg_match('/require\s*\(.*lar_resource.*\)/', $file_data)) {
            file_put_contents(
                $this->rp('/app.js'),
                $file_data."\nrequire('./lar_resource.js')"
            );

            $this->info(' > Required lar in you [/app.js]!');
        }

        $this->info('Lar resources file [/lar_resource.js] created!');
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
    protected function rp(string $path = '')
    {
        if ($this->option('dir')) {
            return '/'.trim(base_path($this->option('dir').'/'.trim($path, '/')), '/');
        }

        return '/'.trim(resource_path(config('layout.resource_js_path', 'js').'/'.trim($path, '/')), '/');
    }
}
