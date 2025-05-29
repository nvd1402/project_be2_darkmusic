<!DOCTYPE html>
<html lang="en">
<head>@include('admin.partials.head')</head>
<body>
<div class="container">
    <!--include file sidebar-->
    @include('admin.partials.sidebar')
    <main>
        <!--include file header-->
        @include('admin.partials.header')
        <!-- **********************************************CONTENT***************************************************-->
        <h1 class="title" style="margin-left: 100px; font-size:3em;">Admin</h1>
        <!-- box -->
        <div class="flex-container">
            <!-- box 1-->
            <a href="{{ route('admin.users.index') }}"  class="boxPageAdmin">
                <div class="admininfo">
                    <i class="bi bi-person-circle icon"></i>
                    <h2>Người dùng</h2>
                </div>
                <div class="admincount">
                    <i class="bi bi-list-ol icon"></i>
                    <h4>Tổng số lượng người dùng: <span>{{ $soluongnguoidung ?? '#' }}</span></h4>
                </div>
            </a>
            <!-- box 2-->
            <a href="{{ route('admin.songs.index') }}" class="boxPageAdmin">
                <div class="admininfo">
                    <i class="bi bi-file-music icon"></i>
                    <h2>Bài hát</h2>
                </div>
                <div class="admincount">
                    <i class="bi bi-music-note-list icon"></i>
                    <h4>Tổng số lượng bài hát: <span>{{ $soLuongBaiHat ?? '#'}}</span></h4>
                </div>
            </a>
            <!-- box 3-->
            <a href="{{ route('admin.album.index') }}" class="boxPageAdmin">
                <div class="admininfo">
                    <i class="bi bi-journal-album icon"></i>
                    <h2>Album</h2>
                </div>
                <div class="admincount">
                    <i class="bi bi-music-note-list icon"></i>
                                        <h4>Tổng số lượng tin tức: <span>{{ $soluongalbum ?? '#'}}</h4>

                </div>
            </a>
            <!-- box 4-->
            <a href="{{ route('admin.categories.index') }}#" class="boxPageAdmin">
                <div class="admininfo">
                    <i class="bi bi-tags icon"></i>

                    <h2>Thể loại</h2>
                </div>
                <div class="admincount">
               <i class="bi bi-list-ul icon"></i>


                    <h4>Tổng số lượng thể loại: <span>{{ $soluongtheloai ?? '#' }}</span></h4>
                </div>
            </a>
            <!-- box 5-->
            <a href="{{ route('admin.artist.index') }}" class="boxPageAdmin">
                <div class="admininfo">
                    <i class="bi bi-person-bounding-box icon"></i>
                    <h2>Nghệ sĩ</h2>
                </div>
                <div class="admincount">
                    <i class="bi bi-person-lines-fill icon"></i>
                    <h4>Tổng số lượng nghệ sĩ: <span>{{ $soluongnghesi ?? '#' }}</span></h4>
                </div>
            </a>
            <!-- box 6-->
            <a href="#" class="boxPageAdmin">
                <div class="admininfo">
                    <i class="bi bi-badge-ad icon"></i>
                    <h2>Quảng cáo</h2>
                </div>
                <div class="admincount">
                    <i class="bi bi-view-list icon"></i>
                    <h4>Tổng số lượng quảng cáo: <span>{{ $soluongquangcao ?? '#' }}</span></h4>
                </div>
            </a>
            <!-- box 7-->
            <a href="{{ route('admin.news.index') }}" class="boxPageAdmin">
                <div class="admininfo">
                    <i class="bi bi-newspaper icon"></i>
                    <h2>Tin tức</h2>
                </div>
                <div class="admincount">
                    <i class="bi bi-view-list icon"></i>
                  <h4>Tổng số lượng tin tức: <span>{{ $soluongtintuc ?? '#' }}</span></h4>

                </div>
            </a>
                     <a href="{{ route('admin.comments.index') }}" class="boxPageAdmin">
    <div class="admininfo">
        <!-- icon bình luận (bi-chat-left-text) -->
        <i class="bi bi-chat-left-text icon"></i>
        <h2>Bình Luận</h2>
    </div>
    <div class="admincount">
        <!-- icon thống kê danh sách (bi-list-check) -->
        <i class="bi bi-list-check icon"></i>
        <h4>Tổng số lượng bình luận: <span>{{ $soluongcomment ?? '#' }}</span></h4>
    </div>
</a>


        </div>
    </main>
        </div>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
