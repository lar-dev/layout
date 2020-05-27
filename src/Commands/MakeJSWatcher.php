<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Lar\Layout\Core\LarJsonResource;

/**
 * Class ContentableCommand
 *
 * @package Lar\Layout\Commands
 */
class MakeJSWatcher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:js-watcher {js_name : The js name of the Executor}
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
        $path = config('layout.resource_js_path', 'js');

        $dir = resource_path($path.'/watchers');

        if ($dir_set = $this->option("dir")) {

            foreach (explode("/", $dir_set) as $item) {

                $dir .= "/{$item}";

                $this->prev_name .= $item . "_";
            }
        }

        if (!is_dir($dir)) {

            mkdir($dir, 0777, 1);
        }

        $file_name = $this->camel_name() . ".js";
        $file = $dir . "/" . $file_name;

        if (is_file($file)) {

            $this->error("The js watcher [{$this->camel_name()}] already exists!"); return ;
        }

        $exec_data = str_replace([
            "{CLASS}", "{NAME}"
        ], [
            $this->camel_name(), $this->name()
        ], file_get_contents(__DIR__ . "/Stumbs/lar_watcher"));

        $ins_file = str_replace(resource_path() . "/{$path}/", "", $file);
        
        if (file_put_contents($file, $exec_data)) {

            $this->info("Watcher [{$this->name()}][{$ins_file}] created!");

            (new LarJsonResource())->addWatcher($file_name);
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
