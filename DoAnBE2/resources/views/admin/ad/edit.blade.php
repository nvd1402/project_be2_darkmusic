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
            <h2 class="title">Edit Ad</h2>
        </div>
        <section class="add-song">

            <form action="{{ route('admin.ad.update', $ad) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <input type="hidden" value="{{ $ad->id }}" name="id">
                <div class="form-group mb-3">
                    <label for="name">Tên quảng cáo</label>
                    <input type="text"  placeholder="Name " class="form-control" name="name" value="{{ $ad->name }}"
                        >
                </div>

                <div class="form-group mb-3">
                    <label for="content_ad">Tiêu đề</label>
                    <input type="text"  placeholder="Title " class="form-control" name="content" value="{{ $ad->content }}"
                        >
                </div>
                <div class="form-group mb-3">
                    <label for="media_type">Ảnh hoặc video mới: </label>
                    <input type="file"  placeholder="Image or Video" class="form-control" name="media_type">
                </div>
                <div class="form-group mb-3">
                    <label for="link_url">Link liên kết</label>
                    <input type="text"  placeholder="Link liên kết" class="form-control" name="link_url" value="{{ $ad->link_url }}"
                        >
                </div>
                <div class="form-group mb-3">
                    <label for="is_active">On/Off Ad</label>
                    <input 
                    type="checkbox" 
                    class="form-control" 
                    name="is_active" 
                    value="1"
                    {{ old('is_active', $ad->is_active) ? 'checked' : '' }}
                        >
                </div>
                <div class="form-group mb-3">
                    <label for="description">Miêu tả quảng cáo</label>
                    <input type="text"  placeholder="Description" class="form-control" name="description" value="{{ $ad->description }}"
                        >
                </div>

                <div class="d-grid mx-auto">
                    <button type="submit" class="btn--crud--artist">Edit</button>
                </div>
            </form>
        </section>
    </main>
</div>
<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
