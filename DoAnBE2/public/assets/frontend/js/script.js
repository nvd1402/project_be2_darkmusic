//ducanh

document.addEventListener('DOMContentLoaded', function() {
    const playPauseButtons = document.querySelectorAll('.play-pause-button');
    const trendingWaves = document.querySelectorAll('.trending .waves .wave'); // Lấy các sóng âm thanh của trending

    // Khởi tạo trạng thái sóng ban đầu là 'paused' cho bài trending khi tải trang
    trendingWaves.forEach(wave => wave.classList.add('paused'));


    playPauseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const audioId = this.dataset.audioId;
            const audio = document.getElementById(audioId);
            const icon = this.querySelector('i');
            const durationSpan = this.nextElementSibling; // Span hiển thị thời lượng

            if (audio.paused) {
                // Dừng tất cả các bài hát khác đang phát
                document.querySelectorAll('audio').forEach(otherAudio => {
                    if (otherAudio !== audio && !otherAudio.paused) {
                        otherAudio.pause();
                        // Cập nhật icon của các nút play/pause trong danh sách đề xuất
                        const otherPlayButtonIcon = document.querySelector(`[data-audio-id="${otherAudio.id}"] i`);
                        if (otherPlayButtonIcon) {
                            otherPlayButtonIcon.classList.remove('fa-pause');
                            otherPlayButtonIcon.classList.add('fa-play');
                        }

                        // Nếu bài hát đang dừng là bài trending, dừng animation sóng
                        if (otherAudio.id === 'trending-audio') {
                            trendingWaves.forEach(wave => wave.classList.add('paused'));
                        }
                    }
                });

                audio.play();
                icon.classList.remove('fa-play');
                icon.classList.add('fa-pause');

                // Nếu bài hát đang phát là bài trending, khởi động animation sóng
                if (audio.id === 'trending-audio') {
                    trendingWaves.forEach(wave => wave.classList.remove('paused'));
                }

            } else { // Nếu bài hát đang phát
                audio.pause();
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-play');

                // Nếu bài hát đang dừng là bài trending, dừng animation sóng
                if (audio.id === 'trending-audio') {
                    trendingWaves.forEach(wave => wave.classList.add('paused'));
                }
            }

            // Cập nhật thời lượng khi audio meta đã load
            // Thêm cờ để đảm bảo listener chỉ được thêm một lần
            if (!audio.dataset.loadedmetadataListenerAdded) {
                audio.addEventListener('loadedmetadata', function() {
                    const duration = audio.duration;
                    const minutes = Math.floor(duration / 60);
                    const seconds = Math.floor(duration % 60);
                    durationSpan.textContent = `0:00 / ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                });
                audio.dataset.loadedmetadataListenerAdded = true;
            }

            // Cập nhật thời gian hiện tại khi đang phát
            // Thêm cờ để đảm bảo listener chỉ được thêm một lần
            if (!audio.dataset.timeupdateListenerAdded) {
                audio.addEventListener('timeupdate', function() {
                    const currentTime = audio.currentTime;
                    const duration = audio.duration;

                    const currentMinutes = Math.floor(currentTime / 60);
                    const currentSeconds = Math.floor(currentTime % 60);

                    const totalMinutes = Math.floor(duration / 60);
                    const totalSeconds = Math.floor(duration % 60);

                    durationSpan.textContent =
                        `${currentMinutes}:${currentSeconds < 10 ? '0' : ''}${currentSeconds} / ` +
                        `${totalMinutes}:${totalSeconds < 10 ? '0' : ''}${totalSeconds}`;
                });
                audio.dataset.timeupdateListenerAdded = true;
            }

            // Đặt lại icon và animation sóng khi bài hát kết thúc
            // Thêm cờ để đảm bảo listener chỉ được thêm một lần
            if (!audio.dataset.endedListenerAdded) {
                audio.addEventListener('ended', function() {
                    icon.classList.remove('fa-pause');
                    icon.classList.add('fa-play');
                    durationSpan.textContent = `0:00 / ${Math.floor(audio.duration / 60)}:${Math.floor(audio.duration % 60) < 10 ? '0' : ''}${Math.floor(audio.duration % 60)}`;

                    if (audio.id === 'trending-audio') {
                        trendingWaves.forEach(wave => wave.classList.add('paused'));
                    }
                });
                audio.dataset.endedListenerAdded = true;
            }
        });
    });
});





//kha
const menuOpen = document.getElementById("menu-open");
const menuClose = document.getElementById("menu-close");
const sidebar = document.querySelector(".container .sidebar");
document.addEventListener("DOMContentLoaded", function () {
    const lyricsButton = document.querySelector(".lyrics");
    const lyricsSong = document.querySelector(".lyrics-song");
    const lyrics = document.querySelector(".lyrics");
    const wave = document.querySelectorAll(".waves .wave");
    const listener = document.querySelector(".buttons-action");
    const playering = document.querySelector(".btn-toggle-play");
    const paused = document.querySelectorAll(".waves .wave.paused");
    const musiclist = document.querySelector(".music-items");
    lyricsButton.addEventListener("click", function () {
        lyricsSong.classList.toggle("hidden");
        lyrics.classList.toggle("hidden-player");
    });
    function expandWave() {
        wave.forEach(function (element) {
            element.style.width = "6px";
            paused.forEach(function (element) {
                element.classList.toggle("paused");
            });
        });
    }
    // musiclist.addEventListener('click', expandWave);
    listener.addEventListener("click", expandWave);
    playering.addEventListener("click", expandWave);
    musiclist.forEach(function (item) {
        item.addEventListener("click", expandWave);
    });
});

menuOpen.addEventListener("click", () => (sidebar.style.left = "0"));
menuClose.addEventListener("click", () => (sidebar.style.left = "-100%"));

// Các bước cần thực hiện
/**
 * 1. Render songs
 * 2. Scroll top
 * 3. Play / pause/ seek
 * 4. CD rotate
 * 5. Next / prev
 * 6. Random
 * 7. Next / Repeat when ended
 * 8. Active song
 * 9. Scroll active song into view
 * 10. Play song when click
 */

// Javascript Music

const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const PlAYER_STORAGE_KEY = "Hun";

const player = $(".container");
// const cd = $('.right-section .music-player .top-section .song-info .cd');
// const heading = $('.right-section .music-player .top-section .song-info .description h3');
// const cdThumb = $('.right-section .music-player .top-section .song-info .cd .cd-thumb');
const cd = $(".cd");
const heading = $(".description h3");
const cdThumb = $(".cd-thumb");
const audio = $("#audio");
const playBtn = $(".btn-toggle-play");
const progress = $("#progress");
const prevBtn = $(".btn-prev");
const nextBtn = $(".btn-next");
const randomBtn = $(".btn-random");
const repeat = $(".btn-repeat");
const repeatBtn = $(".bx-repeat");
const atomBtn = $(".bx-atom");
const playlist = $(".music-items");
const leftimg = $(".left-img");
const playlisten = $(".buttons-action");
const righting = $(".info h4");
const icon = $(".icon");
const currentTime = $(".time-end");
const duration = $(".time-start");
const volume = $(".volumne");
const volumeProgress = $(".volumne__amount");
const mute = $(".bxs-volume-full");
const unmute = $(".bxs-volume-mute");
const songname = $(".lyrics-song__name");
const lyricsong = $(".lyrics-songs");
// list music
const items = $(".items");
const pop = $(".item.pop");
const poplist = $(".item.pop .music-items__list");
// const popSongs = [];
const beat = $(".item.beat");
const beatlist = $(".item.beat .music-items__list");
const remix = $(".item.remix");
let beatSongs = [];
let popSongs = [];
let remixSongs = [];
let rapSongs = [];
let indieSongs = [];
let periodSongs = [];
const remixlist = $(".item.remix .music-items__list");
const rap = $(".item.rap");
const raplist = $(".item.rap .music-items__list");
const indie = $(".item.indie");
const indielist = $(".item.indie .music-items__list");
const period = $(".item.period");
const periodlist = $(".item.period .music-items__list");
const listmusic = $(".music-items__list");
const itemsgenre = $(".items .item");
const seeall = $(".genres .header a");

// console.log(playBtn);

const app = {
    currentIndex: 0,
    isPlaying: false,
    isRandom: false,
    isRepeat: false,
    isatom: false,
    volumeAmount: 1,
    isgenre: false,
    islistSelected: false, // Biến cờ xác định danh sách đang được chọn
    currentPlaylistState: { currentIndex: 0 }, // Trạng thái hiện tại của danh sách playlist

    config: JSON.parse(localStorage.getItem(PlAYER_STORAGE_KEY)) || {},

    songs: [

    ],

    setConfig: function (key, value) {
        this.config[key] = value;
        localStorage.setItem(PlAYER_STORAGE_KEY, JSON.stringify(this.config));
    },

    progressInput: function (item) {
        let sliderValue = item.value;
        item.style.background = `linear-gradient(to right, var(--color-theme) ${sliderValue}%, #4d4d4d ${sliderValue}%)`;
    },

    render: function () {
        const htmls = this.songs.map((song, index) => {
            return `
                <div class="item ${
                    index === this.currentIndex ? "active" : ""
                }" data-index="${index}">
                    <div class="info">
                        <img src="${song.image}" alt="">
                        <div class="details">
                            <h5>${song.name}</h5>
                            <p>${song.singer}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="icon">
                            <i class='bx bx-play' data-index="${index}"></i>
                            <i class='bx bx-pause' data-index="${index}"></i>
                        </div>
                        <i class='bx bxs-plus-square'></i>
                    </div>
                </div>
            `;
        });
        playlist.innerHTML = htmls.join("");
    },

    renderlistpop: function () {
        // Lọc danh sách các bài hát theo từng thể loại
        popSongs = this.songs.filter((song) => song.genre === "Pop");

        //Tạo HTML cho danh sách các bài hát theo từng thể loại
        const popHtmls = popSongs.map((song, index) => {
            return `
                <div class="itemlist ${
                    index === this.currentIndex ? "active" : ""
                }" data-index="${index}">
                    <div class="info">
                        <img src="${song.image}" alt="">
                        <div class="details">
                            <h5>${song.name}</h5>
                            <p>${song.singer} - ${song.genre}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="icon">
                            <i class='bx bx-play' data-index="${index}"></i>
                            <i class='bx bx-pause' data-index="${index}"></i>
                        </div>
                    </div>
                </div>
            `;
        });
        // const poplist = document.querySelector('.item.pop .music-items__list');
        if (popHtmls.length > 0) {
            poplist.innerHTML = popHtmls.join("");
        } else {
            poplist.innerHTML = "<p>No songs available</p>";
        }
    },

    renderlistbeat: function () {
        // Lọc danh sách các bài hát theo từng thể loại
        beatSongs = this.songs.filter((song) => song.genre === "Beat");

        //Tạo HTML cho danh sách các bài hát theo từng thể loại
        const beatHtmls = beatSongs.map((song, index) => {
            // Tạo HTML cho danh sách các bài hát thể loại 'Beat'
            return `
                <div class="itemlist ${
                    index === this.currentIndex ? "active" : ""
                }" data-index="${index}">
                    <div class="info">
                        <img src="${song.image}" alt="">
                        <div class="details">
                            <h5>${song.name}</h5>
                            <p>${song.singer} - ${song.genre}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="icon">
                            <i class='bx bx-play' data-index="${index}"></i>
                            <i class='bx bx-pause' data-index="${index}"></i>
                        </div>
                    </div>
                </div>
            `;
        });
        // const beatlist = document.querySelector('.item.beat .music-items__list');
        if (beatHtmls.length > 0) {
            beatlist.innerHTML = beatHtmls.join("");
        } else {
            beatlist.innerHTML = "<p>No songs available</p>";
        }
    },

    renderlistremix: function () {
        // Lọc danh sách các bài hát theo từng thể loại
        remixSongs = this.songs.filter((song) => song.genre === "Remix");

        //Tạo HTML cho danh sách các bài hát theo từng thể loại
        const remixHtmls = remixSongs.map((song, index) => {
            // Tạo HTML cho danh sách các bài hát thể loại 'Beat'
            return `
                <div class="itemlist ${
                    index === this.currentIndex ? "active" : ""
                }" data-index="${index}">
                    <div class="info">
                        <img src="${song.image}" alt="">
                        <div class="details">
                            <h5>${song.name}</h5>
                            <p>${song.singer} - ${song.genre}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="icon">
                            <i class='bx bx-play' data-index="${index}"></i>
                            <i class='bx bx-pause' data-index="${index}"></i>
                        </div>
                    </div>
                </div>
            `;
        });
        // const remixContainer = document.querySelector('.item.remix .music-items__list');
        if (remixHtmls.length > 0) {
            remixlist.innerHTML = remixHtmls.join("");
        } else {
            remixlist.innerHTML = "<p>No songs available</p>";
        }
    },

    renderlistrap: function () {
        // Lọc danh sách các bài hát theo từng thể loại
        rapSongs = this.songs.filter((song) => song.genre === "Rap");

        //Tạo HTML cho danh sách các bài hát theo từng thể loại
        const rapHtmls = rapSongs.map((song, index) => {
            // Tạo HTML cho danh sách các bài hát thể loại 'Beat'
            return `
                <div class="itemlist ${
                    index === this.currentIndex ? "active" : ""
                }" data-index="${index}">
                    <div class="info">
                        <img src="${song.image}" alt="">
                        <div class="details">
                            <h5>${song.name}</h5>
                            <p>${song.singer} - ${song.genre}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="icon">
                            <i class='bx bx-play' data-index="${index}"></i>
                            <i class='bx bx-pause' data-index="${index}"></i>
                        </div>
                    </div>
                </div>
            `;
        });
        // const remixContainer = document.querySelector('.item.remix .music-items__list');
        if (rapHtmls.length > 0) {
            raplist.innerHTML = rapHtmls.join("");
        } else {
            raplist.innerHTML = "<p>No songs available</p>";
        }
    },

    renderlistindie: function () {
        // Lọc danh sách các bài hát theo từng thể loại
        indieSongs = this.songs.filter((song) => song.genre === "Indie");

        //Tạo HTML cho danh sách các bài hát theo từng thể loại
        const indieHtmls = indieSongs.map((song, index) => {
            // Tạo HTML cho danh sách các bài hát thể loại 'Beat'
            return `
                <div class="itemlist ${
                    index === this.currentIndex ? "active" : ""
                }" data-index="${index}">
                    <div class="info">
                        <img src="${song.image}" alt="">
                        <div class="details">
                            <h5>${song.name}</h5>
                            <p>${song.singer} - ${song.genre}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="icon">
                            <i class='bx bx-play' data-index="${index}"></i>
                            <i class='bx bx-pause' data-index="${index}"></i>
                        </div>
                    </div>
                </div>
            `;
        });
        // const remixContainer = document.querySelector('.item.remix .music-items__list');
        if (indieHtmls.length > 0) {
            indielist.innerHTML = indieHtmls.join("");
        } else {
            indielist.innerHTML = "<p>No songs available</p>";
        }
    },

    renderlistperiod: function () {
        // Lọc danh sách các bài hát theo từng thể loại
        periodSongs = this.songs.filter((song) => song.genre === "Period");

        //Tạo HTML cho danh sách các bài hát theo từng thể loại
        const periodHtmls = periodSongs.map((song, index) => {
            // Tạo HTML cho danh sách các bài hát thể loại 'Beat'
            return `
                <div class="itemlist ${
                    index === this.currentIndex ? "active" : ""
                }" data-index="${index}">
                    <div class="info">
                        <img src="${song.image}" alt="">
                        <div class="details">
                            <h5>${song.name}</h5>
                            <p>${song.singer} - ${song.genre}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="icon">
                            <i class='bx bx-play' data-index="${index}"></i>
                            <i class='bx bx-pause' data-index="${index}"></i>
                        </div>
                    </div>
                </div>
            `;
        });
        // const remixContainer = document.querySelector('.item.remix .music-items__list');
        if (periodHtmls.length > 0) {
            periodlist.innerHTML = periodHtmls.join("");
        } else {
            periodlist.innerHTML = "<p>No songs available</p>";
        }
    },

    defineProperties: function () {
        let _this = this;
        // Định nghĩa currentSong
        Object.defineProperty(this, "currentSong", {
            get: function () {
                return this.songs[this.currentIndex];
            },
        });

        Object.defineProperty(this, "currentSongBeat", {
            get: function () {
                return beatSongs[_this.currentIndex];
            },
        });

        Object.defineProperty(this, "currentSongPop", {
            get: function () {
                return popSongs[_this.currentIndex];
            },
        });

        Object.defineProperty(this, "currentSongRemix", {
            get: function () {
                return remixSongs[_this.currentIndex];
            },
        });

        Object.defineProperty(this, "currentSongRap", {
            get: function () {
                return rapSongs[_this.currentIndex];
            },
        });

        Object.defineProperty(this, "currentSongIndie", {
            get: function () {
                return indieSongs[_this.currentIndex];
            },
        });

        Object.defineProperty(this, "currentSongPeriod", {
            get: function () {
                return periodSongs[_this.currentIndex];
            },
        });
    },

    // defineProperties: function(){
    //     Object.defineProperty(this,'currentSong',{
    //         get: function(){
    //             return this.songs[this.currentIndex];
    //         }
    //     });
    // },

    handleEvents: function () {
        let _this = this;
        const cdWidth = cd.offsetWidth;

        // Xử lý CD quay và dừng
        const cdThumbAnimate = cdThumb.animate(
            [{ transform: "rotate(360deg)" }],
            {
                duration: 10000, // 10 seconds
                iterations: Infinity,
            }
        );
        cdThumbAnimate.pause();

        //Xử lý phóng to / thu nhỏ
        document.onscroll = function () {
            const scrollTop =
                window.scrollY || document.documentElement.scrollTop;
            const newcdWidth = cdWidth - scrollTop;

            cd.style.width = newcdWidth > 0 ? newcdWidth + "px" : 0;
            cd.style.opacity = newcdWidth / cdWidth;

            // console.log(newcdWidth);
        };
        // Xử lý khi click vào cả hai nút play và listen
        function handlePlay() {
            if (_this.isPlaying) {
                audio.pause();
            } else {
                audio.play();
            }
        }

        playBtn.onclick = handlePlay;
        playlisten.onclick = handlePlay;
        // icon.onclick = handlePlay;

        //Khi hát được play
        audio.onplay = function () {
            _this.isPlaying = true;
            player.classList.add("playing");
            if (window.innerWidth <= 600) {
                cdThumbAnimate.play();
            } else {
                cdThumbAnimate.pause();
            }
        };
        //Khi song bi pause
        audio.onpause = function () {
            _this.isPlaying = false;
            player.classList.remove("playing");
            cdThumbAnimate.pause();
        };

        //khi tiến độ bài hát thay đổi
        audio.ontimeupdate = function () {
            if (audio.duration) {
                const progressPercent = Math.floor(
                    (audio.currentTime / audio.duration) * 100
                );
                progress.value = progressPercent;
            }
            updateUI();
        };

        //Xử lý khi tua song
        progress.oninput = function (e) {
            const seekTime = (audio.duration / 100) * e.target.value;
            audio.currentTime = seekTime;
        };

        // Xử lý time audio
        // Xác định sự kiện "loadedmetadata"
        audio.addEventListener("loadedmetadata", function () {
            // Đặt thời gian hiện tại của audio là 0 (bắt đầu từ đầu)
            audio.currentTime = 0;

            // Cập nhật giao diện người dùng dựa trên thời gian hiện tại mới
            updateUI();
        });

        // Hàm cập nhật giao diện người dùng
        function updateUI() {
            progress.value = Math.floor(audio.currentTime);
            progress.max = Math.floor(audio.duration);

            let secondCurrent = Math.floor(audio.currentTime) % 60;
            let minuteCurrent = Math.floor(Math.floor(audio.currentTime) / 60);
            let secondLeft =
                (Math.floor(audio.duration) - Math.floor(audio.currentTime)) %
                60;
            let minuteLeft = Math.floor(
                (Math.floor(audio.duration) - Math.floor(audio.currentTime)) /
                    60
            );

            let currentDuration, durationLeft;

            currentDuration =
                secondCurrent < 10
                    ? `${minuteCurrent}:0${secondCurrent}`
                    : `${minuteCurrent}:${secondCurrent}`;
            durationLeft =
                secondLeft < 10
                    ? `-${minuteLeft}:0${secondLeft}`
                    : `-${minuteLeft}:${secondLeft}`;

            currentTime.innerText = currentDuration;
            duration.innerText = durationLeft;
            progress.style.background = `linear-gradient(to right, var(--color-theme) ${
                (progress.value / progress.max) * 100
            }%, #4d4d4d ${(progress.value / progress.max) * 100}%)`;
        }

        //khi next song
        nextBtn.onclick = function () {
            if (_this.isRandom) {
                _this.playRandomSong();
            } else {
                _this.nextSong();
            }
            audio.play();
            _this.render();
            _this.scrollToActiveSong();
        };
        //khi prev song
        prevBtn.onclick = function () {
            if (_this.isRandom) {
                _this.playRandomSong();
            } else {
                _this.prevSong();
            }
            audio.play();
        };

        // Khi Random xu ly
        randomBtn.onclick = function (e) {
            _this.isRandom = !_this.isRandom;
            _this.setConfig("isRandom", _this.isRandom);
            randomBtn.classList.toggle("active", _this.isRandom);
        };
        let clickCount = 0;
        // Xử lý lặp lại bài hát
        repeat.onclick = function (e) {
            clickCount++;
            if (clickCount === 1) {
                // Lặp lại một bài hát
                _this.isRepeat = true;
                _this.isatom = false;
                _this.setConfig("isRepeat", _this.isRepeat);
                repeat.classList.add("active");
                repeatBtn.classList.add("active", _this.isRepeat);
            } else if (clickCount === 2) {
                // Lặp lại tất cả bài hát
                _this.isRepeat = false;
                _this.isatom = true;
                _this.setConfig("isatom", _this.isatom);
                repeatBtn.classList.remove("active");
                atomBtn.classList.add("active", _this.isatom);
            } else {
                // Trở lại trạng thái ban đầu
                _this.isRepeat = false;
                _this.isatom = false;
                clickCount = 0;
                repeat.classList.remove("active");
                repeatBtn.classList.remove("active", _this.isRepeat);
                atomBtn.classList.remove("active", _this.isatom);
            }
        };

        //Xử lý next song khi radio ended
        audio.onended = function () {
            if (_this.isRepeat) {
                audio.play();
            } else if (_this.isatom) {
                _this.nextSong();
                audio.play();
                _this.render();
                _this.scrollToActiveSong();
            } else {
                audio.click();
            }
        };

        //Xử lý volumn
        progress.oninput = function () {
            let sliderValue = progress.value;
            progress.style.background = `linear-gradient(to right, var(--color-theme) ${sliderValue}%, #4d4d4d ${sliderValue}%)`;
            audio.currentTime = progress.value;
        };

        volume.oninput = function () {
            let sliderValue = volume.value;
            volume.style.background = `linear-gradient(to right, var(--color-theme) ${sliderValue}%, #4d4d4d ${sliderValue}%)`;
        };

        mute.onclick = function () {
            audio.volume = 0;
            $(".playbar__volumne").classList.add("mute");
            volumeProgress.value = 0;
            volumeProgress.style.background = `linear-gradient(to right, var(--color-theme) ${0}%, #4d4d4d ${0}%)`;
        };

        unmute.onclick = function () {
            audio.volume = _this.volumeAmount;
            $(".playbar__volumne").classList.remove("mute");
            volumeProgress.value = _this.volumeAmount * 100;
            volumeProgress.style.background = `linear-gradient(to right, var(--color-theme) ${
                _this.volumeAmount * 100
            }%, #4d4d4d ${_this.volumeAmount * 100}%)`;
        };

        volumeProgress.onchange = function () {
            audio.volume = volumeProgress.value / 100;

            if (volumeProgress.value == 0) {
                if (!$(".playbar__volumne").classList.contains("mute")) {
                    $(".playbar__volumne").classList.add("mute");
                }
            } else {
                _this.volumeAmount = volumeProgress.value / 100;
                if ($(".playbar__volumne").classList.contains("mute")) {
                    $(".playbar__volumne").classList.remove("mute");
                }
            }
        };

        //Xử lý sự kiện click vào items pop
        pop.onclick = function () {
            if (!pop.classList.contains("active")) {
                _this.isgenre = true;
                _this.setConfig("isgenre", _this.isgenre);
                items.classList.add("active");
                pop.classList.add("active", _this.isgenre);
            }
        };
        //Xử lý sự kiện click vào items beat
        beat.onclick = function (e) {
            if (!beat.classList.contains("active")) {
                _this.isgenre = true;
                _this.setConfig("isgenre", _this.isgenre);
                items.classList.add("active");
                beat.classList.add("active", _this.isgenre);
            }
        };
        //Xử lý sự kiện click vào items remix
        remix.onclick = function (e) {
            if (!remix.classList.contains("active")) {
                _this.isgenre = true;
                _this.setConfig("isgenre", _this.isgenre);
                items.classList.add("active");
                remix.classList.add("active", _this.isgenre);
            }
        };
        //Xử lý sự kiện click vào items rap
        rap.onclick = function (e) {
            if (!rap.classList.contains("active")) {
                _this.isgenre = true;
                _this.setConfig("isgenre", _this.isgenre);
                items.classList.add("active");
                rap.classList.add("active", _this.isgenre);
            }
        };
        //Xử lý sự kiện click vào items indie
        indie.onclick = function (e) {
            if (!indie.classList.contains("active")) {
                _this.isgenre = true;
                _this.setConfig("isgenre", _this.isgenre);
                items.classList.add("active");
                indie.classList.add("active", _this.isgenre);
            }
        };
        //Xử lý sự kiện click vào items period
        period.onclick = function (e) {
            if (!period.classList.contains("active")) {
                _this.isgenre = true;
                _this.setConfig("isgenre", _this.isgenre);
                items.classList.add("active");
                period.classList.add("active", _this.isgenre);
            }
        };

        // Xử lý sự kiện click see all
        seeall.onclick = function () {
            items.classList.remove("active");
            pop.classList.remove("active", _this.isgenre);
            beat.classList.remove("active", _this.isgenre);
            rap.classList.remove("active", _this.isgenre);
            remix.classList.remove("active", _this.isgenre);
            indie.classList.remove("active", _this.isgenre);
            period.classList.remove("active", _this.isgenre);
        };

        // Lắng nghe hành vi click vào playlist
        playlist.addEventListener("click", function (e) {
            islistSelected = true;
            const songNode = e.target.closest(".item:not(.active)");
            if (songNode || !e.target.closest("info")) {
                //Xử lý click vào playlist
                if (songNode) {
                    _this.currentIndex = Number(songNode.dataset.index);
                    _this.loadCurrentSong();
                    _this.render();
                    audio.play();
                }
                // Xử lý khi click vào song option
                if (e.target.closest(".option")) {
                    // Code xử lý khi click vào song option
                }
            }
        });

        // Lắng nghe hành vi click vào listmusic pop
        poplist.addEventListener("click", function (e) {
            ispoplistSelected = true;
            islistSelected = false;
            isbeatlistSelected = false;
            isindielistSelected = false;
            isremixlistSelected = false;
            israplistSelected = false;
            isperiodlistSelected = false;
            const songpop = e.target.closest(".itemlist:not(.active)");
            if (songpop) {
                // Xử lý click vào danh sách pop
                const selectedIndex = Number(songpop.dataset.index);
                // Lấy bài hát từ danh sách pop đã lọc
                const selectedSong = popSongs[selectedIndex];
                _this.currentIndex = selectedIndex;
                _this.loadCurrentSong(selectedSong);
                _this.renderlistpop();
                audio.play();
            }
        });

        // Lắng nghe hành vi click vào listmusic beat
        beatlist.addEventListener("click", function (e) {
            isbeatlistSelected = true;
            islistSelected = false;
            ispoplistSelected = false;
            isindielistSelected = false;
            isremixlistSelected = false;
            israplistSelected = false;
            isperiodlistSelected = false;
            const songbeat = e.target.closest(".itemlist:not(.active)");
            if (songbeat) {
                //Xử lý click vào danh sách beat
                const selectedIndex = Number(songbeat.dataset.index);
                // Lấy bài hát từ danh sách beat đã lọc
                const selectedSong = beatSongs[selectedIndex];
                _this.currentIndex = selectedIndex;
                _this.loadCurrentSong(selectedSong);
                _this.renderlistbeat();
                audio.play();
            }
        });

        // Lắng nghe hành vi click vào listmusic remix
        remixlist.addEventListener("click", function (e) {
            isremixlistSelected = true;
            islistSelected = false;
            ispoplistSelected = false;
            isindielistSelected = false;
            isbeatlistSelected = false;
            israplistSelected = false;
            isperiodlistSelected = false;
            const songremix = e.target.closest(".itemlist:not(.active)");
            if (songremix) {
                //Xử lý click vào danh sách pop
                const selectedIndex = Number(songremix.dataset.index);
                const selectedSong = remixSongs[selectedIndex];
                _this.currentIndex = selectedIndex;
                _this.loadCurrentSong(selectedSong);
                _this.renderlistremix();
                audio.play();
            }
        });
        // Lắng nghe hành vi click vào listmusic rap
        raplist.addEventListener("click", function (e) {
            israplistSelected = true;
            isbeatlistSelected = false;
            islistSelected = false;
            ispoplistSelected = false;
            isindielistSelected = false;
            isremixlistSelected = false;
            isperiodlistSelected = false;
            const songrap = e.target.closest(".itemlist:not(.active)");
            if (songrap) {
                //Xử lý click vào danh sách pop
                const selectedIndex = Number(songrap.dataset.index);
                _this.currentIndex = selectedIndex;
                const selectedSong = rapSongs[selectedIndex];
                _this.loadCurrentSong(selectedSong);
                _this.renderlistrap();
                audio.play();
            }
        });
        // Lắng nghe hành vi click vào listmusic indie
        indielist.addEventListener("click", function (e) {
            isindielistSelected = true;
            isbeatlistSelected = false;
            islistSelected = false;
            ispoplistSelected = false;
            isremixlistSelected = false;
            israplistSelected = false;
            isperiodlistSelected = false;
            const songindie = e.target.closest(".itemlist:not(.active)");
            if (songindie) {
                //Xử lý click vào danh sách pop
                const selectedIndex = Number(songindie.dataset.index);
                _this.currentIndex = selectedIndex;
                const selectedSong = indieSongs[selectedIndex];
                _this.loadCurrentSong(selectedSong);
                _this.renderlistindie();
                audio.play();
            }
        });
        // Lắng nghe hành vi click vào listmusic Period
        periodlist.addEventListener("click", function (e) {
            isperiodlistSelected = true;
            isbeatlistSelected = false;
            islistSelected = false;
            ispoplistSelected = false;
            isindielistSelected = false;
            isremixlistSelected = false;
            israplistSelected = false;
            const songperiod = e.target.closest(".itemlist:not(.active)");
            if (songperiod) {
                //Xử lý click vào danh sách pop
                const selectedIndex = Number(songperiod.dataset.index);
                _this.currentIndex = selectedIndex;
                const selectedSong = periodSongs[selectedIndex];
                _this.loadCurrentSong(selectedSong);
                _this.renderlistperiod();
                audio.play();
            }
        });
    },

    // Kéo tới active song
    scrollToActiveSong: function () {
        setTimeout(() => {
            $(".song.active").scroollIntoView({
                behavior: "smooth",
                block: "end",
            });
        }, 500);
    },

    loadCurrentSong: function () {
        let currentSon;
        currentSon = this.currentSong;
        // Load bài đầu tiên
        do {
            heading.textContent = currentSon.name;
            cdThumb.style.backgroundImage = `url('${currentSon.image}')`;
            audio.src = currentSon.path;
            righting.textContent = currentSon.name;
            leftimg.style.backgroundImage = `url('${currentSon.image}')`;
            songname.textContent = currentSon.name;
            lyricsong.innerHTML = currentSon.lyrics;
        } while (!currentSon);
        if (islistSelected) {
            currentSon = this.currentSong;
        } else if (isbeatlistSelected) {
            currentSon = this.currentSongBeat;
        } else if (ispoplistSelected) {
            currentSon = this.currentSongPop;
        } else if (isremixlistSelected) {
            currentSon = this.currentSongRemix;
        } else if (israplistSelected) {
            currentSon = this.currentSongRap;
        } else if (isindielistSelected) {
            currentSon = this.currentSongIndie;
        } else if (isperiodlistSelected) {
            currentSon = this.currentSongPeriod;
        }
        console.log(currentSon);

        heading.textContent = currentSon.name;
        cdThumb.style.backgroundImage = `url('${currentSon.image}')`;
        audio.src = currentSon.path;
        righting.textContent = currentSon.name;
        leftimg.style.backgroundImage = `url('${currentSon.image}')`;
        songname.textContent = currentSon.name;
        lyricsong.innerHTML = currentSon.lyrics;
    },

    loadConfig: function () {
        this.isRandom = this.config.isRandom;
        this.isRepeat = this.config.isRepeat;
        this.config.isgenre = this.config.isgenre;
    },

    nextSong: function () {
        this.currentIndex++;
        if (this.currentIndex >= this.songs.length) {
            this.currentIndex = 0;
        }
        this.loadCurrentSong();
    },

    prevSong: function () {
        this.currentIndex--;
        if (this.currentIndex < 0) {
            this.currentIndex = this.songs.length - 1;
        }
        this.loadCurrentSong();
    },

    playRandomSong: function () {
        let newIndex;
        do {
            newIndex = Math.floor(Math.random() * this.songs.length);
        } while (newIndex === this.currentIndex);

        this.currentIndex = newIndex;
        this.loadCurrentSong();
    },

    start: function () {
        //Gán cấu hình vào config app
        this.loadConfig();

        // Định nghĩa thuộc tính cho Object
        this.defineProperties();

        // Lắng nghe sự kiện / Sử lý các sự kiện DOM events
        this.handleEvents();

        // Lấy ra bài hát
        this.render();

        // Lấy bài hát trong list music
        this.renderlistpop();
        this.renderlistbeat();
        this.renderlistremix();
        this.renderlistrap();
        this.renderlistindie();
        this.renderlistperiod();

        // Tải thông tin bài hát vào UI khi chạy ứng dụng
        this.loadCurrentSong();

        //Hiển thị trạng thái ban đầu của button repeat và random
        repeatBtn.classList.toggle("active", _this.isRepeat);
        randomBtn.classList.toggle("active", _this.isRandom);
        // itemsgenre.classList.toggle('active', _this.isgenre)
    },
};
app.start();
