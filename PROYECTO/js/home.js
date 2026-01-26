document.addEventListener('DOMContentLoaded', () => {

    /* --- 1. RELOJ DE OFERTA (HORAS, MINUTOS, SEGUNDOS) --- */
    // Solo funciona si existen los IDs 'h', 'm' y 's' (Página Home)
    const hDisp = document.getElementById('h');
    const mDisp = document.getElementById('m');
    const sDisp = document.getElementById('s');

    if (hDisp && mDisp && sDisp) {
        let h = 5, m = 17, s = 10;
        const offerInterval = setInterval(() => {
            if (s > 0) s--;
            else {
                if (m > 0) { m--; s = 59; }
                else {
                    if (h > 0) { h--; m = 59; s = 59; }
                    else clearInterval(offerInterval);
                }
            }
            hDisp.textContent = h.toString().padStart(2, '0');
            mDisp.textContent = m.toString().padStart(2, '0');
            sDisp.textContent = s.toString().padStart(2, '0');
        }, 1000);
    }

    /* --- 2. LÓGICA DEL SLIDER / CARRUSEL --- */
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    let slideIndex = 1;
    let slideInterval;

    // Solo arranca si hay diapositivas (mySlides)
    if (slides.length > 0) {
        showSlides(slideIndex);
        startAutoSlide();
    }

    function showSlides(n) {
        if (slides.length === 0) return;
        if (n > slides.length) { slideIndex = 1; }
        if (n < 1) { slideIndex = slides.length; }

        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }

        slides[slideIndex - 1].style.display = "block";
        if (dots.length > 0) dots[slideIndex - 1].className += " active";
    }

    function plusSlides(n) {
        showSlides(slideIndex += n);
        resetTimer();
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
        resetTimer();
    }

    function startAutoSlide() {
        slideInterval = setInterval(() => { plusSlides(1); }, 5000);
    }

    function resetTimer() {
        clearInterval(slideInterval);
        startAutoSlide();
    }

    // Exportamos funciones para que los botones HTML (onclick) las encuentren
    window.plusSlides = plusSlides;
    window.currentSlide = currentSlide;


    /* --- 3. TEMPORIZADOR DE SESIÓN (EL QUE TE FALLABA) --- */
    // Este funciona en CUALQUIER página que tenga el id 'session-timer'
    const timerContainer = document.getElementById('session-timer');
    const timerDisplay = document.getElementById('timer-display');

    if (timerContainer && timerDisplay) {
        let totalSeconds = parseInt(timerContainer.getAttribute('data-seconds'));

        if (!isNaN(totalSeconds) && totalSeconds > 0) {
            const sessionInterval = setInterval(() => {
                if (totalSeconds <= 0) {
                    clearInterval(sessionInterval);
                    window.location.href = "../php/logout.php";
                    return;
                }

                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;

                // Formato MM:SS que querías
                timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                totalSeconds--;
            }, 1000);
        }
    }
});