<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log; // Thêm để log lỗi

class CategoryController extends Controller
{
    // Danh sách nhóm thể loại hợp lệ
    protected $nhoms = [
        'Nhạc Rock',
        'Nhạc Remix',
        'Nhạc Nổi Bật',
        'Nhạc Mới',
        'Nhạc Cũ',
    ];

    // Getter cho danh sách nhóm để có thể dùng nếu cần
    public function getNhoms()
    {
        return $this->nhoms;
    }

    // Hiển thị danh sách thể loại
    public function index()
    {
        $categories = Category::orderByDesc('updated_at')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Tìm kiếm thể loại
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->route('admin.categories.index');
        }

        $categories = Category::where('tentheloai', 'like', "%{$query}%")
            ->orWhere('nhom', 'like', "%{$query}%")
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    // Form thêm thể loại
    public function create()
    {
        return view('admin.categories.create', [
            'nhoms' => $this->nhoms,
        ]);
    }

    /**
     * Chuẩn hóa và loại bỏ khoảng trắng full-width và các khoảng trắng thừa ở đầu/cuối.
     * Hàm này chỉ nên được gọi sau khi validation thành công và trước khi lưu vào DB.
     */
    protected function cleanInput($string)
    {
        // Loại bỏ khoảng trắng thường và full-width ở đầu và cuối
        return preg_replace('/^[\s　]+|[\s　]+$/u', '', $string);
    }

    /**
     * Lọc HTML không an toàn trong mô tả (loại bỏ thẻ script, iframe, v.v).
     * Hàm này chỉ nên được gọi sau khi validation thành công và trước khi lưu vào DB.
     */
    protected function sanitizeDescription($html)
    {
        // Sử dụng strip_tags để loại bỏ tất cả các thẻ HTML
        return strip_tags($html);
    }

    /**
     * Chuyển số full-width sang half-width.
     */
    protected function normalizeNumbers($string)
    {
        return preg_replace_callback('/[０-９]/u', function ($matches) {
            return chr(ord($matches[0]) - 0xFEE0);
        }, $string);
    }

    /**
     * Kiểm tra xem chuỗi có khoảng trắng ở đầu hoặc cuối hay không.
     * Bao gồm cả khoảng trắng truyền thống và khoảng trắng toàn chiều rộng Unicode.
     */
    private function hasLeadingOrTrailingWhitespace($string)
    {
        return preg_match('/^[\s\x{3000}]+|[\s\x{3000}]+$/u', $string);
    }

    /**
     * Kiểm tra xem chuỗi có chỉ gồm một ký tự lặp lại nhiều lần hay không.
     */
    private function isRepeatedCharacters($string)
    {
        $trimmed = preg_replace('/\s+/u', '', $string); // Loại bỏ tất cả khoảng trắng để kiểm tra chuỗi thuần túy
        // Kiểm tra xem chuỗi có nhiều hơn 1 ký tự và tất cả các ký tự đều giống nhau không
        return mb_strlen($trimmed) > 1 && count(array_unique(mb_str_split($trimmed))) === 1;
    }

    // Lưu thể loại mới
    public function store(Request $request)
    {
        // Chuẩn hóa số full-width trước khi validate
        $normalizedTentheloai = $this->normalizeNumbers($request->input('tentheloai'));
        $normalizedDescription = $this->normalizeNumbers($request->input('description'));

        $request->merge([
            'tentheloai' => $normalizedTentheloai,
            'description' => $normalizedDescription,
        ]);

        $request->validate([
            'tentheloai' => [
                'required',
                'string',
                'max:255',
                // Rule 1: Kiểm tra khoảng trắng ở đầu hoặc cuối
                function ($attribute, $value, $fail) {
                    if ($this->hasLeadingOrTrailingWhitespace($value)) {
                        $fail('Tên thể loại không được chứa khoảng trắng ở đầu hoặc cuối.');
                    }
                },
                // Rule 2: Kiểm tra khoảng trắng kép hoặc không hợp lệ ở giữa chuỗi
                function ($attribute, $value, $fail) {
                    $cleanedValue = preg_replace('/[\s\x{3000}]+/u', ' ', $value);
                    if ($cleanedValue !== $value) {
                        $fail('Tên thể loại không được chứa nhiều khoảng trắng liền kề hoặc các ký tự khoảng trắng không hợp lệ ở giữa.');
                    }
                },
                // Rule 3: Kiểm tra ký tự lặp lại
                function ($attribute, $value, $fail) {
                    if ($this->isRepeatedCharacters($value)) {
                        $fail('Tên thể loại không được nhập chuỗi chỉ gồm một ký tự lặp lại nhiều lần. Ví dụ: "aaaaa", "---".');
                    }
                },
            ],
            'nhom' => 'required|string|in:' . implode(',', $this->nhoms),
            'description' => [
                'required',
                'string',
                'max:1000',
                // Rule 1: Kiểm tra khoảng trắng ở đầu hoặc cuối
                function ($attribute, $value, $fail) {
                    if ($this->hasLeadingOrTrailingWhitespace($value)) {
                        $fail('Mô tả không được chứa khoảng trắng ở đầu hoặc cuối.');
                    }
                },
                // Rule 2: Kiểm tra khoảng trắng kép hoặc không hợp lệ ở giữa chuỗi
                function ($attribute, $value, $fail) {
                    $cleanedValue = preg_replace('/[\s\x{3000}]+/u', ' ', $value);
                    if ($cleanedValue !== $value) {
                        $fail('Mô tả không được chứa nhiều khoảng trắng liền kề hoặc các ký tự khoảng trắng không hợp lệ ở giữa.');
                    }
                },
                // Rule 3: Kiểm tra ký tự lặp lại
                function ($attribute, $value, $fail) {
                    if ($this->isRepeatedCharacters($value)) {
                        $fail('Mô tả không được nhập chuỗi chỉ gồm một ký tự lặp lại nhiều lần. Ví dụ: "bbbbb", "***".');
                    }
                },
                // Rule 4: Kiểm tra nội dung không chứa HTML
                function ($attribute, $value, $fail) {
                    if ($value !== strip_tags($value)) {
                        $fail('Mô tả không được chứa mã HTML. Vui lòng loại bỏ các thẻ HTML.');
                    }
                }
            ],
            'status' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'tentheloai.required' => 'Vui lòng nhập tên thể loại.',
            'tentheloai.string' => 'Tên thể loại phải là chuỗi ký tự.',
            'tentheloai.max' => 'Tên thể loại không được vượt quá :max ký tự.',

            'nhom.required' => 'Vui lòng chọn nhóm thể loại.',
            'nhom.string' => 'Nhóm thể loại phải là chuỗi ký tự.',
            'nhom.in' => 'Nhóm thể loại không hợp lệ. Vui lòng chọn một trong các nhóm: ' . implode(', ', $this->nhoms) . '.',

            'description.required' => 'Vui lòng nhập mô tả.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'description.max' => 'Mô tả không được vượt quá :max ký tự.',

            'status.required' => 'Vui lòng chọn trạng thái hoạt động cho thể loại.',
            'status.boolean' => 'Trạng thái không hợp lệ. Vui lòng chọn Hoạt động hoặc Không hoạt động.',

            'image.required' => 'Vui lòng chọn ảnh đại diện cho thể loại.',
            'image.image' => 'Tệp tải lên phải là một hình ảnh hợp lệ.',
            'image.mimes' => 'Hình ảnh phải có định dạng: JPEG, PNG, JPG, GIF.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ]);

        // Sau khi validation thành công, tiến hành làm sạch dữ liệu trước khi lưu vào DB
        $cleanedTentheloai = $this->cleanInput($request->input('tentheloai'));
        $sanitizedDescription = $this->sanitizeDescription($request->input('description'));

        // Kiểm tra tên thể loại đã tồn tại chưa (sử dụng dữ liệu đã làm sạch)
        if (Category::where('tentheloai', $cleanedTentheloai)->exists()) {
            return redirect()->back()->withErrors(['tentheloai' => 'Tên thể loại này đã tồn tại. Vui lòng làm mới trang để cập nhật dữ liệu mới nhất hoặc chọn tên khác.'])->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category', 'public');
        }

        Category::create([
            'tentheloai' => $cleanedTentheloai,
            'nhom' => $request->nhom,
            'description' => $sanitizedDescription,
            'status' => $request->boolean('status'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm thể loại thành công!');
    }

    // Form sửa thể loại
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.categories.index')->withErrors('Thể loại không tồn tại hoặc đã bị xóa. Vui lòng kiểm tra lại ID.');
        }

        return view('admin.categories.edit', [
            'category' => $category,
            'nhoms' => $this->nhoms,
        ]);
    }

    // Cập nhật thể loại
    public function update(Request $request, $id)
    {
        // Chuẩn hóa số full-width trước khi validate
        $normalizedTentheloai = $this->normalizeNumbers($request->input('tentheloai'));
        $normalizedDescription = $this->normalizeNumbers($request->input('description'));

        $request->merge([
            'tentheloai' => $normalizedTentheloai,
            'description' => $normalizedDescription,
        ]);

        $request->validate([
            'tentheloai' => [
                'required',
                'string',
                'max:255',
                // Rule 1: Kiểm tra khoảng trắng ở đầu hoặc cuối
                function ($attribute, $value, $fail) {
                    if ($this->hasLeadingOrTrailingWhitespace($value)) {
                        $fail('Tên thể loại không được chứa khoảng trắng ở đầu hoặc cuối.');
                    }
                },
                // Rule 2: Kiểm tra khoảng trắng kép hoặc không hợp lệ ở giữa chuỗi
                function ($attribute, $value, $fail) {
                    $cleanedValue = preg_replace('/[\s\x{3000}]+/u', ' ', $value);
                    if ($cleanedValue !== $value) {
                        $fail('Tên thể loại không được chứa nhiều khoảng trắng liền kề hoặc các ký tự khoảng trắng không hợp lệ ở giữa.');
                    }
                },
                // Rule 3: Kiểm tra ký tự lặp lại
                function ($attribute, $value, $fail) {
                    if ($this->isRepeatedCharacters($value)) {
                        $fail('Tên thể loại không được nhập chuỗi chỉ gồm một ký tự lặp lại nhiều lần. Ví dụ: "aaaaa", "---".');
                    }
                },
            ],
            'nhom' => 'required|string|in:' . implode(',', $this->nhoms),
            'description' => [
                'required',
                'string',
                'max:1000',
                // Rule 1: Kiểm tra khoảng trắng ở đầu hoặc cuối
                function ($attribute, $value, $fail) {
                    if ($this->hasLeadingOrTrailingWhitespace($value)) {
                        $fail('Mô tả không được chứa khoảng trắng ở đầu hoặc cuối.');
                    }
                },
                // Rule 2: Kiểm tra khoảng trắng kép hoặc không hợp lệ ở giữa chuỗi
                function ($attribute, $value, $fail) {
                    $cleanedValue = preg_replace('/[\s\x{3000}]+/u', ' ', $value);
                    if ($cleanedValue !== $value) {
                        $fail('Mô tả không được chứa nhiều khoảng trắng liền kề hoặc các ký tự khoảng trắng không hợp lệ ở giữa.');
                    }
                },
                // Rule 3: Kiểm tra ký tự lặp lại
                function ($attribute, $value, $fail) {
                    if ($this->isRepeatedCharacters($value)) {
                        $fail('Mô tả không được nhập chuỗi chỉ gồm một ký tự lặp lại nhiều lần. Ví dụ: "bbbbb", "***".');
                    }
                },
                // Rule 4: Kiểm tra nội dung không chứa HTML
                function ($attribute, $value, $fail) {
                    if ($value !== strip_tags($value)) {
                        $fail('Mô tả không được chứa mã HTML. Vui lòng loại bỏ các thẻ HTML.');
                    }
                }
            ],
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'updated_at' => 'required', // kiểm tra xung đột optimistic locking
        ], [
            'tentheloai.required' => 'Vui lòng nhập tên thể loại.',
            'tentheloai.string' => 'Tên thể loại phải là chuỗi ký tự.',
            'tentheloai.max' => 'Tên thể loại không được vượt quá :max ký tự.',

            'nhom.required' => 'Vui lòng chọn nhóm thể loại.',
            'nhom.string' => 'Nhóm thể loại phải là chuỗi ký tự.',
            'nhom.in' => 'Nhóm thể loại không hợp lệ. Vui lòng chọn một trong các nhóm: ' . implode(', ', $this->nhoms) . '.',

            'description.required' => 'Vui lòng nhập mô tả.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'description.max' => 'Mô tả không được vượt quá :max ký tự.',

            'status.required' => 'Vui lòng chọn trạng thái hoạt động cho thể loại.',
            'status.boolean' => 'Trạng thái không hợp lệ. Vui lòng chọn Hoạt động hoặc Không hoạt động.',

            'image.image' => 'File tải lên phải là một hình ảnh hợp lệ.',
            'image.mimes' => 'Hình ảnh phải có định dạng: JPEG, PNG, JPG, GIF.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',

            'updated_at.required' => 'Lỗi dữ liệu. Không tìm thấy thông tin thời gian cập nhật. Vui lòng tải lại trang.',
        ]);

        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.categories.index')->withErrors('Thể loại không tồn tại hoặc đã bị xóa.');
        }

        // So sánh updated_at để kiểm tra xung đột (optimistic locking)
        if ($request->updated_at != $category->updated_at->toDateTimeString()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['conflict' => 'Thể loại đã được chỉnh sửa bởi người dùng khác. Vui lòng tải lại trang để cập nhật dữ liệu mới nhất và thử lại.']);
        }

        // Sau khi validation thành công, tiến hành làm sạch dữ liệu trước khi lưu vào DB
        $cleanedTentheloai = $this->cleanInput($request->input('tentheloai'));
        $sanitizedDescription = $this->sanitizeDescription($request->input('description'));

        // Kiểm tra trùng tên thể loại với bản ghi khác (sử dụng dữ liệu đã làm sạch)
        if (Category::where('tentheloai', $cleanedTentheloai)
            ->where('id', '!=', $id)
            ->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tentheloai' => 'Tên thể loại này đã tồn tại với một thể loại khác. Vui lòng chọn tên khác.']);
        }

        // Cập nhật dữ liệu
        $category->tentheloai = $cleanedTentheloai;
        $category->nhom = $request->nhom;
        $category->description = $sanitizedDescription;
        $category->status = $request->boolean('status');

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có và tồn tại file
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            // Lưu ảnh mới
            $category->image = $request->file('image')->store('category', 'public');
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    // Xóa thể loại
   public function destroy(Request $request, $id)
{
    try {
        $category = Category::findOrFail($id);

        $clientUpdatedAt = $request->input('updated_at');
        if (!$clientUpdatedAt || $clientUpdatedAt != $category->updated_at->toDateTimeString()) {
            return redirect()->route('admin.categories.index')
                ->withErrors(['conflict' => 'Thể loại đã được cập nhật hoặc thay đổi bởi người dùng khác. Vui lòng tải lại trang để có dữ liệu mới nhất.']);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa thể loại thành công!');
    } catch (ModelNotFoundException $e) {
        return redirect()->route('admin.categories.index')->withErrors(['delete_error' => 'Không tìm thấy thể loại. Có thể nó đã bị xóa.']);
    } catch (\Exception $e) {
        Log::error('Lỗi khi xóa thể loại: ' . $e->getMessage());
        return redirect()->route('admin.categories.index')->withErrors(['delete_error' => 'Đã xảy ra lỗi khi xóa thể loại. Vui lòng thử lại sau.']);
    }
}

    // Hiển thị chi tiết thể loại
    public function show($tentheloai)
    {
        // Lấy thể loại phải là status = true
        try {
            $category = Category::where('tentheloai', $tentheloai)
                ->where('status', true)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404, 'Thể loại không tồn tại hoặc không khả dụng.');
        }


        // Lấy các thể loại cùng nhóm, đang hoạt động, trừ thể loại hiện tại
        $categoriesByNhom = Category::where('nhom', $category->nhom)
            ->where('id', '!=', $category->id)
            ->where('status', true)
            ->get();

        $artists = Artist::where('category_id', $category->id)->get();

        // Với bài hát, tùy theo cột 'theloai' có thể là id category
        $songs = Song::where('theloai', $category->id)->with('artist')->get();

        $bannerAd = Ad::where('is_active', 1)->inRandomOrder()->first();

        return view('frontend.category_show', compact('category', 'categoriesByNhom', 'artists', 'songs', 'bannerAd'));
    }
}