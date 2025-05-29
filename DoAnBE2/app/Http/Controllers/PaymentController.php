<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Hiển thị trang thanh toán.
     *
     * @param string $plan Tên gói VIP (plus hoặc premium)
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showCheckout($plan)
    {
        $planDetails = [];
        $paymentAmount = 0;
        $orderId = 'DM_' . uniqid(); // Tạo một ID đơn hàng đơn giản, thêm tiền tố để dễ nhận biết

        if ($plan === 'plus') {
            $planDetails = [
                'name' => 'DarkMusic Plus',
                'description' => 'Gói VIP cơ bản với chất lượng nhạc cao nhất, tạo playlist không giới hạn, nghe nhạc bản quyền.',
                'price' => 15000, // 15.000 VND
            ];
            $paymentAmount = 15000;
        } elseif ($plan === 'premium') {
            $planDetails = [
                'name' => 'DarkMusic Premium',
                'description' => 'Gói VIP cao cấp với tất cả tính năng của gói Plus và được nghe demo nhạc sắp ra mắt.',
                'price' => 35000, // 35.000 VND
            ];
            $paymentAmount = 35000;
        } else {
            // Xử lý trường hợp gói không hợp lệ, chuyển hướng về trang VIP với thông báo lỗi
            return redirect()->route('vip.register')->with('error', 'Gói VIP không hợp lệ.');
        }

        // Trả về view thanh toán và truyền dữ liệu gói, số tiền, và Order ID
        return view('frontend.checkout', compact('planDetails', 'paymentAmount', 'orderId'));
    }

    /**
     * Xử lý việc gửi form thanh toán.
     * Đây là nơi bạn sẽ tích hợp với cổng thanh toán VNPAY.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processPayment(Request $request)
    {
        // 1. Validate dữ liệu đầu vào từ form thanh toán
        $request->validate([
            'card_number' => 'required|string',
            'card_holder' => 'required|string',
            'issuing_date' => 'required|string|regex:/^\d{2}\/\d{2}$/', // Định dạng MM/YY
            'amount' => 'required|numeric|min:1', // Đảm bảo số tiền không âm
            'order_id' => 'required|string',
            'plan_name' => 'required|string',
        ]);

        // 2. Logic tích hợp với VNPAY (hoặc cổng thanh toán khác)
        // PHẦN NÀY BẠN CẦN THAY THẾ BẰNG CODE TÍCH HỢP VNPAY THỰC TẾ CỦA BẠN.
        // Dưới đây là một ví dụ giả định cho việc chuyển hướng đến VNPAY.
        // Bạn cần cấu hình các biến môi trường VNPAY_TMN_CODE, VNPAY_HASH_SECRET, VNPAY_URL trong file .env

        // Ví dụ tích hợp VNPAY (phần này cần được phát triển chi tiết theo tài liệu VNPAY)
        // $vnp_TmnCode = config('services.vnpay.tmn_code');
        // $vnp_HashSecret = config('services.vnpay.hash_secret');
        // $vnp_Url = config('services.vnpay.url');
        // $vnp_ReturnUrl = route('payment.return'); // URL VNPAY sẽ gọi về sau khi thanh toán

        // $inputData = array(
        //     "vnp_Version" => "2.1.0",
        //     "vnp_TmnCode" => $vnp_TmnCode,
        //     "vnp_Amount" => $request->amount * 100, // VNPAY yêu cầu số tiền nhân 100
        //     "vnp_Command" => "pay",
        //     "vnp_CreateDate" => date('YmdHis'),
        //     "vnp_CurrCode" => "VND",
        //     "vnp_IpAddr" => $request->ip(),
        //     "vnp_Locale" => "vn",
        //     "vnp_OrderInfo" => "Thanh toan goi " . $request->plan_name . " cho don hang " . $request->order_id,
        //     "vnp_OrderType" => "billpayment",
        //     "vnp_ReturnUrl" => $vnp_ReturnUrl,
        //     "vnp_TxnRef" => $request->order_id,
        // );

        // ksort($inputData);
        // $query = "";
        // $hashdata = "";
        // foreach ($inputData as $key => $value) {
        //     if ($query == "") {
        //         $query = $key . "=" . urlencode($value);
        //         $hashdata = $key . "=" . $value;
        //     } else {
        //         $query .= "&" . $key . "=" . urlencode($value);
        //         $hashdata .= "&" . $key . "=" . $value;
        //     }
        // }

        // $vnpSecureHash = hash_hmac('sha512', $vnp_HashSecret . $hashdata, false); // VNPAY yêu cầu hash_hmac với raw_output = false
        // $vnp_Url .= "?" . $query . '&vnp_SecureHash=' . $vnpSecureHash;

        // return redirect($vnp_Url);

        // Tạm thời: giả lập xử lý thành công và chuyển hướng về trang chủ
        // Trong môi trường thực tế, bạn sẽ nhận được kết quả từ cổng thanh toán VNPAY
        // và dựa vào đó để cập nhật trạng thái đơn hàng/VIP cho người dùng.
        return redirect()->route('frontend.index')->with('success', 'Yêu cầu thanh toán cho gói ' . $request->plan_name . ' đã được gửi. Vui lòng kiểm tra email của bạn để xác nhận.');
    }

    /**
     * Xử lý phản hồi từ VNPAY sau khi thanh toán.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentReturn(Request $request)
    {
        // Đây là nơi bạn sẽ xử lý phản hồi từ VNPAY.
        // Bạn cần xác minh chữ ký số (SecureHash) và kiểm tra các mã trạng thái giao dịch.
        // Dựa vào kết quả, bạn sẽ cập nhật trạng thái đơn hàng trong database và thông báo cho người dùng.

        // Ví dụ:
        // if ($request->vnp_ResponseCode == '00' && $request->vnp_TransactionStatus == '00') {
        //     // Thanh toán thành công
        //     // Cập nhật trạng thái VIP cho người dùng
        //     return redirect()->route('frontend.home')->with('success', 'Thanh toán thành công! Gói VIP của bạn đã được kích hoạt.');
        // } else {
        //     // Thanh toán thất bại hoặc có lỗi
        //     return redirect()->route('frontend.home')->with('error', 'Thanh toán thất bại. Vui lòng thử lại hoặc liên hệ hỗ trợ.');
        // }

        return redirect()->route('frontend.index')->with('info', 'Trang xử lý phản hồi thanh toán đang được phát triển.');
    }
}
