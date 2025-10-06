<?php
namespace App\View\Components;

use Illuminate\View\Component;

class SortableColumn extends Component
{
    public $column;
    public $label;
    public $sort;
    public $direction;

    public function __construct($column, $label, $sort, $direction)
    {
        $this->column = $column;
        $this->label = $label;
        $this->sort = $sort;
        $this->direction = $direction;
    }

    public function render()
    {
        return view('components.sortable-column');
    }
}
