<?php

namespace App\Http\Controllers;


use App\Models\File;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use function Symfony\Component\String\u;


class ImageController extends Controller
{
    public function nahrat(Request $request)
    {
        if(!Auth::check()){
            return abort(401, "Nejste přihlášeni.");
        }

        $user = Auth::user();

//        $num_of_images = $user->school_id != null ?
//            $user->school->images()->count() :
//            $user->images()->count();
//
//        if($num_of_images > settings("school_image_limit")){
//            return response("Překročen maximální počet obrázků.<br /> Pokud chcete uvolnit místo pro nový obrázek, můžete tak učinit v profilu školy.", 400);
//        }

        $request->validate([
            'file' => 'required|image|max:1024'
        ]);

        $img = Image::make($request->file)
            ->resize(800, null, function($constraint){
                $constraint->aspectRatio();
            });

        $filepath = "images/" . uniqid() . ".jpg";


        $s3 = Storage::disk("s3");
        $s3->put($filepath, $img->stream('jpg', 100), 'public');
        $url = $s3->url($filepath);

        // if school does not exist use user for the ownership
        if($user->school_id != null){
            File::create([
                'school_id' => $user->school->id,
                'type' => 'image',
                'name' => $url
            ]);
        } else{
            File::create([
                'user_id' => $user->id,
                'type' => 'image',
                'name' => $url
            ]);
        }

        return [
            'location' => $url
        ];
        //
    }

    public function smazat(File $file)
    {
        if(!Auth::check()){
            return abort(401);
        }
        if($file->user_id != null && $file->user_id != Auth::user()->id){
            return abort(401);
        }
        if($file->school_id != null && $file->school->id != Auth::user()->school->id){
            return abort(401);
        }

        $file->delete();

        return redirect("/dashboard");
    }
}
