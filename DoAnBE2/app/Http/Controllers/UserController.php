<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userss; // Đảm bảo rằng bạn đang sử dụng model Userss
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Import Storage facade để xử lý tệp
use Illuminate\Validation\ValidationException; // Import ValidationException để bắt lỗi xác thực
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import ModelNotFoundException để bắt lỗi không tìm thấy bản ghi
use Carbon\Carbon; // Import Carbon để làm việc với timestamp
use Illuminate\Validation\Rule; // Import Rule để sử dụng các quy tắc xác thực nâng cao, ví dụ unique

class UserController extends Controller
{
    /**
     * Hiển thị form tạo người dùng mới.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create'); // Trả về view thêm người dùng
    }

    /**
     * Hiển thị danh sách tất cả người dùng.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = Userss::all(); // Lấy tất cả người dùng từ bảng Userss
        return view('admin.users.index', compact('users')); // Truyền biến $users vào view
    }

    /**
     * Xử lý việc tạo người dùng mới và lưu vào cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào từ request
        $validated = $request->validate([
            'username' => [
                'required',
                'min:3',
                'max:50',
                'regex:/^(?!\s)[\p{L}0-9]+(?: [\p{L}0-9]+)*(?!\s)$/u' // Không bắt đầu/kết thúc bằng khoảng trắng, không có nhiều khoảng trắng liên tiếp
            ],
            'password' => [
                'required',
                'min:6',
                'max:20',
                // Bắt buộc có chữ hoa, chữ thường, số và ký tự đặc biệt
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+])[A-Za-z\d!@#$%^&*()\-_=+]+$/',
            ],
            'email' => [
                'required',
                'min:12',
                'max:50',
                // Regex cho email hợp lệ, không có dấu chấm liên tiếp, không bắt đầu/kết thúc bằng dấu chấm
                'regex:/^(?!.*\.\.)(?!^\.)(?!\.$)[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
                'unique:userss,email', // Đảm bảo email là duy nhất trong bảng 'userss'
            ],
            'password_confirmation' => [
                'required', // Bắt buộc
                'same:password', // Phải giống với trường 'password'
            ],
            'status' => 'required|in:active,inactive', // Trạng thái phải là 'active' hoặc 'inactive'
            'role' => 'required|in:admin,user', // Vai trò phải là 'admin' hoặc 'user'
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048', // Avatar là tùy chọn, phải là ảnh jpg/png, tối đa 2MB
        ]);

        // Tạo một bản ghi người dùng mới
        $user = new Userss();
        $user->username = $request->username;
        $user->password = bcrypt($request->password); // Mã hóa mật khẩu trước khi lưu
        $user->email = $request->email;
        $user->status = $request->status;
        $user->role = $request->role;

        // Xử lý lưu avatar nếu có tệp được tải lên
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public'); // Lưu tệp vào thư mục 'avatars' trong storage/app/public
            $user->avatar = $avatarPath;
        }

        // Lưu bản ghi người dùng vào cơ sở dữ liệu
        $user->save();

        // Chuyển hướng về trang danh sách người dùng với thông báo thành công
        return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản thành công!');
    }

    /**
     * Xóa một người dùng khỏi cơ sở dữ liệu.
     * Bao gồm kiểm tra khóa lạc quan để ngăn chặn xóa bản ghi đã được sửa đổi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $user_id)
    {
        try {
            // Tìm người dùng theo ID, nếu không tìm thấy sẽ ném ModelNotFoundException
            $user = Userss::findOrFail($user_id);

            // BẮT ĐẦU PHẦN KIỂM TRA KHÓA LẠC QUAN KHI XÓA
            // Lấy timestamp updated_at từ tham số truy vấn URL (khi người dùng nhấp "Xóa" từ danh sách)
            $updatedAtFromList = $request->query('updated_at');

            // Chỉ kiểm tra nếu updated_at được truyền từ request
            if ($updatedAtFromList) {
                $formUpdatedAt = Carbon::parse($updatedAtFromList); // Chuyển đổi chuỗi timestamp từ form sang đối tượng Carbon
                $dbUpdatedAt = Carbon::parse($user->updated_at); // Chuyển đổi timestamp từ DB sang đối tượng Carbon

                // So sánh timestamp từ form và từ DB. Nếu khác nhau, có nghĩa là bản ghi đã được cập nhật bởi người khác.
                if ($formUpdatedAt->ne($dbUpdatedAt)) {
                    return redirect()->route('admin.users.index')
                        ->with('error', 'Người dùng đã được cập nhật bởi người dùng khác hoặc đã bị xóa. Vui lòng tải lại trang để xem dữ liệu mới nhất.');
                }
            }
            // KẾT THÚC PHẦN KIỂM TRA KHÓA LẠC QUAN KHI XÓA

            // Xóa tệp avatar liên quan khỏi storage nếu nó tồn tại
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Xóa bản ghi người dùng khỏi cơ sở dữ liệu
            $user->delete();

            // Chuyển hướng trở lại danh sách người dùng với thông báo thành công
            return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công!');
        } catch (ModelNotFoundException $e) {
            // Xử lý trường hợp không tìm thấy người dùng (có thể đã bị xóa bởi người khác)
            return redirect()->route('admin.users.index')
                ->with('info', 'Người dùng này đã được xóa hoặc không còn tồn tại trên hệ thống.');
        } catch (\Exception $e) {
            // Ghi log lỗi không mong muốn và chuyển hướng với thông báo lỗi
            \Log::error("Lỗi xóa người dùng: " . $e->getMessage() . " - File: " . $e->getFile() . " - Line: " . $e->getLine());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không mong muốn khi xóa người dùng. Vui lòng thử lại.');
        }
    }

    /**
     * Hiển thị form chỉnh sửa thông tin người dùng.
     *
     * @param  int  $user_id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($user_id)
    {
        try {
            // Tìm người dùng theo ID, nếu không tìm thấy sẽ ném ModelNotFoundException
            $user = Userss::findOrFail($user_id);
            return view('admin.users.edit', compact('user')); // Trả về view chỉnh sửa người dùng
        } catch (ModelNotFoundException $e) {
            // Xử lý trường hợp không tìm thấy người dùng
            return redirect()->route('admin.users.index')
                ->with('info', 'Người dùng bạn muốn chỉnh sửa không tồn tại hoặc đã bị xóa.');
        }
    }

    /**
     * Cập nhật thông tin người dùng trong cơ sở dữ liệu.
     * Bao gồm kiểm tra khóa lạc quan để ngăn chặn cập nhật bản ghi đã được sửa đổi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $user_id)
    {
        try {
            // Tìm người dùng theo ID để kiểm tra sửa đổi đồng thời
            $user = Userss::findOrFail($user_id);

            // Lấy timestamp updated_at gốc từ trường ẩn trong form
            $originalUpdatedAt = $request->input('original_updated_at');

            // BẮT ĐẦU PHẦN KIỂM TRA KHÓA LẠC QUAN KHI CẬP NHẬT
            // So sánh timestamp updated_at hiện tại trong DB với timestamp từ form
            // Ép kiểu sang string để so sánh chính xác các đối tượng Carbon
            if ($user->updated_at && (string)$user->updated_at !== (string)$originalUpdatedAt) {
                return redirect()->back()
                    ->withInput() // Giữ lại các input cũ để người dùng không phải nhập lại
                    ->with('error', 'Dữ liệu người dùng đã được thay đổi bởi người khác. Vui lòng kiểm tra lại thông tin và thử cập nhật.');
            }
            // KẾT THÚC PHẦN KIỂM TRA KHÓA LẠC QUAN KHI CẬP NHẬT

            // Xác thực dữ liệu đầu vào
            $validated = $request->validate([
                'username' => [
                    'required',
                    'min:3',
                    'max:50',
                    'regex:/^(?!\s)[\p{L}0-9]+(?: [\p{L}0-9]+)*(?!\s)$/u'
                ],
                'email' => [
                    'required',
                    'min:12',
                    'max:50',
                    'regex:/^(?!.*\.\.)(?!^\.)(?!\.$)[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
                    // Kiểm tra email duy nhất, bỏ qua email của chính người dùng đang được cập nhật
                    Rule::unique('userss', 'email')->ignore($user->user_id, 'user_id'),
                ],
                'password' => [
                    'nullable', // Mật khẩu là tùy chọn khi cập nhật
                    'min:6',
                    'max:20',
                    // Regex cho mật khẩu phức tạp
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+])[A-Za-z\d!@#$%^&*()\-_=+]+$/',
                    'confirmed', // Yêu cầu trường password_confirmation
                ],
                'status' => 'required|in:active,inactive',
                'role' => 'required|in:admin,user',
                'avatar' => 'nullable|image|mimes:jpg,png|max:2048',
            ]);

            // Cập nhật thông tin người dùng
            $user->username = $request->username;
            $user->email = $request->email;

            // Cập nhật mật khẩu nếu người dùng có nhập mật khẩu mới
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            // Cập nhật ảnh đại diện nếu có tệp mới được tải lên
            if ($request->hasFile('avatar')) {
                // Xóa avatar cũ khỏi storage nếu nó tồn tại
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            $user->status = $request->status;
            $user->role = $request->role;

            $user->save(); // Lưu thông tin cập nhật vào cơ sở dữ liệu (thao tác này sẽ tự động cập nhật `updated_at`)

            return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
        } catch (ModelNotFoundException $e) {
            // Xử lý trường hợp không tìm thấy người dùng
            return redirect()->route('admin.users.index')
                ->with('info', 'Người dùng bạn muốn cập nhật không tồn tại hoặc đã bị xóa.');
        } catch (ValidationException $e) {
            // Xử lý lỗi xác thực và chuyển hướng về form với các lỗi
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Ghi log lỗi không mong muốn và chuyển hướng với thông báo lỗi
            \Log::error("Lỗi cập nhật người dùng: " . $e->getMessage() . " - File: " . $e->getFile() . " - Line: " . $e->getLine());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không mong muốn khi cập nhật người dùng. Vui lòng thử lại.');
        }
    }

    /**
     * Tìm kiếm người dùng theo tên hoặc email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm người dùng theo tên hoặc email (không phân biệt chữ hoa/thường)
        $users = Userss::where('username', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->get();

        return view('admin.users.index', compact('users'));
    }
}
