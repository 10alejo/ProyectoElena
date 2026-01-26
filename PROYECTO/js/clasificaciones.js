document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('rankingsContainer');
    if (!container) return;

    fetch('../php/obtener_clasificaciones.php')
        .then(response => response.json())
        .then(data => {
            renderRankings(data);
        })
        .catch(() => {
            container.innerHTML = '<p class="error">Error al conectar con la base de datos.</p>';
        });
});

function renderRankings(data) {
    const container = document.getElementById('rankingsContainer');
    container.innerHTML = ''; 

    const ejercicios = {
        'pressbanca': 'PRESS BANCA',
        'sentadilla': 'SENTADILLA',
        'pesomuerto': 'PESO MUERTO'
    };

    for (const key in ejercicios) {
        let lista = data[key] || [];
        while (lista.length < 5) {
            lista.push({ nombre: "Sin registro", peso: 0 });
        }

        // Estructura para las tarjetas paralelas
        let html = `
            <div class="ranking-card">
                <h3>${ejercicios[key]}</h3>
                <div class="rank-list">`;
        
        lista.forEach((atleta, index) => {
            html += `
                <div class="rank-item">
                    <span class="rank-name">${index + 1}º ${atleta.nombre}</span>
                    <span class="rank-val">${atleta.peso} kg</span>
                </div>`;
        });

        html += `</div></div>`;
        container.innerHTML += html;
    }
}