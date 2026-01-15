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