<?php

namespace App\Helper;



use Illuminate\Support\Str;


class Helper
{
    // Upload Image
    public static function  uploadImage($file, $folder) {
        if (!$file->isValid()) {
            return null;
        }

        $imageName = Str::slug(time()) . '.' . $file->extension();
        $path      = public_path('uploads/' . $folder);
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $file->move($path, $imageName);
        return 'uploads/' . $folder . '/' . $imageName;
    }


}
