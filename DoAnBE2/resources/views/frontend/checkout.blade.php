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
</style>
</head>
<body class="text-light">
<div class="container">
    @include('frontend.partials.sidebar')
    <main>

    </main>
    @include('frontend.partials.right_content')
</div>

<script type='text/javascript' src="script.js"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/songs.js') }}"></script>
</body>
</html>
