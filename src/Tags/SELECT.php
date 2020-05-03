<?php

namespace Lar\Layout\Tags;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Lar\Layout\Abstracts\Component;

class SELECT extends Component
{
    /**
     * Tag element
     *
     * @var string
     */
    protected $element = "select";

    /**
     * Add options from array
     *
     * @param array $data
     * @param null $select
     * @return $this
     */
    public function options($data = [], $select = null)
    {
        if ($select instanceof Collection) {

            $select = $select->pluck('id');
        }

        if ($select instanceof Arrayable) {

            $select = $select->toArray();
        }

        foreach ($data as $key => $val) {

            $last = $this->option($val)
                ->setValue((string)$key);

            if (is_array($select) && (array_search($key, $select) !== false)) {

                $last->setSelected();
            }

            else if ($select == $key) {

                $last->setSelected();
            }

            else if ($this->getValue() == $key) {

                $last->setSelected();
            }
        }

        return $this;
    }
}
