<?php

use Illuminate\Support\Facades\Storage;
// Function to delete image
function DeleteImage($imagePath)
{
    // dd($imagePath);
    $imagePath = str_replace('/storage', '/', $imagePath);
    if ($imagePath && Storage::disk('public')->exists($imagePath)) {
        Storage::disk('public')->delete($imagePath);
    }
}
//function to store image in storage
function StoreImage($file): string
{
    $targetDir = storage_path('app/public/uploads');
    $targetFileName = time() . '_' . $file->getClientOriginalName();
    $targetFileupload = "/storage/uploads/" . $targetFileName;
    $file->move($targetDir, $targetFileName);
    return $targetFileupload;
}
