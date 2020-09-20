<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public String $url;
    public String $class;

    public function __construct($url, $class = '')
    {
        $this->url = $url;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.button');
    }
}
