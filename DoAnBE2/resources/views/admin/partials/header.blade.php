<header>
    <!-- Profile -->

    <div class="profile">
        <div class="user">

        </div>
        <div class="d-flex align-items-center">

            @auth
                <a href="{{ route('profile') }}" class="text-decoration-none me-3">
                    <div class="user d-flex align-items-center">
                        <div class="left me-2">
                            <img src="{{ Auth::user()->avatar
                        ? asset('storage/'.Auth::user()->avatar)
                        : '/default-avatar.png'
                    }}"
                                 alt="avatar"
                                 class="rounded-circle"
                                 width="40">
                        </div>
                        <div class="right">
                            <h5 class="mb-0">{{ Auth::user()->username }}</h5>
                        </div>
                    </div>
                </a>


            @endauth
        </div>
    </div>
</header>


