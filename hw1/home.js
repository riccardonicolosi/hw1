const overlay = document.getElementById("overlay");
overlay.addEventListener('click', closeModal);
document.querySelector("#search form").addEventListener("submit", search);

function closeModal(event){
  console.log("Close modal");
  event.currentTarget.classList.add("hidden");
  const card = document.querySelector('.selected');
  card.classList.remove("selected");
  card.classList.remove("unselected");
  card.querySelector('img').classList.remove("img-selected");
  card.querySelector('.canzoneInfo').classList.remove("show");
  card.querySelector('.infoContainer').classList.remove("infoSelected");
  const form = card.querySelector('.saveForm');
  form.classList.remove("hidden");

}

function resizeDish(event){  
  console.log("Resize dish");
  const recipe = event.currentTarget;
  // check if is already selected
  if (!event.currentTarget.classList.contains("selected")){
  overlay.classList.remove("hidden");

  event.currentTarget.classList.remove("unselected");
  event.currentTarget.classList.add("selected");
  event.currentTarget.querySelector('img').classList.add("img-selected"); 
  event.currentTarget.querySelector('.dishInfo').classList.add("show");
  event.currentTarget.querySelector('.infoContainer').classList.add("infoSelected");

  // hide form inside modal
  const form = event.currentTarget.querySelector('.saveForm');
  form.classList.add("hidden");

} else {
  console.log('already selected');
}
}

function jsonFood(json) {
    // svuoto i risultati
    console.log(json);
    const container = document.getElementById('results');
    container.innerHTML = '';
    container.className = 'edamam';
    if (!json.hits.length) {noResults(); return;}
    
    for (let recipe in json.hits) {
        const card = document.createElement('div');
        card.dataset.uri = json.hits[recipe].uri;
        card.dataset.label = json.hits[recipe].label;
        card.dataset.mealType = json.hits[recipe].mealType[0];
        card.dataset.cuisineType = json.hits[recipe].cuisineType[0];
        card.dataset.ingredientLines = json.hits[recipe].ingredientLines[0];
        card.dataset.calories = json.hits[recipe].calories;
        card.dataset.image = json.hits[recipe].image;
        card.classList.add('recipe');
        
        // info quando unselected
        const infoPiatto = document.createElement('div');
        infoPiatto.classList.add('infoPiatto');
        card.appendChild(infoPiatto);

        const img = document.createElement('img');
        img.src = json.hits[recipe].image;
        infoPiatto.appendChild(img);

        const infoContainer = document.createElement('div');
        infoContainer.classList.add("infoContainer");
        infoPiatto.appendChild(infoContainer);

        const info = document.createElement('div');
        info.classList.add("info");
        infoContainer.appendChild(info);

        const name = document.createElement('strong');
        name.innerHTML = json.hits[recipe].label;
        info.appendChild(name);

        const uri = document.createElement('a');
        uri.innerHTML = json.hits[recipe].uri;
        info.appendChild(uri);

        const saveForm = document.createElement('div');
        saveForm.classList.add("saveForm");
        card.appendChild(saveForm);
        const save = document.createElement('div');
        save.value='';
        save.classList.add("save");
        saveForm.appendChild(save);
        saveForm.addEventListener('click',savePiatto);

        // info quando selected
        const dishInfo= document.createElement('div');
        dishInfo.classList.add("dishInfo");
        const mealType = document.createElement('p');
        mealType.innerHTML = 'Tipo di pasto: '+json.hits[recipe].mealType[0];
        dishInfo.appendChild(mealType);
        const cuisineType = document.createElement('p');
        cuisineType.innerHTML = 'Tipo di cucina: '+json.hits[recipe].cuisineType[0];
        dishInfo.appendChild(cuisineType);
        const calories = document.createElement('p');
        calories.innerHTML = 'Valore energetico: '+ json.hits[recipe].calories + ' kcal';
        dishInfo.appendChild(calories);
        card.appendChild(dishInfo);

        // unselected come default
        card.classList.add("unselected");
        // event listener per il resize
        card.addEventListener('click', resizeDish);
        // aggiungiamo il piatto al container
        container.appendChild(card);
        }
}

function noResults() {
  const container = document.getElementById('results');
  container.innerHTML = '';
  const nores = document.createElement('div');
  nores.className = "loading";
  nores.textContent = "Nessun risultato.";
  container.appendChild(nores);
}

function clickLike(event){
  event.stopPropagation();
}

function search(event){
    const form_data = new FormData(document.querySelector("#search form"));
    fetch("search_content.php?q="+encodeURIComponent(form_data.get('search'))).then(searchResponse).then(jsonFood);
    event.preventDefault();
}

function searchResponse(response){
    console.log(response);
    return response.json();
}


function saveSong(event){
  // Preparo i dati da mandare al server e invio la richiesta con POST
  console.log("Salvataggio")
  // get parent card
  const card = event.currentTarget.parentNode;
  const formData = new FormData();
  formData.append('uri', card.dataset.uri);
  formData.append('label', card.dataset.label);
  formData.append('mealType', card.dataset.mealType);
  formData.append('cuisineType', card.dataset.cuisineType);
  formData.append('ingredientLines', card.dataset.ingredientLinesit);
  formData.append('calories', card.dataset.calories);
  formData.append('image', card.dataset.image);
  fetch("save_dish.php", {method: 'post', body: formData}).then(dispatchResponse, dispatchError);
  event.stopPropagation();
}

function dispatchResponse(response) {

  console.log(response);
  return response.json().then(databaseResponse); 
}

function dispatchError(error) { 
  console.log("Errore");
}

function databaseResponse(json) {
  if (!json.ok) {
      dispatchError();
      return null;
  }
}
