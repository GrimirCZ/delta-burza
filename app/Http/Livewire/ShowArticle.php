<?php

namespace App\Http\Livewire;

use App\Article;
use Livewire\Component;

class ShowArticle extends Component
{
    public Article $article;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-article');
    }
}
