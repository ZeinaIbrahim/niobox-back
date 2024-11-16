const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (!isMobile) {
    const categoryScroll = document.querySelector(".category-scroll");
    const categoryItems = document.querySelectorAll(".category-item");
    let isDown = false;
    let scrollLeft;
    let isDragging = false;
    categoryScroll.addEventListener("mousedown", (e) => {
        isDown = true;
        isDragging = false;
        categoryScroll.classList.add("active");
        startX = e.pageX - categoryScroll.offsetLeft;
        scrollLeft = categoryScroll.scrollLeft;
    });
    categoryScroll.addEventListener("mouseleave", () => {
        isDown = false;
        categoryScroll.classList.remove("active");
    });
    categoryScroll.addEventListener("mouseup", (e) => {
        isDown = false;
        categoryScroll.classList.remove("active");
        if (isDragging) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
    categoryScroll.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - categoryScroll.offsetLeft;
        const walk = (x - startX) * 2;
        categoryScroll.scrollLeft = scrollLeft - walk;
        isDragging = true;
    });
    categoryItems.forEach((item) => {
        const img = item.querySelector("img");
        img.addEventListener("dragstart", (e) => {
            e.preventDefault();
        });
    });
}
