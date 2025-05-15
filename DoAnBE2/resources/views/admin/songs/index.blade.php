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
                <h2 class="title">Quản lý bài hát</h2>
            </div>
            <section class="song-list">
                <h2 class="title" style="margin-top: -50px">Danh sách bài hát</h2>
                <div class="add-btn">
                    <a href="{{ route('admin.songs.create') }}">Thêm mới</a>
                </div>

                @livewire('search-songs');
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    </body>

    </html>
