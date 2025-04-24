<!DOCTYPE html>
<html lang="en">
<head>@include('admin.partials.head')</head>
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
            <h2 class="title ">Sữa nghệ sĩ</h2>
        </div>
        <section class="add-song">

            <form action="{{ route('admin.artist.post.update') }}" method="post" >
                @csrf

                <input name="id" type="hidden" value="{{ $artist->id }}">
                <div class="form-group mb-3">
                    <label for="name_artist">Tên nghệ sĩ</label>
                    <input type="text"  placeholder="Name Artist" class="form-control" name="name_artist"
                        required autofocus value={{ $artist->name_artist }}>
                </div>
                <div class="form-group mb-3">
                    <label for="name_genre">Thể loại âm nhạc</label>
                    <select id="name_genre" name="name_genre" required value={{ $artist->genre }}>
                        <option value="" style="display: none;">{{ $artist->genre }}</option>
                        <option value="1">Nhạc trẻ</option>
                        <option value="2">Kpop</option>
                        <option value="3">Rap Việt</option>
                    </select>
                </div>
                <div class="d-grid mx-auto">
                    <button type="submit" class="btn--crud--artist">Sữa</button>
                </div>
            </form>
        </section>
    </main>
</div>
<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
