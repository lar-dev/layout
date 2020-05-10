<?php

namespace Lar\Layout\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lar\Developer\Commands\Dump\GenerateJaxHelper;
use Lar\EntityCarrier\Core\Entities\ClassMethodEntity;
use Lar\Layout\CfgFile;
use Lar\Layout\JaxExecutor;

class MakeJaxExecutor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:jax {jax_name : The jax name of the Executor}
        {--dir= : Dir in to created path}
        {--demo : Create demo methods}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command from make blank Jax executor';

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
        $dir = app_path('Http/JaxExecutors');

        $namespace = "App\\Http\\JaxExecutors";

        if ($dir_set = $this->option("dir")) {

            foreach (explode("/", $dir_set) as $item) {

                $normal_part = ucfirst(Str::camel(Str::snake($item)));

                $namespace .= "\\{$normal_part}";

                $dir .= "/{$normal_part}";
            }
        }

        foreach ($this->jax_segments() as $component_segment) {

            if ($component_segment !== $this->jax_name()) {

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

        $obj = class_entity($this->class_name())->wrap('php')
            ->namespace($namespace)
            ->extend(JaxExecutor::class);

        $obj->method('access')->line()->dataReturn('true')->docReturnType('bool');

        if ($this->option('demo')) {

            $obj->prop("protected:status", 200);

            $obj->method("__invoke")
                ->line()
                ->line("/**")
                ->line(" * JS Example")
                ->line(" *")
                ->line(" * ljs.\$jax.cmd(\"{$this->name()}\").send();")
                ->line(" */")
                ->line()
                ->line("\$this->toast_success(\"Jax Executor [{$this->class_name()}][{$this->name()}]\");");

            $obj->method("test")
                ->param('name')
                ->line()
                ->line("/**")
                ->line(" * JS Example")
                ->line(" *")
                ->line(" * ljs.\$jax.cmd(\"{$this->name()}\").call(\"test\", 'you_name').send();")
                ->line(" */")
                ->line()
                ->line("\$this->toast_success(\"Hello, {\$name}\");");
        }

        if (file_put_contents($file, $obj->render())) {

            CfgFile::open(config_path('executors.php'))->write($this->name(), $class_namespace);

            $this->info("Add [{$this->name()}] to [config/executors.php]!");

            $this->info("Executor [{$file}] created!");

            $this->call('lar:dump');
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

        return Str::slug($this->jax_name(), '_');
    }

    /**
     * @return mixed
     */
    protected function jax_name()
    {
        return \Arr::last($this->jax_segments());
    }

    /**
     * @return array
     */
    protected function jax_segments()
    {
        return array_map("Str::snake", explode("/", $this->input->getArgument('jax_name')));
    }
}
