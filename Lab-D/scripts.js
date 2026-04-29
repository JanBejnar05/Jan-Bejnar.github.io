const apiKey = 'ad726bd1b9008be1b316ce1d4e6102df';

document.getElementById('weatherBtn').addEventListener('click', function() {
  const city = document.getElementById('cityInput').value.trim();
  if (!city) return;

  const resultsDiv = document.getElementById('weatherResults');
  resultsDiv.innerHTML = '<p>Ładowanie...</p>';

  // Bieżąca pogoda - XMLHttpRequest
  const xhr = new XMLHttpRequest();
  xhr.open('GET', `https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(city)}&appid=${apiKey}&units=metric&lang=pl`);
  xhr.onload = function() {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);
      showCurrentWeather(data);
    } else {
      resultsDiv.innerHTML = '<p>Nie znaleziono miasta.</p>';
    }
  };
  xhr.onerror = function() {
    resultsDiv.innerHTML = '<p>Błąd połączenia.</p>';
  };
  xhr.send();

  // Prognoza 5 dni - Fetch API
  fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${encodeURIComponent(city)}&appid=${apiKey}&units=metric&lang=pl`)
    .then(res => res.ok ? res.json() : Promise.reject())
    .then(showForecast)
    .catch(() => {
      // nie nadpisuj jeśli bieżąca pogoda już się wyświetliła
    });
});

function showCurrentWeather(data) {
  const resultsDiv = document.getElementById('weatherResults');
  resultsDiv.innerHTML = `
        <div class="weather-card">
            <img class="weather-icon" src="https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png" alt="">
            <div>
                <strong>${data.name}, ${data.sys.country}</strong><br>
                <span>${data.weather[0].description}</span><br>
                <span style="font-size:1.5em;">${data.main.temp.toFixed(1)}°C</span>
                <br>Odczuwalna: ${data.main.feels_like.toFixed(1)}°C
            </div>
        </div>
        <h3>Prognoza 5 dni:</h3>
        <div id="forecast"></div>
    `;
}

function showForecast(data) {
  const forecastDiv = document.getElementById('forecast');
  if (!forecastDiv) return;
  forecastDiv.innerHTML = data.list
    .filter((_, i) => i % 8 === 0) // co 24h (co 8x3h)
    .map(item => `
            <div class="weather-card">
                <img class="weather-icon" src="https://openweathermap.org/img/wn/${item.weather[0].icon}@2x.png" alt="">
                <div>
                    <strong>${item.dt_txt.split(' ')[0]}</strong><br>
                    <span>${item.weather[0].description}</span><br>
                    <span style="font-size:1.2em;">${item.main.temp.toFixed(1)}°C</span>
                    <br>Odczuwalna: ${item.main.feels_like.toFixed(1)}°C
                </div>
            </div>
        `).join('');
}
