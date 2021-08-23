<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Lar\EntityCarrier\Core\Entities\DocumentorEntity;
use Lar\Layout\Abstracts\LayoutComponent;

/**
 * Class ContentableCommand
 *
 * @package Lar\Layout\Commands
 */
class MakeLayout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:layout {layout_name : The layout name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command from make lar layout';

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
        $dir = app_path('Layouts');

        $file = $dir . "/" . $this->class_name() . ".php";

        if (!is_dir($dir)) {

            mkdir($dir, 0777, 1);
        }

        if (is_file($file)) {

            $this->error("The layout [{$this->class_name()}] already exists!"); return ;
        }

        $entity = class_entity($this->class_name());
        $entity->wrap('php');
        $entity->namespace("App\\Layouts");
        $entity->extend(LayoutComponent::class);

        $entity->prop('protected:name', $this->input->getArgument('layout_name'));
        $entity->prop('protected:head_styles', ['css/app.css','ljs/css/ljs.css', 'ljs']);
        $entity->prop('protected:body_scripts', ['js/app.js', 'ljs' => ['jquery', 'jq', 'alert', 'nav', 'vue']]);
        $entity->prop('protected:metas', entity('[]'));
        $entity->prop('protected:pjax', false)->doc(function ($documentor) {
            /** @var DocumentorEntity $documentor */
            $documentor->description("To enable the module, specify the container identifier in the parameter.");
            $documentor->tagVar("bool|string");
        });

        if (file_put_contents($file, $entity->render())) {

            $this->info("Layout [{$file}] created!");
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
        return ucfirst(Str::camel($this->input->getArgument('layout_name')));
    }
}
