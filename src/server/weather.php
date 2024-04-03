<?php
require_once './../server/functions/weather.php';

// Define an array of cities
$cities = ['Kelowna', 'Vancouver', 'Winnipeg', 'Toronto', 'Quebec City','Ottawa','Montreal','Hamilton','Edmonton','Calgary'];

// Check if a city has been selected
$selectedCity = isset($_POST['city']) ? $_POST['city'] : $cities[0];

$weather = weather::getWeather($selectedCity);
?>
<h3>Latest Weather</h3>
<!-- City Selection Form -->
<form method="post">
    <label for="city">Choose a city:</label>
    <select name="city" id="city" onchange="this.form.submit()">
        <?php foreach ($cities as $city): ?>
            <option value="<?= htmlspecialchars($city) ?>" <?php if ($city == $selectedCity) echo 'selected'; ?>>
                <?= htmlspecialchars($city) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<!-- Weather Information Display -->
<div id = "weather_block">
        <p>Current Weather: <?= htmlspecialchars($weather['CURRENT_WEATHER_CELCIUS']) ?> Celsius</p>
        <p>Wind Speed: <?= htmlspecialchars($weather['WINDSPEED_KMH']) ?> Km/H</p>
        <p>Wind Direction: <?= htmlspecialchars($weather['WIND_DIRECTION']) ?></p>
</div>
