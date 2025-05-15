<!DOCTYPE html>
<html lang="en">
<head>@include('frontend.partials.head') </head>
<body>
    @if($ads->count())
    <div class="banner-wrapper">
        <div class="banner-container">
                @forelse ($ads as $index => $ad)
                <div class="banner-slide {{ $index === 0 ? 'active' : '' }}">
                @php
                    $ext = pathinfo($ad->media_type, PATHINFO_EXTENSION);
                @endphp

                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                    <a href="{{ $ad->link_url }}" target="_blank">
                        <img src="{{ asset('storage/' . $ad->media_type) }}" class="image-ad card-img-top" alt="Banner {{ $index + 1 }}">
                    </a>
                @endif
                </div>
                @empty
                    <p>Không có quảng cáo nào.</p>
                @endforelse
            </div>
        </div>
    @endif
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
        <!-- Trending -->
        <div class="trending">
            <div class="left">
                <h5>Trending New Song</h5>
                <div class="info">
                    <h2>Lost Emotions</h2>
                    <h4>Rion Clarke</h4>
                    <h5>63 Million Plays</h5>
                    <div class="buttons-action">
                        <button class="listen">Listen Now</button>
                        <button class="stop">Stop Now</button>
                        <i class='bx bxs-heart' ></i>
                        <i class='bx bx-heart'></i>
                    </div>
                </div>
            </div>
            <div class="waves">
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
            </div>
            <div class="left-img">
                <!-- <img src="assets/trend.png" style="height: 200px; width: 300px;" alt=""> -->
            </div>

        </div>
        <!-- Playlist -->
        <div class="playlist">
            <!-- Music genres -->
            <div class="genres">
                <div class="header">
                    <h5>Genres</h5>
                    <a> See all </a>
                </div>

                <div class="items">
                    <div class="item pop">
                        <p>Electro Pop</p>
                        <div class="music-items__list">

                        </div>
                    </div>

                    <div class="item beat">
                        <p>Dance Beat</p>
                        <div class="music-items__list">

                        </div>
                    </div>

                    <div class="item remix">
                        <p>Clubhouse Remix</p>
                        <div class="music-items__list">

                        </div>
                    </div>

                    <div class="item rap">
                        <p>Hip Hop Rap</p>
                        <div class="music-items__list">

                        </div>
                    </div>

                    <div class="item indie">
                        <p>Alternative Indie</p>
                        <div class="music-items__list">

                        </div>
                    </div>

                    <div class="item period">
                        <p>Classical Period</p>
                        <div class="music-items__list">

                        </div>
                    </div>
                </div>
            </div>

            <!-- List music -->
            <div class="music-list">
                <div class="header">
                    <h5>Top Songs</h5>
                    <a>See all </a>
                </div>

                <div class="music-items">

                </div>
            </div>

        </div>

    </main>


    @include('frontend.partials.right_content')
</div>
</div>

<script type='text/javascript' src="{{ asset('assets/frontend/js/script.js') }}"></script>
<script src="{{ asset('assets/frontend/js/handle-ad.js') }}"></script>
</body>
</html>
