<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\comment;
use App\Models\Blog;
use App\Models\view;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    // FUNCTION TO GET ALL USERS
    public function getUsers()
    {
        $adminRole = Role::where('role', Role::ADMIN)->first();
        $adminUser = $adminRole->user;
        $users = User::all()->except($adminUser->id);
        return response()->json(['AdminUser' => $adminUser, 'users' => $users]);
    }
    // FUNCTION TO GET SPECIFIC USER 
    public function GetUser($id)
    {
        $user = User::find($id);
        return response($user);
    }
    // FUNCTION TO UPDATE USER
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
            // delete image from storage using helper function
            DeleteImage($user->Image);
            // Store image in storage using helper function
            $targetFileupload = StoreImage($file);
            $data['Image'] = $targetFileupload;
        }
        if ($user->update($data)) {
            return response()->json(['message' => __('message.USER_UPDATED')], RESPONSE::HTTP_OK);
        }
    }
    // FUNCTION TO DELETE USER
    public function DeleteUser($id)
    {
        $user = User::find($id);
        Role::where('user_id', $id)->delete();

        if ($user) {
            // delete image from storage using helper function
            DeleteImage($user->Image);
            $user->delete();

            return response()->json(['message' =>  __('message.USER_DELETED')], RESPONSE::HTTP_OK);
        }
    }
    // FUNCTION TO GET USER BASED ON SEARCH BAR
    public function GetSearchedUser($keyword)
    {
        $users = User::where('name', 'like', '%' . $keyword . '%')->get();

        return response()->json(['users' => $users]);
    }
    // FUNCTION TO GET TOTAL COUNT OF USERS,VIEWS,COMMENT AND BLOGS
    public function getTotalCounts()
    {
        $totalUsers = User::count();
        $totalViews = View::sum('view');
        $totalComments = Comment::count();
        $totalBlogs = Blog::count();

        return response()->json([
            'totalUsers' => $totalUsers,
            'totalViews' => $totalViews,
            'totalComments' => $totalComments,
            'totalBlogs' => $totalBlogs,
        ]);
    }
}
