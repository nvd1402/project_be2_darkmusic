<header>
    <div class="nav-links">
        <button class="menu-btn" id="menu-open">
            <i class='bx bx-menu'></i>
        </button>
    </div>

    <!-- Form tìm kiếm -->
    <div class="search">
        <i class='bx bx-search'></i>

        <!-- Tìm kiếm người dùng -->
        <form action="{{ route('admin.users.search') }}" method="GET">
            <input type="text" name="query" placeholder="Tìm kiếm người dùng" value="{{ request()->query('query') }}">
        </form>




    </div>
</header>
