<!DOCTYPE html>
<html lang="vi">
<head>
    @include('admin.partials.head')

    <style>
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary { background-color: #007bff; }
        .btn-secondary { background-color: #6c757d; }
        .btn-success { background-color: #28a745; }
        .btn:hover { opacity: 0.85; }

        form label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"], select, textarea {
            width: 100%;
            max-width: 400px;
            padding: 8px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
            margin-bottom: 8px;
        }

        textarea {
            resize: vertical;
        }

        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-message {
            color: #d9534f;
            font-size: 13px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    @include('admin.partials.sidebar')

    <main>
        @include('admin.partials.header')

        <div class="page-header">
            <h2 class="title">Thêm bình luận mới</h2>
        </div>

        <div class="content p-4">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.comments.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="user_id">Người dùng</label>
<select name="user_id" id="user_id" required>
    <option value="">-- Chọn người dùng --</option>
    @foreach ($users as $user)
        <option value="{{ $user->user_id }}" {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
            {{ $user->username }}
        </option>
    @endforeach
</select>



                    @error('user_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="news_id">Tin tức</label>
                    <select name="news_id" id="news_id" required>
                        <option value="">-- Chọn tin tức --</option>
                        @foreach ($news as $n)
                            <option value="{{ $n->id }}" {{ old('news_id') == $n->id ? 'selected' : '' }}>
                                {{ $n->tieude }}
                            </option>
                        @endforeach
                    </select>
                    @error('news_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="noidung">Nội dung</label>
                    <textarea name="noidung" id="noidung" rows="4" required>{{ old('noidung') }}</textarea>
                    @error('noidung')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Thêm bình luận</button>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </main>
</div>
</body>
</html>