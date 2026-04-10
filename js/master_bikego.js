
    let currentIndex = 3;
    const slides = document.querySelectorAll('.slide');
    const slider = document.getElementById('slider');

    function updateSlides() {
        slides.forEach((slide, index) => {
            slide.classList.remove('active', 'near', 'far');

            let diff = Math.abs(index - currentIndex);

            if (index === currentIndex) {
                slide.classList.add('active');
            } else if (diff === 1) {
                slide.classList.add('near');
            } else {
                slide.classList.add('far');
            }
        });

        // Canh giữa
        const slideWidth = slides[0].offsetWidth + 26;
        slider.style.transform = `translateX(calc(50% - ${currentIndex * slideWidth}px))`;
    }

    function moveSlide(direction) {
        currentIndex += direction;

        if (currentIndex < 0) currentIndex = 0;
        if (currentIndex >= slides.length) currentIndex = slides.length - 1;

        updateSlides();
    }

    updateSlides();
