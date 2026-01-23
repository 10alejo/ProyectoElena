// Usuarios y nombres visibles
const usuarios = ["ivan", "diego", "adrian", "alejandro"];
const nombresUsuarios = { ivan:"Iván", diego:"Diego", adrian:"Adrián", alejandro:"Alejandro" };

// Ejercicios y nombres visibles
const ejercicios = ["pressbanca", "pesomuerto", "sentadilla", "pressmilitar", "dominadaslastradas"];
const nombresEjercicios = ["Press Banca", "Peso Muerto", "Sentadilla", "Press Militar", "Dominadas Lastradas"];

const rankingsContainer = document.getElementById("rankingsContainer");

function generarRankings() {
  rankingsContainer.innerHTML = ""; 
  
  ejercicios.forEach((ejercicio, index) => {
    const participantes = usuarios.map(u => ({
      nombre: nombresUsuarios[u],
      valor: parseFloat(localStorage.getItem(`${u}-${ejercicio}`)) || 0
    }));

    participantes.sort((a,b) => b.valor - a.valor);

    // Creamos el DIV de la tarjeta
    const card = document.createElement("div");
    card.classList.add("rank-card"); // Esta clase debe coincidir con el CSS
    
    // Generamos el contenido con una estructura de filas
   card.innerHTML = `
  <h3>${nombresEjercicios[index]}</h3>
  <div class="rank-list">
    ${participantes.map((p, i) => `
      <div class="rank-item">
        <div class="rank-user">
          <span class="rank-number">${i + 1}.</span>
          <span class="rank-name">${p.nombre}</span>
        </div>
        <span class="rank-val">${p.valor}${ejercicio === "dominadaslastradas" ? " reps" : " kg"}</span>
      </div>
    `).join('')}
  </div>
`;
    rankingsContainer.appendChild(card);
  });
}

generarRankings();
setInterval(generarRankings, 2000);