let h = 5, m = 17, s = 10;

function updateTimer() {
    const hDisp = document.getElementById('h');
    const mDisp = document.getElementById('m');
    const sDisp = document.getElementById('s');

    const timer = setInterval(() => {
        if (s > 0) s--;
        else {
            if (m > 0) { m--; s = 59; }
            else {
                if (h > 0) { h--; m = 59; s = 59; }
                else clearInterval(timer);
            }
        }
        hDisp.textContent = h.toString().padStart(2, '0');
        mDisp.textContent = m.toString().padStart(2, '0');
        sDisp.textContent = s.toString().padStart(2, '0');
    }, 1000);
}
document.addEventListener('DOMContentLoaded', updateTimer);

let slideIndex = 1;
let slideInterval;

// Inicia el slider
showSlides(slideIndex);
startAutoSlide(); // Inicia la rotación automática

// Botones siguiente/anterior
function plusSlides(n) {
    showSlides(slideIndex += n);
    resetTimer(); // Reinicia el tiempo si el usuario toca las flechas
}

// Control por puntos
function currentSlide(n) {
    showSlides(slideIndex = n);
    resetTimer();
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }

    // Ocultar todas las slides
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    // Quitar clase active de los puntos
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    // Mostrar la slide actual
    slides[slideIndex - 1].style.display = "block";
    if (dots.length > 0) dots[slideIndex - 1].className += " active";
}

// Rotación automática cada 5 segundos
function startAutoSlide() {
    slideInterval = setInterval(function () {
        plusSlides(1);
    }, 5000);
}

function resetTimer() {
    clearInterval(slideInterval);
    startAutoSlide();
}

const timerContainer = document.getElementById('session-timer');
const timerDisplay = document.getElementById('timer-display');

if (timerContainer && timerDisplay) {
    // Leemos los segundos que PHP calculó para nosotros
    let totalSeconds = parseInt(timerContainer.getAttribute('data-seconds'));

    const countdown = setInterval(() => {
        if (totalSeconds <= 0) {
            clearInterval(countdown);
            window.location.href = "../php/logout.php";
            return;
        }

        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;

        timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

        totalSeconds--;
    }, 1000);
}