<!-- resources/views/admin/categories/create.blade.php -->
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
                <h2 class="title">Thêm thể loại mới</h2>
            </div>

            <section class="category-form">
                <h3>Thêm thể loại</h3>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <label for="category-name">Tên thể loại</label>
                    <input type="text" id="category-name" name="tentheloai" placeholder="Nhập tên thể loại" required>
                    <button type="submit">Thêm</button>
                </form>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
