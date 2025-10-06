<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TagsInput extends Component
{
    public $name;
    public $tags;
    public $options;
    public $label;
    public $required;
    public $placeholder;

    public function __construct(
        $name = 'tags',
        $tags = [],
        $options = [],
        $label = null,
        $required = false,
        $placeholder = 'Add a tag...'
    ) {
        $this->name = $name;
        $this->tags = $this->ensureArray($tags);
        $this->options = $this->ensureArray($options);
        $this->label = $label;
        $this->required = $required;
        $this->placeholder = $placeholder;
    }

    private function ensureArray($value): array
    {
        if (is_null($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            // Try to decode JSON first
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            // Fallback to comma-separated
            return array_filter(array_map('trim', explode(',', $value)));
        }

        if (is_object($value) && method_exists($value, 'toArray')) {
            return $value->toArray();
        }

        return [];
    }

    public function render()
    {
        return view('components.tags-input');
    }
}