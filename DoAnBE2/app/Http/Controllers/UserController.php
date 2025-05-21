<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userss;  // Đảm bảo rằng bạn đang sử dụng model Userss
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserController extends Controller
{
    // Hiển thị form tạo người dùng
    public function create()
    {
        return view('admin.users.create'); // Trả về view thêm người dùng
    }

    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = Userss::all(); // Lấy tất cả người dùng từ bảng Userss
        return view('admin.users.index', compact('users')); // Truyền biến $users vào view
    }

    // Xử lý việc tạo người dùng
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'username' => 'required|max:255|unique:users,username',
            'password' => 'required|confirmed|min:8',
            'email' => 'required|email|unique:users,email',
            'status' => 'required',
            'role' => 'required',
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        // Tạo người dùng mới
        $user = new Userss();  // Đảm bảo sử dụng đúng model
        $user->username = $request->username;
        $user->password = bcrypt($request->password);  // Mã hóa mật khẩu
        $user->email = $request->email;
        $user->status = $request->status;
        $user->role = $request->role;

        // Lưu avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Lưu dữ liệu vào cơ sở dữ liệu
        $user->save();

        // Chuyển hướng với thông báo thành công
        return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản thành công!');
    }
    public function destroy($user_id)
    {
        // Tìm người dùng theo id
        $user = Userss::findOrFail($user_id);

        // Xóa người dùng
        $user->delete();

        // Chuyển hướng trở lại danh sách với thông báo thành công
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công!');
    }
    public function edit($user_id)
    {
        $user = Userss::find($user_id);  // Tìm người dùng theo id
        return view('admin.users.edit', compact('user')); // Trả về view chỉnh sửa người dùng
    }

    public function update(Request $request, $user_id)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user_id . ',user_id', // Kiểm tra email trùng với chính nó
            'password' => 'nullable|confirmed|min:8',
            'status' => 'required',
            'role' => 'required',
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $user = Userss::find($user_id);  // Tìm người dùng theo id
        $user->username = $request->username;
        $user->email = $request->email;

        // Cập nhật mật khẩu nếu người dùng thay đổi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Cập nhật ảnh đại diện nếu có
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->status = $request->status;
        $user->role = $request->role;


        $user->save();  // Lưu thông tin cập nhật vào cơ sở dữ liệu

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm người dùng theo tên hoặc email
        $users = Userss::where('username', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->get();

        return view('admin.users.index', compact('users'));
    }
}
