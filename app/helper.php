<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Image;

function GetUserRole($user)
{
    $userRole = $user->roles;
    return count($userRole) > 0 ? $userRole[0] : '';
}

function statusClasses($status)
{ 
    if($status)
        return 'success';
    return 'warning';
}

function saveResizeImage($file, $directory, $width=null)
{
    if (!Storage::exists($directory)) {
        Storage::makeDirectory("$directory");
    }
    $is_preview = strpos($directory, 'previews') !== false;
    $filename = Str::random() . time() . '.png';
    $path = "$directory/$filename";
    $img = \Image::make($file)->orientate()->encode('png', $is_preview ? 40 : 85)->resize($width, null, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });
    if ($width == $is_preview) {
        $img = $img->blur(60);
    }
    $resource = $img->stream()->detach();
    //add public
    Storage::disk('public')->put($path, $resource, 'public');
    return $path;
}

function getImage($image, $isAvatar = false, $isFlag = false)
{
    if ($isFlag) {
        if (empty($image)) return url('/images/no_image.png');
    }

    $errorImage = $isAvatar ? url('/images/no_avatar.png') : url('/images/no_image.png');
    
    return !empty($image) ? Storage::url($image) : $errorImage;
}   