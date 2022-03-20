<?php

namespace Lar\Layout\Core;

class LarJsonResource
{
    /**
     * @var string
     */
    private $resource;

    /**
     * LarJsonResource constructor.
     */
    public function __construct()
    {
        $path = config('layout.resource_js_path', 'js');
        $this->resource = resource_path($path.'/lar_resources.json');
    }

    /**
     * @param  string  $file
     * @return bool
     */
    public function addWatcher(string $file)
    {
        return $this->writeVar(['state_watchers' => [$file]]);
    }

    /**
     * @param  array  $array
     * @return bool|false|int
     */
    private function writeVar(array $array)
    {
        $file_data = $this->resource;

        if (is_file($file_data)) {
            $file_data = file_get_contents($file_data);

            $file_data = json_decode($file_data, 1);

            return file_put_contents(
                $this->resource,
                JsonFormatter::format(json_encode(array_merge_recursive($file_data, $array)), false, true)
            );
        }

        return false;
    }

    /**
     * @param  string  $file
     * @return bool
     */
    public function addExecutor(string $file)
    {
        return $this->writeVar(['executors' => [$file]]);
    }

    /**
     * @param  string  $name
     * @param  string  $file
     * @return bool
     */
    public function addVueComponent(string $name, string $file)
    {
        return $this->writeVar(['vue_components' => [$name => $file]]);
    }
}
