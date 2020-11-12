<?php

namespace App\Http\Controllers;


use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AdminStaticResourceController extends Controller
{
    public function __invoke(Request $request, Response $response)
    {
        $q = $request->query("path");

        if($q == null){
            return abort(400);
        }

        $s3 = Storage::disk("private_s3");

        if($s3->missing($q)){
            return abort(404, "File not found");
        }

        return $s3->download($q);
        //
    }
}
