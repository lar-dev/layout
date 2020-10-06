<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Lar\Layout\Core\LarJsonResource;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ContentableCommand
 *
 * @package Lar\Layout\Commands
 */
class MakeJSExecutor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:js-executor';

    /**
     * @var string
     */
    protected $prev_name = "";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command from make blank js executor';

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
     */
    public function handle()
    {
        $dir = $this->rp('/executors');

        if (!is_dir($dir)) {

            mkdir($dir, 0777, 1);
        }

        $file_name = $this->camel_name() . ".js";
        $file = $dir . "/" . $file_name;

        if (is_file($file)) {

            $this->error("The js executor [{$this->camel_name()}] already exists!"); return ;
        }

        $exec_data = str_replace([
            "{CLASS}", "{NAME}"
        ], [
            $this->camel_name(), $this->name()
        ], file_get_contents(__DIR__ . "/Stumbs/lar_executor"));

        $ins_file = str_replace($this->rp() . "/", "", $file);
        
        if (file_put_contents($file, $exec_data)) {

            $this->info("Executor [{$this->name()}][{$ins_file}] created!");

            (new LarJsonResource())->addExecutor($file_name);
        }
    }

    /**
     * @return string
     */
    protected function camel_name()
    {
        return ucfirst(Str::camel($this->name()));
    }

    /**
     * @return string
     */
    protected function name()
    {
        return Str::slug($this->prev_name.$this->argument('js_name'), '_');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['js_name', InputArgument::REQUIRED, 'The js name of the Executor'],
        ];
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
