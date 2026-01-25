const form = document.getElementById('suggestionForm');
const suggestionsContainer = document.getElementById('suggestionsContainer');

form.addEventListener('submit', function(e) {
  e.preventDefault();
  const name = document.getElementById('name').value;
  const category = document.getElementById('category').value;
  const message = document.getElementById('message').value;

  const card = document.createElement('div');
  card.classList.add('suggestion-card');
  card.innerHTML = `<h3>${category}</h3><p><strong>Nombre: ${name}</strong> <br><br> Sugerencia: ${message}</p>`;
  suggestionsContainer.prepend(card);
  form.reset();
});

document.getElementById('backButton').addEventListener('click', () => {
  window.history.back();
});