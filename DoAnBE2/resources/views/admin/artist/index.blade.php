<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
</head>
<body>
    <div class="container">
     <!--include file sidebar-->
     @include('admin.partials.sidebar')
    <!-- phân chính -->
    <main>
        <!--include file header-->
    @include('admin.partials.header')
        <!--content-->
        <div>
            <h2 class="newTitle">Quản lý nghệ sĩ</h2>
        </div>

        <section class="song-list">
            <h2 class="newTitle" style="margin-top: -100px">Danh sách nghệ sĩ</h2>

            <div class="add-btn">
                    <a href="{{ route('admin.artist.create') }}">Thêm mới</a>
            </div>
                @livewire('search-artists')
                
        </section>
    </main>
</div>
<script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
