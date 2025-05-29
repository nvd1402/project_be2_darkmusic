{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Thanh Toán Gói VIP - DarkMusic</title>--}}
{{--    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>--}}
{{--    --}}{{-- Bao gồm các partials head hiện có của bạn, đảm bảo có CSS chung --}}
{{--    @include('frontend.partials.head')--}}
{{--    <style>--}}
{{--        body {--}}
{{--            font-family: Arial, sans-serif;--}}
{{--            background-color: #1a1a1a; /* Dark background */--}}
{{--            color: #e0e0e0; /* Light text */--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            display: flex;--}}
{{--            justify-content: center;--}}
{{--            align-items: center;--}}
{{--            min-height: 100vh;--}}
{{--        }--}}

{{--        .payment-container {--}}
{{--            display: flex;--}}
{{--            background-color: #2a2a2a;--}}
{{--            border-radius: 10px;--}}
{{--            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);--}}
{{--            width: 100%;--}}
{{--            max-width: 900px; /* Adjust max-width as needed */--}}
{{--            overflow: hidden; /* For rounded corners */--}}
{{--        }--}}

{{--        .order-info-section, .payment-form-section {--}}
{{--            padding: 30px;--}}
{{--            flex: 1; /* Each section takes equal width */--}}
{{--        }--}}

{{--        .order-info-section {--}}
{{--            background-color: #333333; /* Slightly darker for order info */--}}
{{--            border-right: 1px solid #444444; /* Separator */--}}
{{--        }--}}

{{--        .order-info-section h3, .payment-form-section h3 {--}}
{{--            color: #00bcd4; /* Accent color */--}}
{{--            margin-bottom: 25px;--}}
{{--            font-size: 1.8em;--}}
{{--            text-align: center;--}}
{{--        }--}}

{{--        .order-details {--}}
{{--            list-style: none;--}}
{{--            padding: 0;--}}
{{--            margin: 0;--}}
{{--        }--}}

{{--        .order-details li {--}}
{{--            display: flex;--}}
{{--            justify-content: space-between;--}}
{{--            margin-bottom: 15px;--}}
{{--            font-size: 1.1em;--}}
{{--            padding-bottom: 5px;--}}
{{--            border-bottom: 1px dashed #444444;--}}
{{--        }--}}

{{--        .order-details li:last-child {--}}
{{--            border-bottom: none;--}}
{{--            margin-bottom: 0;--}}
{{--        }--}}

{{--        .order-details li span:first-child {--}}
{{--            color: #b0b0b0;--}}
{{--        }--}}

{{--        .order-details li span:last-child {--}}
{{--            font-weight: bold;--}}
{{--            color: #e0e0e0;--}}
{{--        }--}}

{{--        .order-details .total-amount span:last-child {--}}
{{--            color: #00bcd4; /* Highlight total amount */--}}
{{--            font-size: 1.2em;--}}
{{--        }--}}

{{--        /* Payment Form Styles */--}}
{{--        .payment-form-section form {--}}
{{--            display: flex;--}}
{{--            flex-direction: column;--}}
{{--        }--}}

{{--        .form-group {--}}
{{--            margin-bottom: 20px;--}}
{{--            text-align: left;--}}
{{--        }--}}

{{--        .form-group label {--}}
{{--            display: block;--}}
{{--            margin-bottom: 8px;--}}
{{--            color: #e0e0e0;--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .form-group input[type="text"] {--}}
{{--            width: calc(100% - 22px); /* Adjust for padding and border */--}}
{{--            padding: 12px 10px;--}}
{{--            border: 1px solid #444444;--}}
{{--            border-radius: 5px;--}}
{{--            background-color: #333333;--}}
{{--            color: #e0e0e0;--}}
{{--            font-size: 1em;--}}
{{--            box-sizing: border-box;--}}
{{--        }--}}

{{--        .form-group input::placeholder {--}}
{{--            color: #888888;--}}
{{--        }--}}

{{--        .card-number-group {--}}
{{--            position: relative;--}}
{{--        }--}}

{{--        .card-number-group .card-logo {--}}
{{--            position: absolute;--}}
{{--            right: 10px;--}}
{{--            top: 50%;--}}
{{--            transform: translateY(-50%);--}}
{{--            height: 24px; /* Adjust size as needed */--}}
{{--            pointer-events: none; /* Make sure it doesn't interfere with input */--}}
{{--        }--}}

{{--        .promotion-code-section {--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}

{{--        .promotion-code-section input {--}}
{{--            flex-grow: 1;--}}
{{--            margin-right: 10px;--}}
{{--        }--}}

{{--        .promotion-code-section button {--}}
{{--            background-color: #555555;--}}
{{--            color: #e0e0e0;--}}
{{--            border: none;--}}
{{--            border-radius: 5px;--}}
{{--            padding: 10px 15px;--}}
{{--            cursor: pointer;--}}
{{--            transition: background-color 0.3s ease;--}}
{{--        }--}}

{{--        .promotion-code-section button:hover {--}}
{{--            background-color: #666666;--}}
{{--        }--}}

{{--        .conditions {--}}
{{--            display: block;--}}
{{--            color: #00bcd4;--}}
{{--            text-decoration: none;--}}
{{--            margin-bottom: 30px;--}}
{{--            font-size: 0.9em;--}}
{{--            text-align: right; /* Align to right as in image */--}}
{{--        }--}}

{{--        .payment-buttons {--}}
{{--            display: flex;--}}
{{--            gap: 15px;--}}
{{--            justify-content: flex-end;--}}
{{--            margin-top: 30px;--}}
{{--        }--}}

{{--        .payment-buttons .cancel-btn {--}}
{{--            background-color: #555555;--}}
{{--            color: #e0e0e0;--}}
{{--            border: none;--}}
{{--            border-radius: 8px;--}}
{{--            padding: 12px 25px;--}}
{{--            font-size: 1em;--}}
{{--            cursor: pointer;--}}
{{--            transition: background-color 0.3s ease;--}}
{{--        }--}}

{{--        .payment-buttons .cancel-btn:hover {--}}
{{--            background-color: #666666;--}}
{{--        }--}}

{{--        .payment-buttons .continue-btn {--}}
{{--            background-color: #00bcd4;--}}
{{--            color: white;--}}
{{--            border: none;--}}
{{--            border-radius: 8px;--}}
{{--            padding: 12px 25px;--}}
{{--            font-size: 1em;--}}
{{--            cursor: pointer;--}}
{{--            transition: background-color 0.3s ease;--}}
{{--        }--}}

{{--        .payment-buttons .continue-btn:hover {--}}
{{--            background-color: #0097a7;--}}
{{--        }--}}

{{--        /* Responsive adjustments */--}}
{{--        @media (max-width: 768px) {--}}
{{--            .payment-container {--}}
{{--                flex-direction: column;--}}
{{--                max-width: 95%;--}}
{{--            }--}}
{{--            .order-info-section {--}}
{{--                border-right: none;--}}
{{--                border-bottom: 1px solid #444444;--}}
{{--            }--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="payment-container">--}}
{{--    <div class="order-info-section">--}}
{{--        <h3>Thông tin đơn hàng (Test)</h3>--}}
{{--        <ul class="order-details">--}}
{{--            <li><span>Gói đã chọn:</span> <span>{{ $planDetails['name'] ?? 'N/A' }}</span></li>--}}
{{--            <li><span>Mô tả gói:</span> <span>{{ $planDetails['description'] ?? 'N/A' }}</span></li>--}}
{{--            <li><span>Số tiền thanh toán:</span> <span>{{ number_format($paymentAmount ?? 0, 0, ',', '.') }} VND</span></li>--}}
{{--            <li><span>Phí giao dịch:</span> <span>0 VND</span></li>--}}
{{--            <li><span>Order ID:</span> <span>{{ $orderId ?? 'N/A' }}</span></li>--}}
{{--            <li><span>Nhà cung cấp:</span> <span>Công ty CTT HTT1 (Test)</span></li>--}}
{{--        </ul>--}}
{{--    </div>--}}

{{--    <div class="payment-form-section">--}}
{{--        <h3>Thanh toán qua NCB</h3>--}}
{{--        <p style="color: #b0b0b0; text-align: center; margin-bottom: 20px;">Thẻ nội địa</p>--}}

{{--        <form action="{{ route('frontend.payment.process') }}" method="POST">--}}
{{--            @csrf--}}
{{--            <input type="hidden" name="amount" value="{{ $paymentAmount ?? 0 }}">--}}
{{--            <input type="hidden" name="order_id" value="{{ $orderId ?? '' }}">--}}
{{--            <input type="hidden" name="plan_name" value="{{ $planDetails['name'] ?? '' }}">--}}

{{--            <div class="form-group card-number-group">--}}
{{--                <label for="card_number">Số thẻ</label>--}}
{{--                <input type="text" id="card_number" name="card_number" placeholder="************2198" required>--}}
{{--                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/NCB_Logo.svg/1200px-NCB_Logo.svg.png" onerror="this.onerror=null;this.src='https://placehold.co/50x24/333/e0e0e0?text=NCB';" alt="NCB Logo" class="card-logo">--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                <label for="card_holder">Chủ thẻ</label>--}}
{{--                <input type="text" id="card_holder" name="card_holder" placeholder="NGUYEN VAN A" required>--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                <label for="issuing_date">Ngày phát hành <i class='bx bx-info-circle' style="font-size: 1em; color: #b0b0b0;"></i></label>--}}
{{--                <input type="text" id="issuing_date" name="issuing_date" placeholder="MM/YY" pattern="\d{2}/\d{2}" title="Vui lòng nhập theo định dạng MM/YY" required>--}}
{{--            </div>--}}

{{--            <div class="form-group promotion-code-section">--}}
{{--                <label for="promotion_code" style="flex-basis: 120px; margin-bottom: 0;">Mã khuyến mãi</label>--}}
{{--                <input type="text" id="promotion_code" name="promotion_code" placeholder="Chọn hoặc nhập mã khuyến mãi">--}}
{{--                <button type="button">Áp dụng</button>--}}
{{--            </div>--}}

{{--            <a href="#" class="conditions">Điều kiện</a>--}}

{{--            <div class="payment-buttons">--}}
{{--                <button type="button" class="cancel-btn" onclick="window.history.back()">Hủy</button>--}}
{{--                <button type="submit" class="continue-btn">Tiếp tục</button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}
