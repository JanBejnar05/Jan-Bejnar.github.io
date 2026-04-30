const WeatherApp = class {
  constructor(apiKey, resultsBlockSelector) {
    this.apiKey = apiKey;
    this.resultsBlock = document.querySelector(resultsBlockSelector);
    this.currentWeatherLink = `https://api.openweathermap.org/data/2.5/weather?q={query}&appid=${apiKey}&units=metric&lang=pl`;
    this.forecastLink = `https://api.openweathermap.org/data/2.5/forecast?q={query}&appid=${apiKey}&units=metric&lang=pl`;
    this.currentWeather = undefined;
    this.forecast = undefined;
  }

  getCurrentWeather(query) {
    let url = this.currentWeatherLink.replace("{query}", query);
    let req = new XMLHttpRequest();
    req.open("GET", url, true);
    req.addEventListener("load", () => {
      this.currentWeather = JSON.parse(req.responseText);
      this.drawWeather();
    });
    req.send();
  }

  getForecast(query) {
    let url = this.forecastLink.replace("{query}", query);
    fetch(url)
      .then((response) => response.json())
      .then((data) => {
        this.forecast = data.list;
        this.drawWeather();
      });
  }

  getWeather(query) {
    this.getCurrentWeather(query);
    this.getForecast(query);
  }

  drawWeather() {
    this.resultsBlock.innerHTML = '';

    if (this.currentWeather) {
      const date = new Date(this.currentWeather.dt * 1000);
      const weatherBlock = this.createWeatherBlock(
        date.toLocaleString("pl-PL", { day: 'numeric', month: 'long', hour: '2-digit', minute: '2-digit' }),
        this.currentWeather.main.temp,
        this.currentWeather.main.feels_like,
        this.currentWeather.weather[0].icon,
        this.currentWeather.weather[0].description,
        true
      );
      this.resultsBlock.appendChild(weatherBlock);
    }

    if (this.forecast) {

      for(let i = 0; i < this.forecast.length; i += 8) {
        let weather = this.forecast[i];
        const date = new Date(weather.dt * 1000);
        const weatherBlock = this.createWeatherBlock(
          date.toLocaleDateString("pl-PL"),
          weather.main.temp,
          weather.main.feels_like,
          weather.weather[0].icon,
          weather.weather[0].description,
          false
        );
        this.resultsBlock.appendChild(weatherBlock);
      }
    }
  }

  createWeatherBlock(dateString, temperature, feelsLikeTemperature, iconName, description, isCurrent) {
    const weatherBlock = document.createElement("div");
    weatherBlock.className = "weather-block";
    if(isCurrent) weatherBlock.style.borderColor = "#6c5ce7";

    const dateBlock = document.createElement("div");
    dateBlock.className = "weather-date";
    dateBlock.innerHTML = isCurrent ? `TERAZ: ${dateString}` : dateString;
    weatherBlock.appendChild(dateBlock);

    const temperatureBlock = document.createElement("div");
    temperatureBlock.className = "weather-temperature";
    temperatureBlock.innerHTML = `${Math.round(temperature)} &deg;C`;
    weatherBlock.appendChild(temperatureBlock);

    const temperatureFeelBlock = document.createElement("div");
    temperatureFeelBlock.className = "weather-temperature-feels-like";
    temperatureFeelBlock.innerHTML = `Odczuwalna: ${Math.round(feelsLikeTemperature)} &deg;C`;
    weatherBlock.appendChild(temperatureFeelBlock);

    const iconImg = document.createElement("img");
    iconImg.className = "weather-icon";
    iconImg.src = `https://openweathermap.org/img/wn/${iconName}@2x.png`;
    iconImg.alt = description;
    weatherBlock.appendChild(iconImg);

    const descriptionBlock = document.createElement("div");
    descriptionBlock.className = "weather-description";
    descriptionBlock.innerHTML = description;
    weatherBlock.appendChild(descriptionBlock);

    return weatherBlock;
  }
}


document.weatherApp = new WeatherApp("ad726bd1b9008be1b316ce1d4e6102df", "#weatherResults");
document.querySelector('#weatherBtn').addEventListener('click', function() {
  const query = document.querySelector("#cityInput").value;
  if (query) {
    document.weatherApp.getWeather(query);
  } else {
    alert("Proszę wpisać nazwę miasta!");
  }
});
