 const usuario = "diego";
    const ctx = document.getElementById('pesoChart').getContext('2d');
    const pesoChart = new Chart(ctx, {
      type: 'bar',
      data: { 
        labels: [], 
        datasets: [{
          label: 'Peso Máximo (kg)',
          data: [],
          backgroundColor: ['#3356ff','#4a70ff','#627eff','#7a94ff','#9bb3ff']
        }] 
      },
      options: { 
        responsive:true, 
        maintainAspectRatio:false,
        scales:{ y:{ beginAtZero:true }},
        plugins:{
          legend:{ display:false },
          title:{
            display:true,
            text:'Progresión de tus levantamientos',
            color:'#ffffff',
            font:{ size:16, family:'Poppins' }
          }
        }
      }
    });

    const form = document.getElementById('pesoForm');
    const emptyMsg = document.getElementById('emptyMessage');
    const pesosBox = document.getElementById('pesosBox');
    const modalPesos = document.getElementById('modalPesos');
    const cerrarModalPesos = document.getElementById('cerrarModalPesos');
    const tablaPesosBody = document.querySelector("#tablaPesos tbody");

    const nombresBonitos = {
      pressbanca: "Press Banca",
      sentadilla: "Sentadilla",
      pesomuerto: "Peso Muerto",
      pressmilitar: "Press Militar",
      dominadaslastradas: "Dominadas Lastradas"
    };

    function cargarDatos() {
      const labels = [];
      const data = [];
      const ejercicios = ["pressbanca","sentadilla","pesomuerto","pressmilitar","dominadaslastradas"];

      ejercicios.forEach(ej => {
        const valor = parseFloat(localStorage.getItem(`${usuario}-${ej}`)) || 0;
        if(valor > 0){
          labels.push(nombresBonitos[ej]);
          data.push(valor);
        }
      });

      pesoChart.data.labels = labels;
      pesoChart.data.datasets[0].data = data;
      pesoChart.update();

      emptyMsg.style.display = data.length > 0 ? 'none' : 'block';
    }

    function actualizarTablaPesos(){
      tablaPesosBody.innerHTML="";
      const labels = pesoChart.data.labels;
      const data = pesoChart.data.datasets[0].data;
      if(!labels || labels.length===0){
        tablaPesosBody.innerHTML='<tr><td colspan="2" style="text-align:center; padding:12px;">Aún no hay datos registrados</td></tr>';
        return;
      }
      labels.forEach((ej,i)=>{
        const peso=data[i]??"—";
        const tr=document.createElement("tr");
        tr.innerHTML=`<td style="padding:8px; text-align:center;">${ej}</td><td style="padding:8px; text-align:center;">${peso!=="—"?peso+" kg":peso}</td>`;
        tablaPesosBody.appendChild(tr);
      });
    }

    cargarDatos();

    form.addEventListener('submit', e=>{
      e.preventDefault();
      const ejercicio = document.getElementById('ejercicio').value;
      const peso = parseFloat(document.getElementById('peso').value);
      localStorage.setItem(`${usuario}-${ejercicio}`, peso);
      cargarDatos();
      actualizarTablaPesos();
      form.reset();
    });

    pesosBox.addEventListener('click', ()=>{
      actualizarTablaPesos();
      modalPesos.style.display="flex";
    });
    cerrarModalPesos.addEventListener('click', ()=>{ modalPesos.style.display="none"; });
    modalPesos.addEventListener('click', e=>{ if(e.target===modalPesos) modalPesos.style.display="none"; });