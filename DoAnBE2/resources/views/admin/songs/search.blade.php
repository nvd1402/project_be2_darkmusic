<header>
    <div class="nav-links">
        <button class="menu-btn" id="menu-open">
            <i class='bx bx-menu'></i>
        </button>
    </div>

    <!-- Form tìm kiếm -->
    <div class="search">
        <i class='bx bx-search'></i>

        <!-- tim kiem bai hat -->
        <form action="{{ route('admin.songs.search') }}" method="GET">
            <input type="text" name="query" placeholder="Tìm kiếm bài hát" value="{{ request()->query('query') }}">
        </form>

    </div>
</header>
