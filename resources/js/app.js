import './bootstrap';

// Navbar scroll
const navbar = document.getElementById('navbar');
const hasHero = document.querySelector('.hero');

if (navbar) {
    // Kalau tidak ada hero → langsung solid
    if (!hasHero) {
        navbar.style.background = 'rgba(26,26,24,0.97)';
        navbar.style.backdropFilter = 'blur(8px)';
    }

    window.addEventListener('scroll', () => {
        if (window.scrollY > 80) {
            navbar.style.background = 'rgba(26,26,24,0.97)';
            navbar.style.backdropFilter = 'blur(8px)';
        } else {
            if (hasHero) {
                navbar.style.background = 'transparent';
                navbar.style.backdropFilter = 'none';
            }
        }
    });
}

// Lookbook Carousel
document.addEventListener('DOMContentLoaded', () => {
    const track = document.getElementById('lookbookTrack');
    const dots = document.querySelectorAll('#lookbookDots span');
    if (!track || dots.length === 0) return;

    const totalSlides = dots.length;
    let current = 0;
    let isDragging = false;
    let startX = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let animationID;
    let autoplay;

    // Fungsi navigasi utama
    window.goToSlide = function(index) {
        current = index;
        prevTranslate = current * -100;
        setSliderPosition();
        updateDots();
    }

    function updateDots() {
        dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    function setSliderPosition() {
        track.style.transform = `translateX(${prevTranslate}%)`;
    }

    // Gerakan otomatis
    function startAutoplay() {
        stopAutoplay();
        autoplay = setInterval(() => {
            current = (current + 1) % totalSlides;
            prevTranslate = current * -100;
            track.style.transition = 'transform 0.8s cubic-bezier(0.25, 1, 0.5, 1)';
            setSliderPosition();
            updateDots();
        }, 4000);
    }

    function stopAutoplay() {
        clearInterval(autoplay);
    }

    // Logic Swipe / Drag
    function touchStart(e) {
        isDragging = true;
        startX = getPositionX(e);
        stopAutoplay();
        // Hilangkan transisi agar track menempel di jari tanpa delay
        track.style.transition = 'none'; 
    }

    function touchMove(e) {
        if (!isDragging) return;
        const currentX = getPositionX(e);
        const diff = ((currentX - startX) / window.innerWidth) * 100;
        currentTranslate = prevTranslate + diff;
        track.style.transform = `translateX(${currentTranslate}%)`;
    }

    function touchEnd() {
        if (!isDragging) return;
        isDragging = false;
        const movedBy = currentTranslate - prevTranslate;

        // Jika geser lebih dari 10% lebar layar, pindah slide
        if (movedBy < -10 && current < totalSlides - 1) current += 1;
        if (movedBy > 10 && current > 0) current -= 1;

        prevTranslate = current * -100;
        track.style.transition = 'transform 0.6s cubic-bezier(0.25, 1, 0.5, 1)';
        setSliderPosition();
        updateDots();
        startAutoplay();
    }

    function getPositionX(e) {
        return e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
    }

    // Event Listeners
    track.addEventListener('touchstart', touchStart);
    track.addEventListener('touchmove', touchMove);
    track.addEventListener('touchend', touchEnd);
    track.addEventListener('mousedown', touchStart);
    track.addEventListener('mousemove', touchMove);
    track.addEventListener('mouseup', touchEnd);
    track.addEventListener('mouseleave', touchEnd);

    // Jalankan awal
    startAutoplay();
});