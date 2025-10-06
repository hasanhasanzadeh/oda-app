<?php

namespace App\View\Components;


use Illuminate\View\Component;


class SearchSelect extends Component
{
    public $name;
    public $multiple;
    public $placeholder;
    public $selected;


    public function __construct($name = 'items', $multiple = false, $placeholder = 'جستجو...', $selected = [])
    {
        $this->name = $name;
        $this->multiple = filter_var($multiple, FILTER_VALIDATE_BOOLEAN);
        $this->placeholder = $placeholder;
        $this->selected = is_array($selected) ? $selected : [$selected];
    }


    public function render()
    {
        return view('components.advanced-search-select');
    }
}