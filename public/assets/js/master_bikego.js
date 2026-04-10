document.addEventListener('DOMContentLoaded', function() {
    // only initialize slider if slider exists
    const slider = document.getElementById('slider');
    if (!slider) return;

    let currentIndex = 0;
    const visibleSlides = 4;

    window.moveSlide = function(direction) {
        const slider = document.getElementById('slider');
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;

        currentIndex += direction;

        // bounds check
        if (currentIndex < 0) {
            currentIndex = 0;
        } else if (currentIndex > totalSlides - visibleSlides) {
            currentIndex = Math.max(0, totalSlides - visibleSlides);
        }

        const movePercentage = -(currentIndex * (100 / visibleSlides));
        slider.style.transform = `translateX(${movePercentage}%)`;
    };
});
