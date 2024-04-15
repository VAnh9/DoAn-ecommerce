<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TermAndCondition;
use Illuminate\Http\Request;

class TermAndConditionController extends Controller
{
  public function index()
  {
    $content = TermAndCondition::first();
    return view('admin.term-and-condition-page.index', compact('content'));
  }

  public function update(Request $request)
  {
    $request->validate([
      'content' => ['required'],
    ]);

    TermAndCondition::updateOrCreate(
      ['id' => 1],
      ['content' => $request->content]
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }
}
