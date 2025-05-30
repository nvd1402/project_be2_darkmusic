<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Userss;  // Đảm bảo rằng bạn đang sử dụng model Userss
use Illuminate\Support\Facades\Hash;

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
            'username' => [
                'required',
                'min:3',
                'max:50',
                'regex:/^(?!\s)[\p{L}0-9]+(?: [\p{L}0-9]+)*(?!\s)$/u'
            ],
            'password' => [
                'required',
                'min:6',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+])[A-Za-z\d!@#$%^&*()\-_=+]+$/', // Bắt buộc có chữ hoa, chữ thường, số và ký tự đặc biệt
            ],

            'email' => [
                'required',
                'min:12',
                'max:50',
                'regex:/^(?!.*\.\.)(?!^\.)(?!\.$)[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
                'unique:users,email',
            ],
            'password_confirmation' => [
                'required',                       // Bắt buộc
                'same:password',                   // Phải giống với trường 'password'
            ],
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
        $user = Userss::findOrFail($user_id);

        // Validate dữ liệu, thêm rule cho original_updated_at
        $validated = $request->validate([
            'username' => [
                'required',
                'min:3',
                'max:50',
                'regex:/^(?!\s)[\p{L}0-9]+(?: [\p{L}0-9]+)*(?!\s)$/u',
            ],
            'email' => [
                'required',
                'min:12',
                'max:50',
                'regex:/^(?!.*\.\.)(?!^\.)(?!\.$)[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
                Rule::unique('users', 'email')->ignore($user_id, 'user_id'),
            ],
            'password' => [
                'nullable', // Cho phép không thay đổi mật khẩu
                'min:6',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+])[A-Za-z\d!@#$%^&*()\-_=+]+$/',
                'confirmed',
            ],
            'status' => 'required|in:active,inactive',
            'role' => 'required|in:User,Admin,Vip',
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048',
            'original_updated_at' => 'required|date',
        ]);

        // So sánh original_updated_at với updated_at hiện tại trong DB
        if ($request->input('original_updated_at') != $user->updated_at->toDateTimeString()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Dữ liệu đã bị thay đổi bởi người dùng khác. Vui lòng tải lại và thử lại.']);
        }

        // Cập nhật thông tin
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->status = $request->status;
        $user->role = $request->role;

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }
    //Hàm tìm kiếm user
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

