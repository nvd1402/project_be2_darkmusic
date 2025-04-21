<!-- resources/views/admin/categories/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            <!-- include file header -->
            @include('admin.partials.header')

            <!-- Content -->
            <div>
                <h2 class="title">Chỉnh sửa thể loại</h2>
            </div>

            <section class="category-form">
                <h3>Chỉnh sửa thể loại</h3>
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="category-name">Tên thể loại</label>
                    <input type="text" id="category-name" name="tentheloai" value="{{ $category->tentheloai }}" required>
                    <button type="submit">Cập nhật</button>
                </form>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
