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

async function cargarDatos() {

    let labels = [];
    let values = [];

    try {

        const res = await fetch(`../php/obtener_datos.php?user=${usuario}`);
        const datosServidor = await res.json();

        if (Array.isArray(datosServidor) && datosServidor.length > 0) {

            ejercicios.forEach(ej => {
        
                const registro = datosServidor.find(d => 
                    d.ejercicio.toLowerCase().trim() === ej.toLowerCase().trim()
                );
                
                if (registro) {

                    labels.push(ej);
                    values.push(parseFloat(registro.peso));
                }
            });
        }
    } 
    
    catch (err) {

        console.error("Error al conectar con la base de datos");
    }

    pesoChart.data.labels = labels;
    pesoChart.data.datasets[0].data = values;
    pesoChart.update();
}

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

            if (data.status === "Success") {

                await cargarDatos(); 
                form.reset();
            } 
            
            else {

                alert("Error: " + data.message);
            }
        } 
        
        catch (err) {

            console.error("Error de red al guardar");
        }
    });
}

cargarDatos();