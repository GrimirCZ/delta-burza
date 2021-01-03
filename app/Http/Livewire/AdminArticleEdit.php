<?php

namespace App\Http\Livewire;

use App\Article;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminArticleEdit extends Component
{
    use WithFileUploads;

    public ?Article $article = null;
    public ?string $title = null;
    public ?string $content = null;
    public ?string $date = null;
    public $cover = null;

    protected $rules = [
        'title' => 'required|max:512',
        'content' => 'required',
        'date' => 'required',
        'cover' => 'nullable|sometimes|file|max:1024', // 1MB Max
    ];


    public function submit()
    {
        $this->validate();

        $this->article->update([
            'title' => $this->title,
            'content' => $this->content,
            'date' => $this->date,
        ]);

        if($this->cover){
            $s3 = Storage::disk("s3");

            $img = Image::make($s3->get($this->cover->getRealPath()))
                ->resize(800, null, function($constraint){
                    $constraint->aspectRatio();
                });

            $filepath = "images/" . uniqid() . ".jpg";

            $s3->put($filepath, $img->stream('jpg', 100), 'public');

            $this->article->cover_image = $s3->url($filepath);
        }

        $this->article->push();

        return $this->redirect('/admin');
    }

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->title = $this->article->title;
        $this->content = $this->article->content;
        $this->date = explode(" ",$this->article->date)[ 0];
//        dd($this);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.admin-article-create', [
            'edit' => true
        ]);
    }
}
