<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\User;

class CommentsController extends Controller
{
    // Hiển thị danh sách bình luận, phân trang 10 bản ghi/trang
    public function index()
    {
        $comments = Comment::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    // Hiển thị form chỉnh sửa bình luận
public function edit($id)
{
    $comment = Comment::findOrFail($id);
    $users = User::all();         // Lấy tất cả người dùng
    $news = News::all();          // Lấy tất cả tin tức

    return view('admin.comments.edit', compact('comment', 'users', 'news'));
}

    // Hiển thị form thêm bình luận mới
 // Form thêm bình luận
    public function create()
    {
    

        $users = User::all();
        $news = News::all();
        return view('admin.comments.create', compact('users', 'news'));
    }
public function store(Request $request, $id)
{
    $request->validate([
        'noidung' => 'required|string|max:1000',
    ]);

    Comment::create([
        'user_id' => auth()->id(),  // lấy id user đang đăng nhập
        'news_id' => $id,           // lấy id từ URL
        'noidung' => $request->noidung,
    ]);

    return redirect()->back()->with('success', 'Bình luận đã được gửi!');
}


    // Cập nhật bình luận
    public function update(Request $request, $id)
    {
        $request->validate([
            'noidung' => 'required|string|max:1000',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->noidung = $request->noidung;
        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã được cập nhật.');
    }

    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Bình luận đã được xóa.');
    }

    // Tìm kiếm bình luận theo nội dung
public function search(Request $request)
{
    $query = $request->input('query');

    $comments = Comment::with(['user', 'news'])
        ->where(function ($q) use ($query) {
            $q->where('noidung', 'like', '%' . $query . '%')
              ->orWhereHas('user', function ($q2) use ($query) {
                  $q2->where('username', 'like', '%' . $query . '%');
              })
              ->orWhereHas('news', function ($q3) use ($query) {
                  $q3->where('tieude', 'like', '%' . $query . '%');
              });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('admin.comments.index', compact('comments'))->with('query', $query);
}
}