<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BlogCommentDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
  public function index(BlogCommentDataTable $blogCommentDataTable)
  {
    return $blogCommentDataTable->render('admin.blog.comment.index');
  }

  public function destroy(string $id)
  {
    $comment = BlogComment::findOrFail($id);

    $comment->delete();

    return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
  }

  public function changeStatus(Request $request)
  {
    $blog = BlogComment::findOrFail($request->id);

    $blog->status = $request->isChecked == 'true' ? 1 : 0;

    $blog->save();

    return response(['message' => 'Status has been updated!']);
  }
}
