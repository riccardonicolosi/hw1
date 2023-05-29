const overlay = document.getElementById("overlay");
overlay.classList.add("hidden");



function fetchSongs() {
        fetch("fetch_song.php").then(fetchResponse).then(fetchSongsJson);
}


function fetchResponse(response) {
    if (!response.ok) {return null};
    return response.json();
}

function fetchSongsJson(json) {
    console.log("Fetching...");
    console.log(json);
    if (!json.length) {noResults(); return;}
    
    const container = document.getElementById('results');
    container.innerHTML = '';
    container.className = 'spotify';

    for (let track in json) {
        const card = document.createElement('div');
        card.dataset.id = json[track].content.id;
        card.classList.add('track');
        const tracks = document.querySelectorAll(".track")
        const trackInfo = document.createElement('div');
        trackInfo.classList.add('trackInfo');
        card.appendChild(trackInfo);
        const img = document.createElement('img');
        img.src = json[track].content.image;
        trackInfo.appendChild(img);
        const infoContainer = document.createElement('div');
        infoContainer.classList.add("infoContainer");
        trackInfo.appendChild(infoContainer);
        const info = document.createElement('div');
        info.classList.add("info");
        infoContainer.appendChild(info);
        const name = document.createElement('strong');
        name.innerHTML = json[track].content.title;
        info.appendChild(name);
        const artist = document.createElement('a');
        artist.innerHTML = json[track].content.artist;
        info.appendChild(artist);
        container.appendChild(card);
        }
}

function noResults() {
    // Definisce il comportamento nel caso in cui non ci siano contenuti da mostrare
    const container = document.getElementById('results');
    container.innerHTML = '';
    const nores = document.createElement('div');
    nores.className = "nores";
    nores.textContent = "Nessun risultato.";
    container.appendChild(nores);
  }



fetchSongs();