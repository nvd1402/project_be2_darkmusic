<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Ad;
use Illuminate\Support\Facades\Storage; // Thêm Facade Storage để xử lý xóa ảnh
use Illuminate\Database\Eloquent\ModelNotFoundException; // Thêm ModelNotFoundException

class NewsController extends Controller
{
    /**
     * Hiển thị tất cả tin tức (trang admin).
     *
     * @return \Illuminate\View\View
     */
public function index()
{
    // Thay vì get() lấy tất cả, dùng paginate để phân trang 10 bản tin/trang
    $news = News::orderBy('updated_at', 'desc')->paginate(10);

    return view('admin.news.index', compact('news'));
}


    /**
     * Tìm kiếm tin tức theo từ khóa (trang admin).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            // Nếu không có từ khóa, trả về danh sách đầy đủ
            return redirect()->route('admin.news.index');
        }

        // Tìm kiếm theo tiêu đề hoặc đơn vị đăng
        $news = News::where('tieude', 'like', "%{$query}%")
                    ->orWhere('donvidang', 'like', "%{$query}%")
                    ->get();

        return view('admin.news.index', compact('news'));
    }

    /**
     * Hiển thị form thêm tin tức mới.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Lưu tin tức mới vào cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Lấy dữ liệu gốc và chỉ chuẩn hóa số, KHÔNG TRIM DỮ LIỆU Ở ĐÂY.
        // Việc trim và kiểm tra khoảng trắng sẽ được xử lý trong validation và các hàm helper.
        $normalizedTieude = $this->normalizeNumbers($request->input('tieude'));
        $normalizedDonViDang = $this->normalizeNumbers($request->input('donvidang'));

        // Gán lại dữ liệu đã chuẩn hóa số nhưng CHƯA TRIM vào request để validation kiểm tra
        $request->merge([
            'tieude' => $normalizedTieude,
            'donvidang' => $normalizedDonViDang,
        ]);

        // Validate dữ liệu đầu vào với các Closure Rules chi tiết
        $request->validate([
            'tieude' => [
                'required',
                'max:1000',
                // Rule 1: Kiểm tra khoảng trắng ở đầu hoặc cuối
                function ($attribute, $value, $fail) {
                    if ($this->hasLeadingOrTrailingWhitespace($value)) {
                        $fail('Tiêu đề không được chứa khoảng trắng ở đầu hoặc cuối.');
                    }
                },
                // Rule 2: Kiểm tra khoảng trắng kép (hoặc các khoảng trắng không chuẩn Unicode) ở giữa chuỗi
                function ($attribute, $value, $fail) {
                    // Chuẩn hóa tất cả các loại khoảng trắng thành một khoảng trắng duy nhất
                    // và so sánh với giá trị gốc để phát hiện khoảng trắng thừa ở giữa
                    $cleanedValue = preg_replace('/[\s\x{3000}]+/u', ' ', $value);
                    if ($cleanedValue !== $value) {
                         $fail('Tiêu đề không được chứa nhiều khoảng trắng liền kề hoặc các ký tự khoảng trắng không hợp lệ ở giữa.');
                    }
                },
            ],
            'noidung' => [
                'required',
                // Rule: Kiểm tra nội dung không chứa HTML
                function ($attribute, $value, $fail) {
                    if ($value !== strip_tags($value)) {
                        $fail('Nội dung không được chứa mã HTML.');
                    }
                }
            ],
            'donvidang' => [
                'required',
                'max:255',
                // Rule 1: Kiểm tra khoảng trắng ở đầu hoặc cuối
                function ($attribute, $value, $fail) {
                    if ($this->hasLeadingOrTrailingWhitespace($value)) {
                        $fail('Đơn vị đăng không được chứa khoảng trắng ở đầu hoặc cuối.');
                    }
                },
                // Rule 2: Kiểm tra khoảng trắng kép (hoặc các khoảng trắng không chuẩn Unicode) ở giữa chuỗi
                function ($attribute, $value, $fail) {
                    $cleanedValue = preg_replace('/[\s\x{3000}]+/u', ' ', $value);
                    if ($cleanedValue !== $value) {
                         $fail('Đơn vị đăng không được chứa nhiều khoảng trắng liền kề hoặc các ký tự khoảng trắng không hợp lệ ở giữa.');
                    }
                },
            ],
            'hinhanh' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tieude.required' => 'Vui lòng nhập tiêu đề.',
            'tieude.max' => 'Tiêu đề không được vượt quá :max ký tự.',
            // Các thông báo lỗi cho closure rules được xử lý bởi hàm $fail()

            'noidung.required' => 'Vui lòng nhập nội dung.',
            // Thông báo lỗi cho nội dung không HTML được xử lý bởi hàm $fail()

            'donvidang.required' => 'Vui lòng nhập đơn vị đăng.',
            'donvidang.max' => 'Đơn vị đăng không được vượt quá 255 ký tự.',
            // Các thông báo lỗi cho closure rules được xử lý bởi hàm $fail()

            'hinhanh.required' => 'Vui lòng chọn ảnh cho tin tức.',
            'hinhanh.image' => 'Hình ảnh phải là một tệp ảnh hợp lệ.',
            'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'hinhanh.max' => 'Hình ảnh không được vượt quá 2MB.',
        ]);

        // Sau khi validation thành công, tiến hành làm sạch dữ liệu trước khi lưu vào DB
        $trimmedTieudeForDb = $this->customTrim($request->input('tieude'));
        $trimmedDonViDangForDb = $this->customTrim($request->input('donvidang'));

        // Kiểm tra xem tiêu đề đã tồn tại chưa (sau khi đã trim để so sánh chính xác với DB)
        $exists = News::where('tieude', $trimmedTieudeForDb)->exists();
        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tieude' => 'Tiêu đề tin tức này đã tồn tại. Vui lòng làm mới trang để cập nhật dữ liệu mới nhất.']);
        }

        $news = new News();
        $news->tieude = $trimmedTieudeForDb;
        $news->noidung = $request->noidung; // nội dung đã được validate không có HTML
        $news->donvidang = $trimmedDonViDangForDb;

        // Xử lý upload ảnh
        if ($request->hasFile('hinhanh')) {
            $imagePath = $request->file('hinhanh')->store('news_images', 'public');
            $news->hinhanh = $imagePath;
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được thêm thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa tin tức.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try {
            $news = News::findOrFail($id);
            return view('admin.news.edit', compact('news'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.news.index')->with('error', 'Không tìm thấy tin tức với ID bạn yêu cầu.');
        }
    }

    /**
     * Cập nhật tin tức trong cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $news = News::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.news.index')->with('error', 'Không tìm thấy tin tức để cập nhật.');
        }

        // Lấy dữ liệu gốc và chỉ chuẩn hóa số, KHÔNG TRIM DỮ LIỆU Ở ĐÂY.
        $normalizedTieude = $this->normalizeNumbers($request->input('tieude'));
        $normalizedDonViDang = $this->normalizeNumbers($request->input('donvidang'));

        // Gán lại dữ liệu đã chuẩn hóa số nhưng CHƯA TRIM vào request để validation kiểm tra
        $request->merge([
            'tieude' => $normalizedTieude,
            'donvidang' => $normalizedDonViDang,
        ]);

        // Validate các input với các Closure Rules chi tiết
        $request->validate([
            'tieude' => [
                'required',
                'max:1000',
                // Rule 1: Kiểm tra khoảng trắng ở đầu hoặc cuối
                function ($attribute, $value, $fail) {
                    if ($this->hasLeadingOrTrailingWhitespace($value)) {
                        $fail('Tiêu đề không được chứa khoảng trắng ở đầu hoặc cuối.');
                    }
                },
                // Rule 2: Kiểm tra khoảng trắng kép (hoặc các khoảng trắng không chuẩn Unicode) ở giữa chuỗi
                function ($attribute, $value, $fail) {
                    $cleanedValue = preg_replace('/[\s\x{3000}]+/u', ' ', $value);
                    if ($cleanedValue !== $value) {
                         $fail('Tiêu đề không được chứa nhiều khoảng trắng liền kề hoặc các ký tự khoảng trắng không hợp lệ ở giữa.');
                    }
                },
            ],
            'noidung' => [
                'required',
                // Rule: Kiểm tra nội dung không chứa HTML
                function ($attribute, $value, $fail) {
                    if ($value !== strip_tags($value)) {
                        $fail('Nội dung không được chứa mã HTML.');
                    }
                }
            ],
            'donvidang' => [
                'required',
                'max:255',
                // Rule 1: Kiểm tra khoảng trắng ở đầu hoặc cuối
                function ($attribute, $value, $fail) {
                    if ($this->hasLeadingOrTrailingWhitespace($value)) {
                        $fail('Đơn vị đăng không được chứa khoảng trắng ở đầu hoặc cuối.');
                    }
                },
                // Rule 2: Kiểm tra khoảng trắng kép (hoặc các khoảng trắng không chuẩn Unicode) ở giữa chuỗi
                function ($attribute, $value, $fail) {
                    $cleanedValue = preg_replace('/[\s\x{3000}]+/u', ' ', $value);
                    if ($cleanedValue !== $value) {
                         $fail('Đơn vị đăng không được chứa nhiều khoảng trắng liền kề hoặc các ký tự khoảng trắng không hợp lệ ở giữa.');
                    }
                },
            ],
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'updated_at' => 'required', // Bắt buộc có updated_at để kiểm tra xung đột
        ], [
            'tieude.required' => 'Vui lòng nhập tiêu đề.',
            'tieude.max' => 'Tiêu đề không được vượt quá :max ký tự.',
            // Các thông báo lỗi cho closure rules được xử lý bởi hàm $fail()

            'noidung.required' => 'Vui lòng nhập nội dung.',
            // Thông báo lỗi cho nội dung không HTML được xử lý bởi hàm $fail()

            'donvidang.required' => 'Vui lòng nhập đơn vị đăng.',
            'donvidang.max' => 'Đơn vị đăng không được vượt quá 255 ký tự.',
            // Các thông báo lỗi cho closure rules được xử lý bởi hàm $fail()

            'hinhanh.image' => 'Hình ảnh phải là một tệp ảnh hợp lệ.',
            'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'hinhanh.max' => 'Hình ảnh không được vượt quá 2MB.',
            'updated_at.required' => 'Dữ liệu không hợp lệ. Vui lòng tải lại trang.', // Thông báo khi updated_at không có
        ]);

        // So sánh updated_at gửi lên từ form với bản ghi hiện tại trong DB
        // Điều này giúp phát hiện xung đột khi nhiều người cùng sửa một bản ghi
        if ($request->updated_at != $news->updated_at->toDateTimeString()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['conflict' => 'Tin tức đã được chỉnh sửa bởi người dùng khác. Vui lòng tải lại trang để cập nhật dữ liệu mới nhất.']);
        }

        // Sau khi validation thành công, tiến hành làm sạch dữ liệu trước khi lưu vào DB
        $trimmedTieudeForDb = $this->customTrim($request->input('tieude'));
        $trimmedDonViDangForDb = $this->customTrim($request->input('donvidang'));

        // Kiểm tra tiêu đề trùng lặp với bản ghi khác (sau khi đã trim để so sánh chính xác)
        $exists = News::where('tieude', $trimmedTieudeForDb)
                      ->where('id', '!=', $id) // Loại trừ bản ghi hiện tại
                      ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tieude' => 'Tiêu đề tin tức này đã tồn tại. Vui lòng đổi tiêu đề khác.']);
        }

        // Cập nhật dữ liệu
        $news->tieude = $trimmedTieudeForDb;
        $news->noidung = $request->noidung; // nội dung đã được validate không có HTML
        $news->donvidang = $trimmedDonViDangForDb;

        // Xử lý upload ảnh mới hoặc giữ ảnh cũ
        if ($request->hasFile('hinhanh')) {
            // Xóa ảnh cũ nếu có và tồn tại file
            if ($news->hinhanh && Storage::disk('public')->exists($news->hinhanh)) {
                Storage::disk('public')->delete($news->hinhanh);
            }
            // Lưu ảnh mới
            $imagePath = $request->file('hinhanh')->store('news_images', 'public');
            $news->hinhanh = $imagePath;
        }

        $news->save();

        return redirect()->route('admin.news.index')
                         ->with('success', 'Tin tức đã được cập nhật thành công!');
    }

    /**
     * Xóa một tin tức khỏi cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            $news = News::findOrFail($id);

            // Kiểm tra updated_at từ client để tránh xóa bản ghi đã bị thay đổi/xóa bởi người khác
            $clientUpdatedAt = $request->input('updated_at');
            if (!$clientUpdatedAt || $clientUpdatedAt != $news->updated_at->toDateTimeString()) {
                return redirect()->route('admin.news.index')
                    ->with('error', 'Tin tức đã được thay đổi hoặc xóa bởi người khác. Vui lòng tải lại trang.');
            }

            // Xóa ảnh liên quan nếu có
            if ($news->hinhanh && Storage::disk('public')->exists($news->hinhanh)) {
                Storage::disk('public')->delete($news->hinhanh);
            }

            $news->delete();

            return redirect()->route('admin.news.index')
                ->with('success', 'Đã xóa tin tức thành công!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.news.index')->with('error', 'Tin tức bạn muốn xóa không còn tồn tại. Có thể đã bị xóa ở nơi khác.');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error("Error deleting news ID {$id}: " . $e->getMessage());
            return redirect()->route('admin.news.index')->with('error', 'Đã xảy ra lỗi trong quá trình xóa tin tức. Vui lòng thử lại.');
        }
    }

    /**
     * Hiển thị chi tiết tin tức (trang frontend).
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        try {
            $news = News::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('frontend.news.index')->with('error', 'Không tìm thấy trang bạn yêu cầu.');
        }

        // Lấy danh sách bình luận của bài news, kèm user, sắp xếp mới nhất lên đầu
        $comments = $news->comments()->with('user')->latest()->get();

        // Lấy 5 tin tức liên quan (khác ID và mới nhất)
        $relatedNews = News::where('id', '!=', $news->id)
                            ->latest()
                            ->take(5)
                            ->get();

        // Lấy 1 quảng cáo ngẫu nhiên đang được active
        $bannerAd = Ad::where('is_active', 1)->inRandomOrder()->first();

        return view('frontend.news_show', compact('news', 'relatedNews', 'bannerAd', 'comments'));
    }

    /**
     * Kiểm tra xem chuỗi có khoảng trắng ở đầu hoặc cuối hay không.
     * Bao gồm cả khoảng trắng truyền thống (\s) và khoảng trắng toàn chiều rộng Unicode (　).
     *
     * @param string $string
     * @return bool
     */
    private function hasLeadingOrTrailingWhitespace($string)
    {
        return preg_match('/^[\s\x{3000}]+|[\s\x{3000}]+$/u', $string);
    }

    /**
     * Loại bỏ khoảng trắng ở đầu và cuối chuỗi (bao gồm cả khoảng trắng toàn chiều rộng Unicode).
     * Hàm này được dùng để làm sạch dữ liệu trước khi lưu vào DB, sau khi validation.
     *
     * @param string $string
     * @return string
     */
    private function customTrim($string)
    {
        return preg_replace('/^[\s\x{3000}]+|[\s\x{3000}]+$/u', '', $string);
    }

    /**
     * Chuẩn hóa các số full-width (ví dụ: ０-９) thành số half-width (0-9).
     *
     * @param string $string
     * @return string
     */
    private function normalizeNumbers($string)
    {
        return preg_replace_callback('/[\x{FF10}-\x{FF19}]/u', function ($matches) {
            return chr(ord($matches[0]) - 0xFEE0);
        }, $string);
    }
}