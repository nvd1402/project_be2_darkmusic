<!DOCTYPE html>
<html lang="en">
<head>@include('frontend.partials.head') </head>
<body>
<div class="container">
    <!-- Sidebar -->
    @include('frontend.partials.sidebar')
    <main>
        <!-- navLink -->
        <header>
            <div class="nav-links">
                <button class="menu-btn" id="menu-open">
                    <i class='bx bx-menu'></i>
                </button>
            </div>

            <div class="search">
                <i class='bx bx-search-alt-2'></i>
                <input type="text" placeholder="type here to search">
            </div>
        </header>

        

    </main>

    @include('frontend.partials.right_content')
</div>
</body>
</html>
