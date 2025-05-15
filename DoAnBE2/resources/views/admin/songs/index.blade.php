    <!DOCTYPE html>
    <html lang="en">

    <head>
        @include('admin.partials.head')
    </head>

    <body>

    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            <!--include file header-->
            @include('admin.partials.header')
{{--            @include('admin.songs.search')--}}

            <!--content-->
            <div>
                <h2 class="newTitle">Quản lý bài hát</h2>
            </div>
            <section class="song-list">
                <h2 class="newTitle" style="margin-top: -100px">Danh sách bài hát</h2>
                <div class="add-btn">
                    <a href="{{ route('admin.songs.create') }}">Thêm mới</a>
                </div>

                @livewire('search-songs')
            </section>
        </main>
    </div>

    <script type='text/javascript' src="{{ asset('assets/frontend/js/adminSong.js') }}"></script>
    </body>

    </html>
