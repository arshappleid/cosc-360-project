<?php

include_once './functions/weather.php';

// Make the API request
$response = weather::getWeather("Vancouver"); // Check Database table for exact cities allowed , They Have to be an exact match , Case Sensitive
// You can test the city value in Tests/weatherTest.php
print_r($response);
echo "<br>";
// Output the current weather
echo "Current Temperature Celcius :" . $response['CURRENT_WEATHER_CELCIUS'] . "<br>";
echo "Windspeed :" . $response['CURRENT_WEATHER_CELCIUS'] . "km/h<br>";
echo "Wind Direction :" . $response['WIND_DIRECTION'] . "not<br>";
