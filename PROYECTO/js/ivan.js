// 1. OBTENER EL USUARIO DEL PERFIL
const usuario = typeof usuarioPerfil !== 'undefined' ? usuarioPerfil : "ivan"; 
const form = document.getElementById("pesoForm");
const es_el_dueno = form !== null; 

const ctx = document.getElementById("pesoChart").getContext("2d");
const pesoChart = new Chart(ctx, {
    type: "bar",
    data: { 
        labels: [], 
        datasets: [{ 
            data: [], 
            backgroundColor: [
                '#ff8c00', 
                '#e67e00', 
                '#cc7000', 
                '#b36200', 
                '#995400'
            ]
        }] 
    },
    options: { 
        responsive: true, 
        scales: { y: { beginAtZero: true } }, 
        plugins: { legend: { display: false } } 
    }
});

const ejercicios = ["pressbanca", "sentadilla", "pesomuerto", "pressmilitar", "dominadaslastradas"];

// 2. CARGAR DATOS (SIEMPRE DESDE LA BASE DE DATOS)
async function cargarDatos() {
    let labels = [];
    let values = [];

    try {
        const res = await fetch(`../php/obtener_datos.php?user=${usuario}`);
        const datosServidor = await res.json();

        if (Array.isArray(datosServidor) && datosServidor.length > 0) {
            ejercicios.forEach(ej => {
                // Buscamos el ejercicio limpiando espacios y pasando a minúsculas
                const registro = datosServidor.find(d => 
                    d.ejercicio.toLowerCase().trim() === ej.toLowerCase().trim()
                );
                
                if (registro) {
                    labels.push(ej);
                    values.push(parseFloat(registro.peso));
                }
            });
        }
    } catch (err) {
        console.error("Error al conectar con la base de datos");
    }

    // Actualizamos el gráfico
    pesoChart.data.labels = labels;
    pesoChart.data.datasets[0].data = values;
    pesoChart.update();
}

// 3. LOGICA DE GUARDADO (SOLO PARA EL DUEÑO)
if (es_el_dueno) {
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        
        try {
            const response = await fetch('../php/guardar_peso.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.status === "success") {
                await cargarDatos(); // Refresca el gráfico tras guardar
                form.reset();
            } else {
                alert("Error: " + data.message);
            }
        } catch (err) {
            console.error("Error de red al guardar");
        }
    });
}

// Carga inicial
cargarDatos();