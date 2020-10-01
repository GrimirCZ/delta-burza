<?php

namespace App\Console\Commands;

use App\Models\File;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileMigrateToS3 extends Command
{
    protected $signature = 'files:migrate:s3';

    protected $description = 'Migrate all local files to s2';

    private function upload_files(Filesystem $s3, $files, $dir, $handler = null)
    {
        $this->info("Migrating $dir...");

        foreach($files as $file){

            $this->info("$dir: $file");

            $filepath = "$dir/" . basename($file);
            $original_path = Storage::path($file);

            if(!$s3->exists("brojures")){
                $s3->makeDirectory("brojures");
            }

            $s3->put($filepath, file_get_contents($original_path), 'public');

            if($handler != null){
                $handler($file, $s3->url($filepath));
            }
        }
    }

    public function handle()
    {

        $brojures = Storage::allFiles("public/brojures");
        $images = Storage::allFiles("public/images");
        $logos = Storage::allFiles("public/logos");
        $invoices = Storage::allFiles("public/invoices");

        $s3 = Storage::disk("s3");

        $this->info("Starting migration...");

        $this->upload_files($s3, $images, "images", function($original_filename, $url){
            $db_name = substr($original_filename, 7);

            DB::transaction(function() use ($url, $db_name){
                File::where("type", "=", "image")
                    ->whereLike("name", 'like', "%" . $db_name . "%")
                    ->update([
                        'name' => $url
                    ]);


                DB::update("
                   UPDATE schools SET description = replace(description, '../storage/$db_name', '$url')
                ");
            });
        });
        $this->upload_files($s3, $brojures, "brojures", function($original_filename, $url){
            File::where("type", "=", "brojure")
                ->where("name", 'like', "%" . substr($original_filename, 7) . "%")
                ->update([
                    'name' => $url
                ]);
        });
        $this->upload_files($s3, $logos, "logos", function($original_filename, $url){
            File::where("type", "=", "logo")
                ->where("name", 'like', "%" . substr($original_filename, 7) . "%")
                ->update([
                    'name' => $url
                ]);
        });
        $this->upload_files($s3, $invoices, "invoices", function($original_filename, $url){
            Order::where("invoice", 'like', "%" . basename($original_filename) . "%")
                ->update([
                    'invoice' => $url
                ]);
        });


        $this->info("Success");
        //
    }
}
