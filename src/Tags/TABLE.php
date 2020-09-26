<?php

namespace Lar\Layout\Tags;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Lar\Layout\Abstracts\Component;
use Lar\Tagable\Events\onRender;
use Lar\Tagable\Tag;

class TABLE extends Component
{
    /**
     * Tag element
     *
     * @var string
     */
    protected $element = "table";

    /**
     * TABLE constructor.
     *
     * @param mixed ...$params
     * @throws \Exception
     */
    public function __construct(...$params)
    {
        parent::__construct();

        $this->when($params);
    }
}
