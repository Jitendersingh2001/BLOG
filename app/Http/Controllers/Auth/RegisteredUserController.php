<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {


        if ($request->hasFile('Image')) {
            $file = $request->file('Image');
            $targetDir = storage_path('app/public/upload');
            $targetFileName = time() . '_' . $file->getClientOriginalName();
            $targetFileupload = "/storage/upload/" . $targetFileName;
            $file->move($targetDir, $targetFileName);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_no' => $request->phone_no,
            'Image' => $targetFileupload,
        ]);
        event(new Registered($user));

        // Auth::login($user);

        return response()->json(["url" => "/login"]);
    }
}
