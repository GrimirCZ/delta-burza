<?php

namespace App\Http\Livewire;

use App\Article;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminArticleCreate extends Component
{
    use WithFileUploads;

    public ?string $title;
    public ?string $content;
    public ?string $date;
    public $cover;

    protected $rules = [
        'title' => 'required|max:512',
        'content' => 'required',
        'date' => 'required',
        'cover' => 'nullable|file|max:1024', // 1MB Max
    ];

    public function submit()
    {
        $this->validate();

        if($this->cover){
            $img = Image::make($this->cover)
                ->resize(800, null, function($constraint){
                    $constraint->aspectRatio();
                });

            $filepath = "images/" . uniqid() . ".jpg";

            $s3 = Storage::disk("s3");
            $s3->put($filepath, $img->stream('jpg', 100), 'public');
            $url = $s3->url($filepath);
        }else{
            $url = null;
        }

        Article::create([
            'title' => $this->title,
            'content' => $this->content,
            'date' => $this->date,
            'cover_image' => $url,
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
