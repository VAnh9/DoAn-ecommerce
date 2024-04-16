<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
  // show blog details
  public function index(string $slug)
  {
    $blog = Blog::with(['user', 'blogComments'])->where('slug', $slug)->where('status', 1)->firstOrFail();
    $relatedBlogs = Blog::with('blogCategory')->where('blog_category_id', $blog->blog_category_id)->where('status', 1)->where('slug', '!=', $slug)->orderBy('id', 'DESC')->take(5)->get();
    $comments = $blog->blogComments()->paginate(5);
    $moreBlogs = Blog::with('blogComments')->where('status', 1)->where('slug', '!=', $slug)->orderBy('id', 'DESC')->take(5)->get();
    $blogCategories = BlogCategory::where('status', 1)->get();
    return view('frontend.pages.blog-detail', compact('blog', 'relatedBlogs', 'comments', 'moreBlogs', 'blogCategories'));
  }

  public function comment(Request $request)
  {
    $request->validate([
      'comment' => ['required', 'max:1000']
    ]);

    $blogComment = new BlogComment();

    $blogComment->user_id = Auth::user()->id;
    $blogComment->blog_id = $request->blog_id;
    $blogComment->comment = $request->comment;

    $blogComment->save();

    toastr('Comment added successfully!');

    return redirect()->back();
  }

  public function getAllBlogs(Request $request)
  {
    if($request->has('search')) {
      $blogs = Blog::where('title', 'like', '%'.$request->search.'%')->where('status', 1)->orderBy('id', 'DESC')->paginate(8);
    }
    else if($request->has('category')) {
      $category = BlogCategory::where('slug', $request->category)->where('status', 1)->firstOrFail();
      $blogs = Blog::where('blog_category_id', $category->id)->where('status', 1)->orderBy('id', 'DESC')->paginate(8);
    }
    else {
      $blogs = Blog::where('status', 1)->orderBy('id', 'DESC')->paginate(8);
    }

    return view('frontend.pages.blog', compact('blogs'));
  }
}
