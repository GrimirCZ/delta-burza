<?php

namespace App\Console\Commands;

use App\Models\School;
use Illuminate\Console\Command;

class GenerateContentDispositionCommands extends Command
{
    protected $signature = 'generate:content-disposition-commands';

    protected $description = 'Generate content disposition commands for all school brojures';

    public function handle()
    {
        $this->info("#!/bin/env bash");
        $bucket_name = config('filesystems.disks.s3.bucket');

        if(!$bucket_name){
            $this->error('# Could not find filesystems.disks.s3.bucket or invalid value');
            return;
        }

        foreach(School::all() as $school){
            $brojure = $school->files()->where("type", "brojure")->first();
            if($brojure == null){
                $this->error("# School " . $school->name . " does not have brojure.");
                continue;
            }

            $url = $brojure->name;

            $filename = substr($url, strrpos($url, '/', -1) + 1, strlen($url));
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            $contentDisposition = "attachment;filename=\\\"$school->name brožura.$ext\\\"";

            $this->info("aws s3api copy-object --bucket $bucket_name  \
--copy-source /$bucket_name/brojures/$filename --key brojures/$filename \
--metadata-directive REPLACE --content-disposition \"$contentDisposition\" --acl public-read");
        }

        //
    }
}

