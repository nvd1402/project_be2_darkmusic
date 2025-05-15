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

            <form action="{{ route('admin.artist.post.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <input name="id" type="hidden" value="{{ $artist->id }}">
                <div class="form-group mb-3">
                    <label for="name_artist">Tên nghệ sĩ</label>
                    <input type="text"  placeholder="Name Artist" class="form-control" name="name_artist"
                        required autofocus value="{{ $artist->name_artist }}">
                </div>
                <div class="form-group mb-3">
                    <label for="category_id">Thể loại âm nhạc</label>
                    <select id="category_id" name="category_id" required >
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $artist->category_id == $category->id ? 'selected' : '' }}>{{ $category->tentheloai }}</option>
                        @endforeach
                    </select>
                </div>

                 {{-- Hình ảnh hiện tại --}}
                <div class="form-group">
                    <label>Ảnh hiện tại:</label><br>
                   <td>
                        @if (Storage::disk('public')->exists('artists/' . $artist->image_artist))
                            <img src="{{ asset('storage/artists/' . $artist->image_artist) }}" width="50" >
                        @else
                            <p>Ảnh không tồn tại</p>
                        @endif
                        </td>
                </div>

                {{-- Upload ảnh mới --}}
                <div class="form-group">
                    <label for="image_artist">Ảnh mới (tùy chọn):</label>
                    <input type="file" name="image_artist" class="form-control">
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
