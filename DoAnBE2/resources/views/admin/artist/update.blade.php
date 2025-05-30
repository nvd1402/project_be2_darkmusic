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
            <h2 class="title ">Sửa nghệ sĩ</h2>
        </div>
        <section class="add-song">

            <form action="{{ route('admin.artist.post.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <input name="id" type="hidden" value="{{ $artist->id }}">
                <input type="hidden" name="original_updated_at" value="{{ $artist->updated_at }}">

                <div class="form-group mb-3">
                    <label for="name_artist">Tên nghệ sĩ</label>
                    <input type="text"  placeholder="Name Artist" class="form-control" @error('name_artist') is-invalid @enderror"
                            name="name_artist" id="name_artist"
                            value="{{ old('name_artist', $artist->name_artist) }}">
                   @error('name_artist')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="category_id">Thể loại âm nhạc</label>
                    <select id="category_id" name="category_id" required >
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $artist->category_id == $category->id ? 'selected' : '' }}>{{ $category->tentheloai }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

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

                <div class="form-group">
                    <label for="image_artist">Ảnh mới (tùy chọn):</label>
                    <input type="file" name="image_artist" class="form-control">
                    @error('image_artist')
                        <div class="text-danger">{{ $error }}</div>
                    @enderror
                </div>

                <div class="d-grid mx-auto">
                    <button type="submit" class="btn--crud--artist">Sửa</button>
                    <button type="reset" class="btn--crud--artist"><a href="{{ route('admin.artist.index') }}">Hủy</a></button>
                </div>
            </form>
        </section>
    </main>
</div>
</body>

</html>
