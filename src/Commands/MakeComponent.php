<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Lar\Developer\Commands\Dump\GenerateBladeHelpers;
use Lar\Developer\Commands\Dump\GenerateHelper;
use Lar\EntityCarrier\Core\Entities\DocumentorEntity;
use Lar\Layout\Abstracts\Component;
use Lar\Layout\CfgFile;

/**
 * Class MakeComponent
 *
 * @package Lar\Layout\Commands
 */
class MakeComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:component {component_name : The component name}
    {--dir= : Dir in to created path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command from make lar component';

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
        $dir = base_path($this->option("dir") ? $this->option("dir") : 'app/Components');

        $namespace = "App\\Components";

        foreach ($this->component_segments() as $component_segment) {

            if ($component_segment != $this->component_name()) {

                $normal_part = ucfirst(Str::camel(Str::snake($component_segment)));

                $namespace .= "\\{$normal_part}";

                $dir .= "/{$normal_part}";
            }
        }

        $file = $dir . "/" . $this->class_name() . ".php";

        $class_namespace = "{$namespace}\\{$this->class_name()}";

        if (!is_dir($dir)) {

            mkdir($dir, 0777, 1);
        }

        if (is_file($file)) {

            $this->error("The component [{$this->class_name()}] already exists!"); return ;
        }

        $entity = class_entity($this->class_name());
        $entity->wrap('php');
        $entity->namespace($namespace);
        $entity->extend(Component::class);

        $entity->prop('protected:name', $this->name());
        $entity->prop('protected:handler_name', $this->name());
        $entity->prop('protected:props', entity('[]'));

        $entity->method('__construct')
            ->customParam('...$params')
            ->line()
            ->line('parent::__construct();')
            ->line()
            ->line('$this->when($params);');

        if (file_put_contents($file, $entity->render())) {

            CfgFile::open(config_path('components.php'))->write($this->name(), $class_namespace);

            $this->info("Config [config/components.php] updated!");

            $this->info("Component [{$file}] created!");

            $this->info("Dump autoload...");

            //system("composer dump-autoload");

            $this->call('lar:dump', [
                '--class' => GenerateBladeHelpers::class
            ]);

            $this->call('lar:dump', [
                '--class' => GenerateHelper::class
            ]);
        }

        return ;
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
        return array_map("Str::snake", explode("/", $this->input->getArgument('component_name')));
    }
}
