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
            <h2 class="title">Tạo quảng cáo</h2>
        </div>
        <section class="add-song">

            <form action="{{ route('admin.ad.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Tên quảng cáo</label>
                    <input type="text"  placeholder="Name " class="form-control" name="name"
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="media_type">Ảnh hoặc video</label>
                    <input type="file"  placeholder="Image or Video" class="form-control" name="media_type"
                        required >
                        @if ($errors->has('media_type'))
                            <div class="text-danger">{{ $errors->first('media_type') }}</div>
                        @endif
                </div>
                <div class="form-group mb-3">
                    <label for="link_url">Link liên kết</label>
                    <input type="text"  placeholder="Link liên kết" class="form-control" name="link_url"
                        >
                </div>
                <div class="form-group mb-3">
                    <label for="is_active">On/Off</label>
                    <input type="checkbox" value="1" class="form-control" name="is_active" 
                        >
                </div>
                <div class="form-group mb-3">
                    <label for="description">Miêu tả quảng cáo</label>
                    <textarea name="description" id="" cols="80" rows="8" class="form-control"></textarea>
                </div>

                <div class="d-grid mx-auto">
                    <button type="submit" class="btn--crud--artist">Thêm</button>
                    <button type="reset" class="btn--crud--artist"><a href="{{ route('admin.ad.index') }}">Hủy</a></button>
                </div>
            </form>
        </section>
    </main>
</div>
<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
