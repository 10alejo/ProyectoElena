// 1. Configuración de nombres y IDs
const usuarios = ["ivan", "diego", "adrian", "alejandro"];
const nombresUsuarios = { ivan:"Iván", diego:"Diego", adrian:"Adrián", alejandro:"Alejandro" };

const ejercicios = ["pressbanca", "pesomuerto", "sentadilla", "pressmilitar", "dominadaslastradas"];
const nombresEjercicios = ["Press Banca", "Peso Muerto", "Sentadilla", "Press Militar", "Dominadas Lastradas"];

const rankingsContainer = document.getElementById("rankingsContainer");

// 2. Función principal que pide los datos al PHP "híbrido"
async function generarRankings() {
    try {
        // Llamamos a obtener_datos.php sin "?user=" para que nos devuelva TODO
        const res = await fetch("../php/obtener_datos.php");
        const todosLosPesos = await res.json();

        // Limpiamos el contenedor antes de repintar
        rankingsContainer.innerHTML = ""; 
      
        ejercicios.forEach((ejercicio, index) => {
            // Filtramos los datos que vienen de la DB para cada usuario en este ejercicio
            const participantes = usuarios.map(u => {
                // Buscamos el registro que coincida con usuario y ejercicio
                const registro = todosLosPesos.find(p => 
                    p.usuario.toLowerCase().trim() === u && 
                    p.ejercicio.toLowerCase().trim() === ejercicio
                );
                
                return {
                    nombre: nombresUsuarios[u],
                    valor: registro ? parseFloat(registro.peso) : 0
                };
            });

            // Ordenamos el ranking de mayor a menor peso
            participantes.sort((a,b) => b.valor - a.valor);

            // Creamos la tarjeta visual
            const card = document.createElement("div");
            card.classList.add("rank-card");
            
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
    } catch (error) {
        console.error("Error cargando el ranking real:", error);
    }
}

// 3. Ejecución inicial
generarRankings();

// Refresco automático cada 5 segundos (más eficiente que cada 2)
setInterval(generarRankings, 5000);