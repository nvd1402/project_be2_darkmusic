<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
</head>
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
            <h2 class="title">Quản lý quảng cáo</h2>
        </div>
        <section class="song-list">
            <h2 class="title" style="margin-top: -50px">Danh sách quảng cáo</h2>

            <div class="add-btn">
                    <a href="{{ route('admin.ad.create') }}">Thêm quảng cáo</a>
            </div>
            <table class="song-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên quảng cáo</th>
                    <th>Tiêu đề quảng cáo</th>
                    <th>Media</th>
                    <th>Link</th>
                    <th>On/Off</th>
                    <th>Miêu tả</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $ads as $ad )
                    <tr>
                        <td> {{ $ad->id }}</td>
                        <td>{{ $ad->name }}</td>
                        <td>{{ $ad->content }}</td>
                        <td>
                        @if (Storage::disk('public')->exists($ad->media_type))
                            <img src="{{ asset('storage/' . $ad->media_type) }}" width="300" height="100"  >
                        @else
                            <p>Ảnh không tồn tại</p>
                        @endif
                        </td>
                        <td>
                            <a href="{{ $ad->link_url }}" target="_blank" >
                            {{ parse_url($ad->link_url, PHP_URL_HOST) }}
                        </a>
                        </td>
                        <td>
                            {{ $ad->is_active ? '✅' : '❌' }}
                        </td>
                        <td>{{ $ad->description }}</td>
                        <td>
                                <a href="{{ route('admin.ad.edit', $ad) }}" class="btn edit">Sửa</a>
                                <form action="{{ route('admin.ad.destroy', $ad->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn delete" onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại này?')">Xóa</button>
                                </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </section>
    </main>
</div>
<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
