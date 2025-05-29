<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentsController extends Controller
{
    // Hiển thị danh sách bình luận
    public function index()
    {
        $comments = Comment::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    // Form thêm bình luận
    public function create()
    {
        $users = User::all();
        $news = News::all();
        return view('admin.comments.create', compact('users', 'news'));
    }

    // Lưu bình luận (AJAX)
    public function store(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập để bình luận.'], 403);
        }

        $request->validate([
            'noidung' => ['required', 'string', 'max:1000', function ($attribute, $value, $fail) {
                if (trim($value) !== $value || preg_match('/^\x{3000}|\x{3000}$/u', $value)) {
                    $fail('Nội dung không được có khoảng trắng ở đầu hoặc cuối.');
                }
                if ($value !== preg_replace('/[\s\x{3000}]+/u', ' ', $value)) {
                    $fail('Nội dung chứa khoảng trắng không hợp lệ.');
                }
                if (strip_tags($value) !== $value) {
                    $fail('Nội dung không được chứa mã HTML.');
                }
                $cleaned = preg_replace('/[\s\x{3000}]+/u', '', $value);
                if (strlen($cleaned) > 1 && count(array_unique(mb_str_split($cleaned))) === 1) {
                    $fail('Nội dung không được chứa ký tự lặp lại vô nghĩa.');
                }
            }]
        ]);

        // Kiểm tra bài viết tồn tại
        if (!News::find($id)) {
            return response()->json(['message' => 'Tin tức không tồn tại.'], 404);
        }

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'news_id' => $id,
            'noidung' => $request->noidung,
        ]);

        $comment->load('user');

        return response()->json([
            'username' => $comment->user->username ?? 'Ẩn danh',
            'noidung' => $comment->noidung,
            'time' => $comment->created_at->diffForHumans(),
        ]);
    }

    // Form chỉnh sửa
    public function edit($id)
{
    try {
        $comment = Comment::findOrFail($id);
        $users = User::all();
        $news = News::all();
        return view('admin.comments.edit', compact('comment', 'users', 'news'));
    } catch (ModelNotFoundException $e) {
        return redirect()->route('admin.comments.index')->with('error', 'Bình luận không tồn tại hoặc đã bị xóa.');
    }
}


    // Cập nhật bình luận
    public function update(Request $request, $id)
    {
        $request->validate([
            'noidung' => ['required', 'string', 'max:1000', function ($attribute, $value, $fail) {
                if (trim($value) !== $value || preg_match('/^\x{3000}|\x{3000}$/u', $value)) {
                    $fail('Nội dung không được có khoảng trắng ở đầu hoặc cuối.');
                }
                if ($value !== preg_replace('/[\s\x{3000}]+/u', ' ', $value)) {
                    $fail('Nội dung chứa khoảng trắng không hợp lệ.');
                }
                if (strip_tags($value) !== $value) {
                    $fail('Nội dung không được chứa mã HTML.');
                }
                $cleaned = preg_replace('/[\s\x{3000}]+/u', '', $value);
                if (strlen($cleaned) > 1 && count(array_unique(mb_str_split($cleaned))) === 1) {
                    $fail('Nội dung không được chứa ký tự lặp lại vô nghĩa.');
                }
            }]
        ]);

       try {
        $comment = Comment::findOrFail($id);

        $request->validate([
            'noidung' => 'required|string|max:1000',
        ]);

        $comment->noidung = $request->noidung;
        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã được cập nhật.');
    } catch (ModelNotFoundException $e) {
        return redirect()->route('admin.comments.index')->with('error', 'Bình luận không tồn tại hoặc đã bị xóa.');
    }
}

    // Xóa bình luận
public function destroy($id)
{
    try {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Bình luận đã được xóa.');
    } catch (ModelNotFoundException $e) {
        return redirect()->back()->with('error', 'Bình luận này không tồn tại hoặc đã bị xóa.');
    }
}


    // Tìm kiếm bình luận
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
