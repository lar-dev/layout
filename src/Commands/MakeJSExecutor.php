<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
    protected $signature = 'make:js {js_name : The js name of the Executor}
    {--dir= : Dir in to created path}';

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
        $dir = resource_path('js/executors');

        if ($dir_set = $this->option("dir")) {

            foreach (explode("/", $dir_set) as $item) {

                $dir .= "/{$item}";

                $this->prev_name .= $item . "_";
            }
        }

        if (!is_dir($dir)) {

            mkdir($dir, 0777, 1);
        }

        $file = $dir . "/" . $this->camel_name() . ".js";

        if (is_file($file)) {

            $this->error("The js executor [{$this->camel_name()}] already exists!"); return ;
        }

        $exec_data = str_replace([
            "{CLASS}", "{NAME}"
        ], [
            $this->camel_name(), $this->name()
        ], file_get_contents(__DIR__ . "/Stumbs/lar_executor"));

        $ins_file = str_replace(resource_path() . "/js/", "", $file);
        
        if (file_put_contents($file, $exec_data)) {

            $this->info("Executor [{$this->name()}][{$ins_file}] created!");

            MakeVueProject::addExecutor($ins_file);

            $this->info("Lar resources file [resources/js/lar_resource.js] updated!");
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
}
