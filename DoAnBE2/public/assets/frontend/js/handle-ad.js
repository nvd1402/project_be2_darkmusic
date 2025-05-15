const slides = document.querySelectorAll(".banner-slide");
const container = document.querySelector(".banner-container");
const total = slides.length;
let current = 0;

let interval = setInterval(nextslide, 4000);

function nextslide() {
    slides[current].classList.remove("active");
    current = (current + 1) % total;
    slides[current].classList.add("active");
}

container.addEventListener("mouseenter", () => {
    clearInterval(interval);
});

container.addEventListener("mouseleave", () => {
    interval = setInterval(nextslide, 4000);
});
