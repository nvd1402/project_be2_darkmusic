<?php

namespace App\Http\Controllers;
use App\Models\News;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Userss;  // Đảm bảo rằng bạn đang sử dụng model Userss
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;


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
        $users = Userss::orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
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
// Hàm xóa user với bắt lỗi nếu user không tồn tại
    public function destroy(Request $request, $user_id)
    {
        try {
            $user = Userss::findOrFail($user_id);

            // Nếu bạn muốn kiểm tra khóa lạc quan khi xóa thì thêm:
            $clientUpdatedAt = $request->input('updated_at');
            if (!$clientUpdatedAt || $clientUpdatedAt != $user->updated_at->toDateTimeString()) {
                return redirect()->route('admin.users.index')
                    ->withErrors(['conflict' => 'Người dùng đã được thay đổi hoặc xóa bởi người khác. Vui lòng tải lại trang.']);
            }

            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.users.index')->withErrors(['delete_error' => 'Người dùng không tồn tại hoặc đã bị xóa.']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa người dùng: ' . $e->getMessage());
            return redirect()->route('admin.users.index')->withErrors(['delete_error' => 'Có lỗi xảy ra khi xóa. Vui lòng thử lại.']);
        }
    }


    public function edit($user_id)
    {
        $user = Userss::find($user_id);  // Tìm người dùng theo id
        return view('admin.users.edit', compact('user')); // Trả về view chỉnh sửa người dùng
    }

// Hàm cập nhật user với khóa lạc quan
    public function update(Request $request, $user_id)
    {
        try {
            $user = Userss::findOrFail($user_id);

            // Validate dữ liệu
            $validated = $request->validate([
                'username' => [
                    'required',
                    'min:3',
                    'max:50',
                    'regex:/^(?!\s)[\p{L}0-9]+(?: [\p{L}0-9]+)*(?!\s)$/u',
                ],
                'email' => [
                    'required',
                    'email',
                    'min:12',
                    'max:50',
                    'regex:/^(?!.*\.\.)(?!^\.)(?!\.$)[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
                    \Illuminate\Validation\Rule::unique('users', 'email')->ignore($user_id, 'user_id'),
                ],
                'password' => [
                    'nullable', // không bắt buộc đổi mật khẩu
                    'min:6',
                    'max:20',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+])[A-Za-z\d!@#$%^&*()\-_=+]+$/',
                    'confirmed', // phải có password_confirmation giống password
                ],
                'status' => 'required|in:active,inactive',
                'role' => 'required|in:User,Admin,Vip',
                'avatar' => 'nullable|image|mimes:jpg,png|max:2048',
                'original_updated_at' => 'required|date',
            ]);

            // Kiểm tra khóa lạc quan
            if ($request->input('original_updated_at') != $user->updated_at->toDateTimeString()) {
                return redirect()->back()
                    ->withErrors(['conflict' => 'Dữ liệu đã được thay đổi bởi người khác. Vui lòng tải lại trang.'])
                    ->withInput();
            }

            // Cập nhật dữ liệu
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
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.users.index')->withErrors(['not_found' => 'Người dùng không tồn tại.']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật người dùng: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại.'])->withInput();
        }
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

