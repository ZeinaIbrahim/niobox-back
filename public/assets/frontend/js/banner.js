const slider = document.querySelector(".slider");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");
let currentIndex = 0;
const intervalTime = 3000;
function updateSliderPosition() {
    const offset = -currentIndex * 100;
    slider.style.transform = `translateX(${offset}%)`;
}
prevBtn.addEventListener("click", () => {
    if (currentIndex > 0) {
        currentIndex--;
    } else {
        currentIndex = slider.children.length - 1;
    }
    updateSliderPosition();
});
nextBtn.addEventListener("click", () => {
    if (currentIndex < slider.children.length - 1) {
        currentIndex++;
    } else {
        currentIndex = 0;
    }
    updateSliderPosition();
});

setInterval(() => {
    if (currentIndex < slider.children.length - 1) {
        currentIndex++;
    } else {
        currentIndex = 0;
    }
    updateSliderPosition();
}, intervalTime);
