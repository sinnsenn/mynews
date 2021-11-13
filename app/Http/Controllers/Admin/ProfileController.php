<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;

class ProfileController extends Controller
{ 
    public function add()
    {
        return view('admin.profile.create');
    }

   
    public function create(Request $request)
    {

      // Varidationを行う
      $this->validate($request, Profile::$rules);

      $profile = new Profile();
      $form = $request->all();

      unset($form['_token']);
     
      $profile->fill($form);
      $profile->save();

      return redirect('admin/profile/create');
    }

    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        return redirect('admin/profile/edit');
    }
    //
}