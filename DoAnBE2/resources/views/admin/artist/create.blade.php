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

            <form action="{{ route('admin.artist.post.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="name_artist">Nhập tên nghệ sĩ</label>
                    <input type="text"  placeholder="Name Artist" class="form-control" name="name_artist"
                        required>
                    @error('name_artist')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="category_id">Chọn thể loại âm nhạc</label>
                    <select id="category_id" name="category_id" required>
                        <option value="" style="display: none;">Chọn thể loại âm nhạc</option>
                        @foreach ( $categories as $category )
                            <option value="{{ $category->id }}">{{ $category->tentheloai }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="image_artist">Ảnh đại diện</label>
                    <input id="image_artist" type="file" name="image_artist">
                    @error('image_artist')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
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
