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
            <h2 class="newTitle">Quản lý quảng cáo</h2>
        </div>
        <section class="song-list">
            <h2 class="newTitle" style="margin-top: -100px">Danh sách quảng cáo</h2>

            <div class="add-btn">
                    <a href="{{ route('admin.ad.create') }}">Thêm quảng cáo</a>
            </div>

            @livewire('search-ads')

        </section>
    </main>
</div>
<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
