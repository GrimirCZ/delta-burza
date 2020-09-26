<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RichTextEditor extends Component
{
    private string $label;
    private string $field;

    public function __construct(string $label, string $field)
    {
        $this->label = $label;
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.rich-text-editor', [
            'label' => $this->label,
            'field' => $this->field
        ]);
    }
}
