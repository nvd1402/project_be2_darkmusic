{{-- resources/views/errors/404.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CDN nếu bạn không dùng Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center px-6">
        <h1 class="text-7xl font-bold text-blue-600">404</h1>
        <h2 class="text-2xl mt-4 text-gray-800">Không tìm thấy trang</h2>
        <p class="text-gray-600 mt-2">Trang bạn đang tìm không tồn tại hoặc đã bị di chuyển.</p>
        <a href="{{ route('admin.dashboard') }}" class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Quay về trang chủ
        </a>
    </div>
</body>
</html>
