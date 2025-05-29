<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('frontend.partials.head')
    <style>
        /* Existing styles from your provided code */
        .heart-float {
            position: absolute;
            animation: floatUp 1s ease-out;
            font-size: 18px;
            color: red;
            pointer-events: none;
        }

        @keyframes floatUp {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-40px) scale(1.5);
            }
        }

        /* Styles for the VIP Subscription page */
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a; /* Dark background */
            color: #e0e0e0; /* Light text */
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        main {
            flex-grow: 1;
            padding: 20px;
            background-color: #000000; /* Slightly lighter dark for main content */
            border-radius: 8px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background-color: #2a2a2a; /* Darker header background */
            padding: 15px 20px;
            border-radius: 8px;
        }

        .search {
            position: relative;
        }

        .search input {
            background-color: #333333;
            border: none;
            border-radius: 20px;
            padding: 10px 40px 10px 15px;
            color: #e0e0e0;
            width: 300px;
        }

        .search i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888888;
        }

        .vip-section {
            padding: 40px;
            text-align: center;
            background-color: #000000; /* Main section background */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .vip-section h2 {
            font-size: 2.5em;
            color: #e0e0e0;
            margin-bottom: 10px;
        }

        .vip-section p {
            font-size: 1.1em;
            color: #b0b0b0;
            margin-bottom: 40px;
            line-height: 1.6;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .membership-options {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
        }

        .membership-card {
            background-color: #333333; /* Card background */
            border-radius: 15px;
            padding: 30px;
            width: 380px; /* Increased width for better layout */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            text-align: left;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            border: 1px solid #444444; /* Subtle border */
        }

        .membership-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        }

        .membership-card h3 {
            font-size: 2em;
            color: #00bcd4; /* Accent color for plan names */
            margin-bottom: 15px;
            text-align: center;
        }

        .membership-card .price {
            font-size: 1.6em;
            color: #e0e0e0;
            margin-bottom: 25px;
            text-align: center;
            font-weight: bold;
        }

        .membership-card ul {
            list-style: none;
            padding: 0;
            margin-bottom: 30px;
        }

        .membership-card li {
            margin-bottom: 15px;
            color: #c0c0c0;
            font-size: 1.1em;
            display: flex;
            align-items: flex-start;
        }

        .membership-card li::before {
            content: '✓'; /* Checkmark icon */
            color: #00bcd4; /* Accent color for checkmark */
            margin-right: 10px;
            font-weight: bold;
            font-size: 1.2em;
        }

        .membership-card button {
            background-color: #00bcd4; /* Accent color for button */
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px 30px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            font-weight: bold;
        }

        .membership-card button:hover {
            background-color: #0097a7; /* Darker shade on hover */
        }
    </style>
</head>
<body class="text-light">
<div class="container">
    @include('frontend.partials.sidebar')
    <main>

        {{-- VIP Subscription Section --}}
        <div class="vip-section">
            <h2>Khám phá VIP</h2>
            <p>Nâng cấp trải nghiệm nghe nhạc của bạn với các gói VIP độc quyền, truy cập nội dung cao cấp và tận hưởng âm nhạc không giới hạn.</p>
            <div class="membership-options">
                <div class="membership-card">
                    <h3>DarkMusic Plus</h3>
                    <p class="price">Chỉ từ 15.000 đ/ tháng</p>
                    <ul>
                        <li>Trải nghiệm chất lượng nhạc cao nhất</li>
                        <li>Tạo playlist không giới hạn</li>
                        <li>Nghe nhạc được tất cả các nhạc bản quyền</li>
                    </ul>
                    <button onclick="window.location='{{ route('frontend.payment.checkout', ['plan' => 'plus']) }}'" style="margin-top: 60px">Đăng ký gói</button>
                </div>
                <div class="membership-card">
                    <h3>DarkMusic Premium</h3>
                    <p class="price">Chỉ từ 35.000 đ/ tháng</p>
                    <ul>
                        <li>Trải nghiệm chất lượng nhạc cao nhất</li>
                        <li>Tạo playlist không giới hạn</li>
                        <li>Nghe nhạc được tất cả các nhạc bản quyền</li>
                        <li>Được nghe demo trước các bản nhạc của nghệ sĩ sắp ra mắt</li>
                    </ul>
                    <button onclick="window.location='{{ route('frontend.payment.checkout', ['plan' => 'premium']) }}'">Đăng ký gói</button>
                </div>
            </div>
        </div>


        </section>
    </main>
    @include('frontend.partials.right_content')
</div>

<script type='text/javascript' src="script.js"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/songs.js') }}"></script>
</body>
</html>
