<div>
    <div class="search-artist">
        <input type="text" wire:model.live.debounce.500ms="query" placeholder="Search ads" class="search-artist">

        <select wire:model.live="state" class="search-select" >
            <option value="all">On/Off</option>
            <option value="1">On</option>
            <option value="0">Off</option>
        </select>
    </div>  

    <table class="song-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên quảng cáo</th>
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
</div>
