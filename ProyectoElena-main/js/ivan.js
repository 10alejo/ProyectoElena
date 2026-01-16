const usuario = "ivan";
    const ctx = document.getElementById("pesoChart").getContext("2d");

    const pesoChart = new Chart(ctx, {
      type: "bar",
      data: { labels: [], datasets: [{ data: [], backgroundColor:['#3356ff','#4a70ff','#627eff','#7a94ff','#9bb3ff'] }] },
      options: { responsive:true, scales:{ y:{ beginAtZero:true } }, plugins:{ legend:{ display:false } } }
    });

    const form = document.getElementById("pesoForm");
    const emptyMsg = document.getElementById("emptyMessage");
    const tablaBody = document.querySelector("#tablaPesos tbody");

    const ejercicios = ["pressbanca","sentadilla","pesomuerto","pressmilitar","dominadaslastradas"];

    function cargarDatos() {
      let labels = [];
      let values = [];

      ejercicios.forEach(ej => {
        const val = parseFloat(localStorage.getItem(`${usuario}-${ej}`)) || 0;
        if (val > 0) { labels.push(ej); values.push(val); }
      });

      pesoChart.data.labels = labels;
      pesoChart.data.datasets[0].data = values;
      pesoChart.update();

      emptyMsg.style.display = values.length > 0 ? "none" : "block";
    }

    function cargarTabla() {
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

    cargarDatos();

    form.addEventListener("submit", e => {
      e.preventDefault();

      const ejercicio = document.getElementById("ejercicio").value;
      const peso = parseFloat(document.getElementById("peso").value);

      localStorage.setItem(`${usuario}-${ejercicio}`, peso);
      cargarDatos();
      cargarTabla();
      form.reset();
    });

    // MODALES
    document.getElementById("rutinaBox").onclick = () =>
    document.getElementById("modalRutina").style.display = "flex";
    document.getElementById("cerrarModalRutina").onclick = () =>
    document.getElementById("modalRutina").style.display = "none";

    document.getElementById("pesosBox").onclick = () => {
    cargarTabla();
    document.getElementById("modalPesos").style.display = "flex";
    
    };
    document.getElementById("cerrarModalPesos").onclick = () =>
    document.getElementById("modalPesos").style.display = "none";