<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Alejandro — AllGim</title>
    <link
      rel="icon"
      href="../php/mostrar_foto.php?nombre=logo"
      type="image/png"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&family=Poppins:wght@700&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/estiloAlejandro.css" />
  </head>
  <body>
    <a class="back" href="../php/home.php">← Volver</a>

    <div class="top-section">
      <div class="profile-img">
        <img
          src="../php/mostrar_foto.php?nombre=alejandro"
          alt="Alejandro - AllGim"
        />
      </div>
      <div class="profile-info">
        <h2>🏋️‍♂️ Alejandro</h2>
        <p>Edad: 19 años</p>
        <p>Peso: 72 kg</p>
      </div>
    </div>

    <div class="box-container">
      <div class="info-box" id="rutinaBox">
        <h3>Rutina</h3>
        <p>Push/Pull/Legs centrado en fuerza y técnica de competición.</p>
      </div>

      <div class="info-box" id="pesosBox">
        <h3>Pesos Máximos</h3>
        <p>Introduce tus marcas personales abajo 👇 y visualízalas.</p>
      </div>

      <div class="info-box">
        <h3>Dieta</h3>
        <p>Alta en proteínas, moderada en carbohidratos y grasas saludables.</p>
      </div>
    </div>

    <div class="chart-section">
      <h3>📊 Registrar y visualizar tus pesos máximos</h3>
      <form id="pesoForm" action="../php/guardar_peso.php" method="post">
        <select id="ejercicio" name="ejercicio">
          <option value="pressbanca">Press banca</option>
          <option value="sentadilla">Sentadilla</option>
          <option value="pesomuerto">Peso muerto</option>
          <option value="pressmilitar">Press militar</option>
          <option value="dominadaslastradas">Dominadas lastradas</option>
        </select>
        <input type="number" id="peso" name="peso" placeholder="Peso (kg)" required min="1">
        <button type="submit">Añadir</button>
      </form>

      <div class="chart-wrapper">
        <canvas id="pesoChart"></canvas>
        <div id="emptyMessage">Aún no hay datos registrados 💪</div>
      </div>
    </div>

    <!-- Modal Rutina -->
    <div class="modal" id="modalRutina">
      <img
        src="https://www.puregym.com/media/nvrfnxfy/training-splits-1.jpg?quality=80"
        alt="Rutina de entrenamiento"
      />
      <button id="cerrarModal">Cerrar</button>
    </div>

    <!-- Modal Pesos -->
    <div class="modal" id="modalPesos">
      <div style="text-align: center; width: 100%">
        <h2 style="color: #9bb3ff">📊 Pesos Máximos</h2>
        <table id="tablaPesos">
          <thead>
            <tr>
              <th>Ejercicio</th>
              <th>Peso (kg)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="2" style="text-align: center; padding: 12px">
                Aún no hay datos registrados
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <button id="cerrarModalPesos">Cerrar</button>
    </div>

    <script src="../js/alejandro.js"></script>
  </body>
</html>
