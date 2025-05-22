<!DOCTYPE html>
<html lang="en">
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
        .btn-warning { background-color: #ffc107; color: #000; }
        .btn:hover { opacity: 0.85; }

        form label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"], select, textarea {
            width: 350px;
            padding: 8px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
            margin-bottom: 15px;
        }

        textarea {
            resize: vertical;
        }

        .error-list {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            @include('admin.partials.header')

            <div class="page-header">
                <h2 class="title">Sửa bình luận #{{ $comment->id }}</h2>
            </div>

            <section class="comment-form">

                @if ($errors->any())
                    <div class="error-list">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label for="user_id">Người dùng</label>
                    <select name="user_id" id="user_id" required>
                        <option value="">-- Chọn người dùng --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ ($comment->user_id == $user->id) ? 'selected' : '' }}>
                                {{ $user->username }}
                            </option>
                        @endforeach
                    </select>

                    <label for="news_id">Tin tức liên quan</label>
                    <select name="news_id" id="news_id" required>
                        <option value="">-- Chọn tin tức --</option>
                        @foreach ($news as $item)
                            <option value="{{ $item->id }}" {{ ($comment->news_id == $item->id) ? 'selected' : '' }}>
                                {{ $item->tieude }}
                            </option>
                        @endforeach
                    </select>

                    <label for="noidung">Nội dung bình luận</label>
                    <textarea name="noidung" id="noidung" rows="5" required>{{ old('noidung', $comment->noidung) }}</textarea>

                    <button type="submit" class="btn btn-primary">Cập nhật bình luận</button>
                    <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">Hủy</a>
                </form>

            </section>
        </main>
    </div>
</body>
</html>
