<?php

namespace App\Http\Controllers;


use App\Models\File;
use Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;


class ImageController extends Controller
{
    public function nahrat(Request $request)
    {
        if(!Auth::check()){
            return abort(401, "Nejste přihlášeni.");
        }

        $user = Auth::user();

        $num_of_images = $user->school_id != null ?
            $user->school->images()->count() :
            $user->images()->count();

        if($num_of_images > settings("school_image_limit")){
            return response("Překročen maximální počet obrázků.<br /> Pokud chcete uvolnit místo pro nový obrázek, můžete tak učinit v profilu školy.", 400);
        }

        $request->validate([
            'file' => 'required|image|max:1024'
        ]);

        $img = Image::make($request->file)
            ->resize(800, null, function($constraint){
                $constraint->aspectRatio();
            });

        $filepath = "images/" . uniqid() . ".jpg";

        $img->save(public_path() . "/storage/" . $filepath, 100, "jpg");

        // if school does not exist use user for the ownership
        if($user->school_id != null){
            File::create([
                'school_id' => $user->school->id,
                'type' => 'image',
                'name' => $filepath
            ]);
        } else{
            File::create([
                'user_id' => $user->id,
                'type' => 'image',
                'name' => $filepath
            ]);
        }

        return [
            'location' => url('/storage/' . $filepath)
        ];
        //
    }

    public function smazat(File $file)
    {
        if(!Auth::check()){
            return abort(401);
        }

        DB::transaction(function() use ($file){
            unlink(public_path() . "/storage/" . $file->name);

            $file->delete();
        });

        return redirect("/dashboard");
    }
}
