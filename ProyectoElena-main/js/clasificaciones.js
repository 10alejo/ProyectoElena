// Usuarios y nombres visibles
const usuarios = ["ivan", "diego", "adrian", "alejandro"];
const nombresUsuarios = { ivan:"Iván", diego:"Diego", adrian:"Adrián", alejandro:"Alejandro" };

// Ejercicios y nombres visibles
const ejercicios = ["pressbanca", "pesomuerto", "sentadilla", "pressmilitar", "dominadaslastradas"];
const nombresEjercicios = ["Press Banca", "Peso Muerto", "Sentadilla", "Press Militar", "Dominadas Lastradas"];

const rankingsContainer = document.getElementById("rankingsContainer");

// Función para generar rankings leyendo localStorage
function generarRankings() {
  rankingsContainer.innerHTML = ""; // limpiar contenido previo
  ejercicios.forEach((ejercicio, index) => {
    const participantes = usuarios.map(u => ({
      nombre: nombresUsuarios[u],
      valor: parseFloat(localStorage.getItem(`${u}-${ejercicio}`)) || 0
    }));

    participantes.sort((a,b) => b.valor - a.valor); // Descendente

    const card = document.createElement("div");
    card.classList.add("rank-card");
    card.innerHTML = `<h3>${nombresEjercicios[index]}</h3>
      <ol>
        ${participantes.map(p => `<li>${p.nombre}: ${p.valor}${ejercicio==="dominadaslastradas"?" reps":" kg"}</li>`).join('')}
      </ol>`;
    rankingsContainer.appendChild(card);
  });
}

// Ejecutar al cargar
generarRankings();

// Actualizar automáticamente cada 2 segundos
setInterval(generarRankings, 2000);

document.getElementById('backButton').addEventListener('click', () => {
  window.history.back();
});