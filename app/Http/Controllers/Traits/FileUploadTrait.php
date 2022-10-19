<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use ZipArchive;
use Illuminate\Support\Facades\File;
use RarArchiver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use DirectoryIterator;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Closure;

trait FileUploadTrait
{


    //update image ground
    public function image($file, $destinationpath)
    {
        $user_id = Auth::user()->id;
        $name = time() . $user_id . "_" . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $file->move($destinationpath, $name);
        $path = $destinationpath . $name;


        return $path;
    }


    public function update_image($file, $name, $middlepath, $attribute)
    {

        $destinationpath = public_path() . "/" . $middlepath;

        $user_id = Auth::user()->id;
        $name = $name . "-" . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

        if ($attribute == null || file_exists($attribute) == false) {
            $file->move($destinationpath, $name);
            $path = $middlepath . $name;
        } else {
            if (Str::contains($attribute, 'default')) {

                $file->move($destinationpath, $name);
                $path = $middlepath . $name;
            } else {
                unlink($attribute);
                $file->move($destinationpath, $name);
                $path = $middlepath . $name;
            }
        }

        return $path;
    }

    public function DeleteFolder($attribute, $extension)
    {

        if (file_exists($attribute)) {

            $oldzip = explode($extension, $attribute)[0];

            if (is_dir($oldzip)) {
                File::deleteDirectory($oldzip); //xoa dc file nay
            } else {
                unlink($attribute);
            }
        }
    }

    public function checkFolder($destinationpath){
        if (!file_exists($destinationpath)) {
            mkdir($destinationpath, 0777, true);
        }

    }
}
