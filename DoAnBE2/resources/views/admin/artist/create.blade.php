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
            <h2 class="title">Thêm nghệ sĩ</h2>
        </div>
        <section class="add-song">

            <form action="{{ route('admin.artist.post.create') }}" method="post" >
                @csrf
                <div class="form-group mb-3">
                    <label for="name_artist">Nhập tên nghệ sĩ</label>
                    <input type="text"  placeholder="Name Artist" class="form-control" name="name_artist"
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="name_genre">Chọn thể loại âm nhạc</label>
                    <select id="name_genre" name="name_genre" required>
                        <option value="" style="display: none;">Chọn thể loại âm nhạc</option>
                        <option value="1">Nhạc trẻ</option>
                        <option value="2">Kpop</option>
                        <option value="3">Rap Việt</option>
                    </select>
                </div>
                <div class="d-grid mx-auto">
                    <button type="submit" class="btn--crud--artist">Thêm</button>
                </div>
            </form>
        </section>
    </main>
</div>
<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
