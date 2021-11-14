<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\News;
// 以下を追記
use App\History;

use Carbon\Carbon;

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
        $this->validate($request, News::$rules);
        $news = News::find($request->id);
        $news_form = $request->all();
        if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $news_form['image_path'] = basename($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }

        unset($news_form['_token']);
        unset($news_form['image']);
        unset($news_form['remove']);
        $news->fill($news_form)->save();

        // 以下を追記
        $history = new History();
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/news/');
    }
    //
}