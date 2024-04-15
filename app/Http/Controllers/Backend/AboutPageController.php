<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
  public function index()
  {
    $content = AboutPage::first();
    return view('admin.about-page.index', compact('content'));
  }

  public function update(Request $request)
  {
    $request->validate([
      'content' => ['required'],
    ]);

    AboutPage::updateOrCreate(
      ['id' => 1],
      ['content' => $request->content]
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }
}
