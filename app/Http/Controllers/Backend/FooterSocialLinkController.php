<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FooterSocialLinkDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterSocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FooterSocialLinkController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(FooterSocialLinkDataTable $dataTable)
  {
    return $dataTable->render('admin.footer.footer-socials.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.footer.footer-socials.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'icon' => ['required', 'max:200'],
      'name' => ['required', 'max:200'],
      'url' => ['required', 'url'],
      'status' => ['required'],
    ]);

    $footerSocial = new FooterSocialLink();

    $footerSocial->icon = $request->icon;
    $footerSocial->name = $request->name;
    $footerSocial->url = $request->url;
    $footerSocial->status = $request->status;

    $footerSocial->save();

    Cache::forget('footer_social_link');

    toastr('Created Successfully!');

    return redirect()->route('admin.footer-social-links.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $footerSocial = FooterSocialLink::findOrFail($id);
    return view('admin.footer.footer-socials.edit', compact('footerSocial'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $request->validate([
      'icon' => ['required', 'max:200'],
      'name' => ['required', 'max:200'],
      'url' => ['required', 'url'],
      'status' => ['required'],
    ]);

    $footerSocial = FooterSocialLink::findOrFail($id);

    $footerSocial->icon = $request->icon;
    $footerSocial->name = $request->name;
    $footerSocial->url = $request->url;
    $footerSocial->status = $request->status;

    $footerSocial->save();

    Cache::forget('footer_social_link');

    toastr('Updated Successfully!');

    return redirect()->route('admin.footer-social-links.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $footerSocial = FooterSocialLink::findOrFail($id);

    $footerSocial->delete();

    Cache::forget('footer_social_link');

    return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
  }

  public function changeStatus(Request $request)
  {
    $footerSocial = FooterSocialLink::findOrFail($request->id);

    $footerSocial->status = $request->status == 'true' ? 1 : 0;

    $footerSocial->save();

    Cache::forget('footer_social_link');

    return response(['message' => 'Status has been updated!']);
  }
}
