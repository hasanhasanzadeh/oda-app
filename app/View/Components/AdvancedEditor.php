<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdvancedEditor extends Component
{
    public function __construct(
        public string $name = 'content',
        public string $label = 'Content',
        public string $value = '',
        public string $theme = 'light',
        public string $preset = 'standard',
        public array $toolbar = [],
        public int $height = 400,
        public bool $imageUpload = true,
        public bool $fileUpload = false,
        public array $plugins = [],
        public array $config = [],
        public string $placeholder = 'Start typing...',
        public bool $autosave = false,
        public int $autosaveInterval = 10000,
        public bool $wordCount = true,
        public int $maxLength = 0,
        public bool $sourceEditing = false,
        public bool $tables = true,
        public bool $lists = true,
        public bool $links = true,
        public bool $mediaEmbed = true,
        public bool $codeBlocks = false,
        public bool $math = false,
        public bool $mentions = false,
        public array $mentionFeeds = [],
        public bool $collaboration = false,
        public string $language = 'en',
        public bool $rtl = false
    ) {}

    public function render()
    {
        return view('components.advanced-editor');
    }

    public function getToolbarConfig(): array
    {
        if (!empty($this->toolbar)) {
            return $this->toolbar;
        }

        return match ($this->preset) {
            'minimal' => [
                'bold', 'italic', '|', 'link', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
            ],
            'basic' => [
                'heading', '|',
                'bold', 'italic', 'underline', '|',
                'link', 'bulletedList', 'numberedList', '|',
                'insertTable', 'blockQuote', '|',
                'undo', 'redo'
            ],
            'standard' => [
                'heading', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                'link', 'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', 'alignment', '|',
                'insertTable', 'blockQuote', 'horizontalLine', '|',
                $this->imageUpload ? 'uploadImage' : null,
                $this->mediaEmbed ? 'mediaEmbed' : null,
                $this->codeBlocks ? 'codeBlock' : null,
                '|',
                'undo', 'redo', '|',
                $this->sourceEditing ? 'sourceEditing' : null
            ],
            'full' => [
                'heading', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                'link', 'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', 'alignment', '|',
                'insertTable', 'blockQuote', 'horizontalLine', 'pageBreak', '|',
                $this->imageUpload ? 'uploadImage' : null,
                $this->fileUpload ? 'insertImage' : null,
                $this->mediaEmbed ? 'mediaEmbed' : null,
                $this->codeBlocks ? 'codeBlock' : null,
                $this->math ? 'MathType' : null,
                '|',
                'findAndReplace', 'selectAll', '|',
                'undo', 'redo', '|',
                $this->sourceEditing ? 'sourceEditing' : null,
                'restrictedEditingException'
            ],
            default => [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'insertTable', 'blockQuote', '|',
                $this->imageUpload ? 'uploadImage' : null,
                $this->mediaEmbed ? 'mediaEmbed' : null,
                '|',
                'undo', 'redo'
            ]
        };
    }

    public function getPluginsList(): array
    {
        $basePlugins = [
            'Essentials', 'UploadAdapter', 'Autoformat', 'Bold', 'Italic', 'BlockQuote',
            'Heading', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload',
            'Indent', 'Link', 'List', 'MediaEmbed', 'Paragraph', 'PasteFromOffice',
            'Table', 'TableToolbar', 'TextTransformation', 'CloudServices'
        ];

        $conditionalPlugins = [];

        if ($this->tables) {
            $conditionalPlugins = array_merge($conditionalPlugins, [
                'TableProperties', 'TableCellProperties', 'TableColumnResize'
            ]);
        }

        if ($this->preset === 'standard' || $this->preset === 'full') {
            $conditionalPlugins = array_merge($conditionalPlugins, [
                'Underline', 'Strikethrough', 'Subscript', 'Superscript',
                'FontSize', 'FontFamily', 'FontColor', 'FontBackgroundColor',
                'Alignment', 'TodoList', 'HorizontalLine'
            ]);
        }

        if ($this->preset === 'full') {
            $conditionalPlugins = array_merge($conditionalPlugins, [
                'PageBreak', 'FindAndReplace', 'SelectAll', 'RestrictedEditingMode'
            ]);
        }

        if ($this->codeBlocks) {
            $conditionalPlugins[] = 'CodeBlock';
        }

        if ($this->sourceEditing) {
            $conditionalPlugins[] = 'SourceEditing';
        }

        if ($this->wordCount) {
            $conditionalPlugins[] = 'WordCount';
        }

        if ($this->mentions) {
            $conditionalPlugins[] = 'Mention';
        }

        if ($this->autosave) {
            $conditionalPlugins[] = 'Autosave';
        }

        if ($this->math) {
            $conditionalPlugins[] = 'MathType';
        }

        return array_merge($basePlugins, $conditionalPlugins, $this->plugins);
    }
}