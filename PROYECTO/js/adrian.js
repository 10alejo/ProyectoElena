// 1. Detectar el usuario de la página (viene definido en perfil.php)
const usuario = typeof usuarioPerfil !== 'undefined' ? usuarioPerfil : "adrian"; 
const ctx = document.getElementById("pesoChart").getContext("2d");

const pesoChart = new Chart(ctx, {
    type: "bar",
    data: { 
        labels: [], 
        datasets: [{ 
            data: [], 
            backgroundColor:['#3356ff','#4a70ff','#627eff','#7a94ff','#9bb3ff'] 
        }] 
    },
    options: { 
        responsive: true, 
        scales: { y: { beginAtZero: true } }, 
        plugins: { legend: { display: false } } 
    }
});

const form = document.getElementById("pesoForm");
const emptyMsg = document.getElementById("emptyMessage");
const tablaBody = document.querySelector("#tablaPesos tbody");
const ejercicios = ["pressbanca", "sentadilla", "pesomuerto", "pressmilitar", "dominadaslastradas"];

// 2. CARGAR DATOS (Ahora pide los datos del usuario específico de la URL)
async function cargarDatos() {
    try {
        // Le pasamos el usuario actual a obtener_datos.php para que nos de sus marcas
        const res = await fetch(`../php/obtener_datos.php?user=${usuario}`);
        const datos = await res.json();

        if (Array.isArray(datos) && datos.length > 0) {
            // Sincronizamos LocalStorage con los datos reales de la DB para este usuario
            datos.forEach(d => {
                localStorage.setItem(`${usuario}-${d.ejercicio}`, d.peso);
            });
        }
    } catch (err) {
        console.warn("Usando datos locales para " + usuario);
    }

    let labels = [];
    let values = [];

    ejercicios.forEach(ej => {
        const val = parseFloat(localStorage.getItem(`${usuario}-${ej}`)) || 0;
        if (val > 0) { 
            labels.push(ej); 
            values.push(val); 
        }
    });

    pesoChart.data.labels = labels;
    pesoChart.data.datasets[0].data = values;
    pesoChart.update();
    
    if (emptyMsg) {
        emptyMsg.style.display = values.length > 0 ? "none" : "block";
    }
}

function cargarTabla() {
    if (!tablaBody) return;
    tablaBody.innerHTML = "";
    const labels = pesoChart.data.labels;
    const data = pesoChart.data.datasets[0].data;

    if (labels.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="2">Aún no hay datos</td></tr>';
        return;
    }

    labels.forEach((ej, i) => {
        tablaBody.innerHTML += `<tr><td>${ej}</td><td>${data[i]} kg</td></tr>`;
    });
}

// 3. EVENTO DE ENVÍO (Solo si el formulario existe, es decir, si eres el dueño)
if (form) {
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const ejercicio = document.getElementById("ejercicio").value;
        const peso = document.getElementById("peso").value;

        localStorage.setItem(`${usuario}-${ejercicio}`, peso);
        
        const formData = new FormData(form);
        
        try {
            const response = await fetch('../php/guardar_peso.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.status === "success") {
                console.log("✅ Sincronizado");
                await cargarDatos();
                cargarTabla();
                form.reset();
            } else {
                alert("Error: " + data.message);
            }
        } catch (err) {
            console.error("❌ Error de conexión");
            await cargarDatos();
            cargarTabla();
        }
    });
}

// 4. LÓGICA DE MODALES (Con comprobación de existencia)
const rutinaBtn = document.getElementById("rutinaBox");
if (rutinaBtn) {
    rutinaBtn.onclick = () => document.getElementById("modalRutina").style.display = "flex";
}
document.getElementById("cerrarModalRutina").onclick = () => document.getElementById("modalRutina").style.display = "none";

const pesosBtn = document.getElementById("pesosBox");
if (pesosBtn) {
    pesosBtn.onclick = () => {
        cargarTabla();
        document.getElementById("modalPesos").style.display = "flex";
    };
}
document.getElementById("cerrarModalPesos").onclick = () => document.getElementById("modalPesos").style.display = "none";

// Carga inicial
cargarDatos();