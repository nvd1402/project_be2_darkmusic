<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; // Thêm dòng này nếu chưa có
use Illuminate\Support\Facades\Log; // Thêm dòng này nếu chưa có
use App\Models\User; // Thêm dòng này nếu bạn muốn lưu thông tin VIP vào bảng User

class PaymentController extends Controller
{
    // Hàm này sẽ KHÔNG được sử dụng trong luồng này (trừ khi bạn muốn giữ nó làm trang trung gian cho thông tin gói)
    // Nhưng vì bạn muốn "chuyển thẳng", chúng ta sẽ bỏ qua nó trong luồng chính.
    // Tuy nhiên, để tránh lỗi "Route not defined" nếu có chỗ nào gọi nó, hãy giữ lại nó.
    public function showCheckout($plan)
    {
        $planDetails = [];
        $paymentAmount = 0;
        $orderId = 'DM_' . uniqid();

        if ($plan === 'plus') {
            $planDetails = [
                'name' => 'DarkMusic Plus',
                'description' => 'Gói VIP cơ bản...',
                'price' => 15000,
            ];
            $paymentAmount = 15000;
        } elseif ($plan === 'premium') {
            $planDetails = [
                'name' => 'DarkMusic Premium',
                'description' => 'Gói VIP cao cấp...',
                'price' => 35000,
            ];
            $paymentAmount = 35000;
        } else {
            // Gói không hợp lệ, chuyển hướng về trang VIP
            return redirect()->route('frontend.vip.register')->with('error', 'Gói VIP không hợp lệ.');
        }
        // Nếu bạn muốn hiển thị trang checkout, thì return view('frontend.checkout', compact('planDetails', 'paymentAmount', 'orderId'));
        // Nhưng vì bạn muốn VNPAY trực tiếp, hàm này có thể không cần thiết hoặc được gọi gián tiếp.
        // Để tránh lỗi, chúng ta giữ nó nhưng sẽ không gọi trực tiếp từ vip.blade.php nữa.
        // Nếu có bất kỳ lỗi "Route not defined" liên quan đến payment.checkout, đó là do bạn đang gọi nó ở một chỗ nào đó.
        return view('frontend.checkout', compact('planDetails', 'paymentAmount', 'orderId')); // Giữ lại để tránh lỗi route nếu có chỗ nào gọi
    }

    /**
     * Xử lý tạo yêu cầu thanh toán VNPAY từ trang VIP (hoặc bất kỳ đâu).
     * Đây sẽ là hàm chính được gọi khi người dùng chọn gói.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPayment(Request $request) // Đổi tên hàm thành createPayment
    {
        $vnp_TmnCode = env('VNPAY_TMNCODE');
        $vnp_HashSecret = env('VNPAY_HASHSECRET');
        $vnp_Url = env('VNPAY_URL');
        $vnp_ReturnUrl = env('VNPAY_RETURN_URL');
        $vnp_IpnUrl = env('VNPAY_IPN_URL'); // IPN (Instant Payment Notification)

        // Lấy thông tin gói từ request
        $plan = $request->input('plan'); // 'plus' hoặc 'premium'
        $orderInfo = $request->input('order_info'); // Ví dụ: "Dang ky goi DarkMusic Plus"

        $paymentAmount = 0;
        if ($plan === 'plus') {
            $paymentAmount = 15000;
        } elseif ($plan === 'premium') {
            $paymentAmount = 35000;
        } else {
            // Xử lý gói không hợp lệ
            return redirect()->route('frontend.vip.register')->with('error', 'Gói VIP không hợp lệ.');
        }

        $vnp_TxnRef = 'DM_' . uniqid(); // Mã đơn hàng duy nhất cho giao dịch VNPAY
        $vnp_Amount = $paymentAmount * 100; // Số tiền, nhân 100 vì VNPAY tính bằng cent
        $vnp_OrderType = 'billpayment';
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();
        $vnp_CurrCode = 'VND';

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => Carbon::now()->format('YmdHis'),
            "vnp_CurrCode" => $vnp_CurrCode,
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $orderInfo, // Sử dụng orderInfo từ request
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => Carbon::now()->addMinutes(15)->format('YmdHis'), // Thời gian hết hạn 15 phút
        );

        if (isset($request->vnp_BankCode) && $request->vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $request->vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $hashdata = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url .= "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        Log::info("Chuyển hướng đến VNPAY: " . $vnp_Url);
        return redirect($vnp_Url);
    }

    /**
     * Xử lý kết quả trả về từ VNPAY (sau khi khách hàng thanh toán xong trên cổng VNPAY)
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function paymentReturn(Request $request)
    {
        $vnp_HashSecret = env('VNPAY_HASHSECRET');

        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);

        ksort($inputData);
        $hashData = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $responseCode = $request->vnp_ResponseCode;
        $transactionStatus = $request->vnp_TransactionStatus;
        $orderId = $request->vnp_TxnRef;
        $amount = $request->vnp_Amount / 100;
        $orderInfo = $request->vnp_OrderInfo;
        $transactionNo = $request->vnp_TransactionNo;
        $vnp_CardType = $request->vnp_CardType;
        $payDate = $request->vnp_PayDate;

        if ($vnp_SecureHash == $secureHash) {
            if ($responseCode == '00' && $transactionStatus == '00') {
                // Giao dịch thành công
                // TODO: Cập nhật trạng thái VIP cho người dùng (ví dụ: trong bảng users hoặc subscription)
                // Lấy user đang đăng nhập: auth()->user()
                // Cập nhật: auth()->user()->update(['is_vip' => true, 'vip_plan' => $orderInfo, 'vip_expire_date' => Carbon::now()->addMonth()]);
                Log::info("VNPAY Return (PaymentController): Giao dịch thành công - Mã ĐH: {$orderId}, Số tiền: {$amount}");
                return view('frontend.payment.vnpay_success', compact('orderId', 'amount', 'orderInfo', 'transactionNo', 'vnp_CardType', 'payDate'));
            } else {
                // Giao dịch thất bại hoặc lỗi
                Log::error("VNPAY Return (PaymentController): Giao dịch thất bại/lỗi - Mã ĐH: {$orderId}, Mã lỗi: {$responseCode}, Trạng thái: {$transactionStatus}");
                return view('frontend.payment.vnpay_fail', compact('orderId', 'responseCode', 'transactionStatus', 'orderInfo', 'transactionNo', 'vnp_CardType', 'payDate'));
            }
        } else {
            // Chuỗi hash không hợp lệ
            Log::warning("VNPAY Return (PaymentController): Chuỗi hash không hợp lệ - Mã ĐH: {$orderId}");
            return view('frontend.payment.vnpay_fail', ['message' => 'Chữ ký không hợp lệ', 'orderId' => $orderId]);
        }
    }

    /**
     * Xử lý IPN (VNPAY gọi về server của bạn để thông báo kết quả giao dịch)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vnpayIpn(Request $request)
    {
        $vnp_HashSecret = env('VNPAY_HASHSECRET');

        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);

        ksort($inputData);
        $hashData = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $returnData = array();
        if ($vnp_SecureHash == $secureHash) {
            $orderId = $inputData['vnp_TxnRef'];
            $rspCode = $inputData['vnp_ResponseCode'];
            $transactionStatus = $inputData['vnp_TransactionStatus'];

            // TODO:
            // 1. Kiểm tra trạng thái đơn hàng trong CSDL của bạn (ví dụ: đã xử lý chưa)
            // 2. Cập nhật trạng thái đơn hàng và VIP cho người dùng nếu chưa được xử lý
            // 3. Trả về mã phản hồi theo quy định của VNPAY

            // Ví dụ: kiểm tra và cập nhật trạng thái đơn hàng/VIP
            // $order = Order::where('vnp_txn_ref', $orderId)->first();
            // if ($order) {
            //     if ($order->status == 'pending') { // Giả sử trạng thái ban đầu là pending
            //         if ($rspCode == '00' && $transactionStatus == '00') {
            //             // Giao dịch thành công
            //             $order->status = 'success';
            //             $order->save();
            //             // Kích hoạt VIP cho người dùng liên quan đến order này
            //             $returnData['RspCode'] = '00';
            //             $returnData['Message'] = 'Confirm Success';
            //         } else {
            //             // Giao dịch thất bại
            //             $order->status = 'failed';
            //             $order->save();
            //             $returnData['RspCode'] = '00'; // Vẫn trả về 00 để VNPAY biết đã nhận IPN
            //             $returnData['Message'] = 'Confirm Success';
            //         }
            //     } else {
            //         // Đơn hàng đã được xử lý trước đó (vd: từ vnpayReturn)
            //         $returnData['RspCode'] = '02';
            //         $returnData['Message'] = 'Order already confirmed';
            //     }
            // } else {
            //     // Không tìm thấy đơn hàng
            //     $returnData['RspCode'] = '01';
            //     $returnData['Message'] = 'Order not found';
            // }
            // Mặc định trả về 00 nếu không có logic DB
            $returnData['RspCode'] = '00';
            $returnData['Message'] = 'Confirm Success';


        } else {
            $returnData['RspCode'] = '97';
            $returnData['Message'] = 'Invalid signature';
        }

        return response()->json($returnData);
    }
}
