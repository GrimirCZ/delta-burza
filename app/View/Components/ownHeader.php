<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ownHeader extends Component
{
    public $top;
    public $bottom;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($top = "", $bottom = "", $class = "")
    {
        $this->top = $top;
        $this->bottom = $bottom;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.own-header');
    }
}
