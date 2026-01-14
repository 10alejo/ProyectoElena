const form = document.getElementById('opinionForm');
const opinionsContainer = document.getElementById('opinionsContainer');

form.addEventListener('submit', function(e) {
  e.preventDefault();

  const name = document.getElementById('name').value.trim();
  const message = document.getElementById('message').value.trim();

  if (name === "" || message === "") {

    alert("Por Favor, Rellene los campos");
    return;
  }

  const card = document.createElement('div');
  card.classList.add('opinions-card');
  card.innerHTML = `<h3> Nombre: ${name}</h3> <br><br> <p> Opinión:${message}</p>`;
  opinionsContainer.prepend(card);
  form.reset();
});

document.getElementById('backButton').addEventListener('click', () => {
  window.history.back();
});

document.getElementById("message").addEventListener('keydown', function(e) {

  if (e.key === 'Enter' && !e.shiftKey) {

    e.preventDefault();
    form.requestSubmit();
  }

});