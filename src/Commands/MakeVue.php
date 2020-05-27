<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Lar\EntityCarrier\Core\Entities\DocumentorEntity;
use Lar\Layout\Abstracts\Component;
use Lar\Layout\Abstracts\LayoutComponent;
use Lar\Layout\CfgFile;
use Lar\Layout\Core\LarJsonResource;
use Lar\Tagable\Tag;
use Lar\Tagable\Vue;

/**
 * Class ContentableCommand
 *
 * @package Lar\Layout\Commands
 */
class MakeVue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:js-vue {vue_name : The vue component name}
    {--dir= : Dir in to created path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command from make lar-vue component';

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

        $dir = app_path('Components/Vue');
        $dir_resource = resource_path($path.'/components');

        $namespace = "App\\Components\\Vue";

        if ($dir_set = $this->option("dir")) {

            foreach (explode("/", $dir_set) as $item) {

                $normal_part = ucfirst(Str::camel(Str::snake($item)));

                $namespace .= "\\{$normal_part}";

                $dir .= "/{$normal_part}";

                $dir_resource .= "/" . Str::snake($item);
            }
        }

        foreach ($this->component_segments() as $component_segment) {

            if ($component_segment != $this->component_name()) {

                $normal_part = ucfirst(Str::camel(Str::snake($component_segment)));

                $namespace .= "\\{$normal_part}";

                $dir .= "/{$normal_part}";
            }
        }

        $class_namespace = "{$namespace}\\{$this->class_name()}";

        if (class_exists($class_namespace)) {

            $this->error("The class [{$class_namespace}] already exists!"); return ;
        }

        $file = $dir . "/" . $this->class_name() . ".php";

        if (!is_dir($dir)) {

            mkdir($dir, 0777, 1);
        }

        if (!is_dir($dir_resource)) {

            mkdir($dir_resource, 0777, 1);
        }

        if (is_file($file)) {

            $this->error("The vue [{$this->class_name()}] already exists!"); return ;
        }

        $entity = class_entity($this->class_name());
        $entity->wrap('php');
        $entity->namespace($namespace);
        $entity->extend(Vue::class);

        $entity->prop('protected:element', $this->name());
        $entity->prop('protected:name', $this->name());
        $entity->prop('protected:handler_name', $this->name());

        if (file_put_contents($file, $entity->render())) {

            $this->info("Lar component [{$file}] created!");

            CfgFile::open(config_path('components.php'))->write($this->name(), $class_namespace);

            $this->info("Config [config/components.php] updated!");
        }

        $js_template = <<<HTML
<template>
    <div>{$this->class_name()} Component</div>
</template>

<script>
    export default {
        name: "{$this->name()}",
        data () {
            return {
                
            };
        },
        mounted () {},
        methods: {}
    }
</script>
HTML;

        $file_resource = $dir_resource . "/" . $this->class_name() . ".vue";

        if (!is_file($file_resource) && file_put_contents($file_resource, $js_template)) {

            $this->info("Vue component [{$file_resource}] created!");
        }

        (new LarJsonResource())->addVueComponent($this->name(), $this->class_name() . ".vue");

        $this->info("Done! Vue component [{$this->class_name()}] created!");

        $this->call_composer('dump-autoload');

        return ;
    }

    /**
     * @param  string  $command
     * @return null
     */
    protected function call_composer(string $command)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

            $this->comment("> Use \"composer {$command}\" for finish!");

        } else {

            exec('cd ' . base_path() . " && composer {$command}");
        }

        return null;
    }

    /**
     * Get class name
     *
     * @return string|string[]|null
     */
    protected function class_name()
    {
        return ucfirst(Str::camel($this->name()));
    }

    /**
     * @return string
     */
    protected function name () {

        return Str::slug($this->component_name(), '_');
    }

    /**
     * @return mixed
     */
    protected function component_name()
    {
        return \Arr::last($this->component_segments());
    }

    /**
     * @return array
     */
    protected function component_segments()
    {
        return array_map("Str::snake", explode("/", $this->input->getArgument('vue_name')));
    }
}
