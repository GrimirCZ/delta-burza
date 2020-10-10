<?php

namespace App\Http\Livewire;

use App\Article;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class AdminArticleCreate extends Component
{
    public ?string $title;
    public ?string $content;

    protected $rules = [
        'title' => 'required|max:512',
        'content' => 'required'
    ];

    public function submit()
    {
        $this->validate();

        Article::create([
            'title' => $this->title,
            'content' => $this->content
        ]);

        return $this->redirect('/admin');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.admin-article-create');
    }
}
