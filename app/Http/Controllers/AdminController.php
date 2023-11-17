<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // public function DeleteImage($user)
    // {
    //     $imagePath = $user->Image;
    //     // dd($imagePath);
    //     $imagePath = str_replace('/storage', '/', $imagePath);
    //     if ($imagePath && Storage::disk('public')->exists($imagePath)) {
    //         Storage::disk('public')->delete($imagePath);
    //     }
    // }
    // //function to store image in storage
    // public function StoreImage($request): string
    // {
    //     $file = $request->file('UserImage');
    //     $targetDir = storage_path('app/public/upload');
    //     $targetFileName = time() . '_' . $file->getClientOriginalName();
    //     $targetFileupload = "/storage/upload/" . $targetFileName;
    //     $file->move($targetDir, $targetFileName);
    //     return $targetFileupload;
    // }
    public function getUsers()
    {
        $adminRole = Role::where('role', Role::ADMIN)->first();
        $adminUser = $adminRole->user;
        $users = User::all()->except($adminUser->id);
        return response()->json(['AdminUser' => $adminUser, 'users' => $users]);
    }
    public function GetUser($id)
    {
        $user = User::find($id);
        return response($user);
    }
    public function UpdateUser(request $request, $id)
    {
        // dd($request);
        $user = User::find($id);
        $data = [
            'name' => $request->UserName,
            'email' => $request->UserEmail,
            'phone_no' => $request->UserphoneNo,
            'status' => $request->UserStatus,
        ];

        if ($request->hasFile('UserImage')) {
            $file = $request->file('UserImage');
            DeleteImage($user->Image);
            $targetFileupload = StoreImage($file);
            $data['Image'] = $targetFileupload;
        }
        if ($user->update($data)) {
            return response()->json(['message' =>  __('message.USER_UPDATED')]);
        }
    }
    public function DeleteUser($id)
    {
        $user = User::find($id);
        Role::where('user_id', $id)->delete();

        if ($user) {
            // delete image from storage
            DeleteImage($user->Image);
            $user->delete();

            return response()->json(['message' =>  __('message.USER_DELETED')]);
        }
    }
    public function GetSearchedUser($keyword)
    {
        $users = User::where('name', 'like', '%' . $keyword . '%')->get();

        return response()->json(['users' => $users]);
    }
}
