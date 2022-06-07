<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{ 

    public function index(User $user)
    { 
        // $userInfo = User::findOrFail($user);
         
        // return view('home',[
        //     'userInfo' => $userInfo
        // ]);


        return view('profiles.index', compact('user'));
    }


    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);


        if(request('image'))
        { 
            $imagePath = request('image')->store('uploads','public');
            $imageArray = ['image'=>$imagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect("/profile/{$user->id}");
    }
}  