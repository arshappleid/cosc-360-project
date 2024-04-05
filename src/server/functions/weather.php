<?php

include_once 'db_connection.php';
include_once './../GLOBAL_VARS.php';

class weather
{
	private static $UPDATE_WEATHER_EVERY_N_MINUTES = 30;
	private static $API_URL_1 = "https://api.open-meteo.com/v1/forecast?latitude=";
	private static $API_URL_2 = "&longitude=";
	private static $API_URL_3 = "&current_weather=true&timezone=auto";
	public static array $WEATHER_CITIES = ['Kelowna', 'Vancouver', 'Winnipeg', 'Toronto', 'Quebec City', 'Ottawa', 'Montreal', 'Hamilton', 'Edmonton', 'Calgary'];

	public static function updateWeatherForAllCities()
	{
		foreach (self::$WEATHER_CITIES as $city) {
			self::updateWeather($city);
		}
	}

	/**
	 * Checks if the weather for a given city has been updated in the past 15 minutes.
	 * @param string $CITY_NAME The name of the city.
	 * @return string 'UPDATED' if the weather has been updated in the last 15 minutes, otherwise 'NOT_UPDATED'.
	 */
	public static function weatherUpdatedInThePastNMins($CITY_NAME)
	{

		$query = "SELECT CITY_NAME,
            (CASE 
                WHEN TIMESTAMPDIFF(MINUTE, TIME_UPDATED, NOW()) <= ? THEN 'UPDATED'
                ELSE 'NOT_UPDATED'
            END) AS 'UpdatedInLastNMinutes'
        FROM WEATHER
        WHERE CITY_NAME = ?";

		try {
			$resp = executePreparedQuery($query, array('ss', weather::$UPDATE_WEATHER_EVERY_N_MINUTES, $CITY_NAME));
			if ($resp[0] == true) {
				if ($resp[1] == "NO_DATA_RETURNED") {
					return "NOT_UPDATED";
				}
				return $resp[1]['UpdatedInLastNMinutes'];
			}
			return "NOT_UPDATED";
		} catch (Exception $e) {
			echo "Error occurred when trying to validate user with database function.<br>";
			echo $e->getMessage();
		}
	}


	public static function getWeather($CITY_NAME)
	{
		$CITY_NAME = trim($CITY_NAME);
		if (self::weatherUpdatedInThePastNMins($CITY_NAME) === "NOT_UPDATED") {
			self::updateWeather($CITY_NAME);
		}
		$cityNameLike = '"%' . $CITY_NAME . '%"';
		$query = "SELECT CURRENT_WEATHER_CELCIUS, WINDSPEED_KMH, WIND_DIRECTION
            FROM WEATHER
            WHERE CITY_NAME = ?
            AND TIME_UPDATED > NOW() - INTERVAL 15 MINUTE";

		$resp = executePreparedQuery($query, array('s', $CITY_NAME));

		if ($resp[0] === true && !empty($resp[1])) {
			return $resp[1]; // Assuming executePreparedQuery returns the data directly
		}
		return "COULD_NOT_GET_DATA";
	}

	/**
	 * Updates the weather information for a given city.
	 * @param string $CITY_NAME The name of the city.
	 * @return string 'WEATHER_UPDATED' if the update was successful, otherwise 'WEATHER_NOT_UPDATED'.
	 */
	public static function updateWeather($CITY_NAME)
	{

		$query = "SELECT LATITUDE, LONGITUDE FROM WEATHER WHERE CITY_NAME = ?";

		$resp = executePreparedQuery($query, array('s', $CITY_NAME));
		if ($resp[0] === true && !empty($resp[1])) {
			$LATITUDE = $resp[1]['LATITUDE'];
			$LONGITUDE = $resp[1]['LONGITUDE'];

			$URL = self::parseURL($LATITUDE, $LONGITUDE);
			$API_RESP = file_get_contents($URL);
			$weatherData = json_decode($API_RESP, true);
			$query2 = "UPDATE WEATHER
                SET 
                CURRENT_WEATHER_CELCIUS = ?,
                WINDSPEED_KMH = ?,
                WIND_DIRECTION = ?,
                TIME_UPDATED = CURRENT_TIMESTAMP
                WHERE CITY_NAME = ?";

			$resp2 = executePreparedQuery($query2, array(
				'ssss',
				$weatherData['current_weather']['temperature'],
				$weatherData['current_weather']['windspeed'],
				$weatherData['current_weather']['winddirection'],
				$CITY_NAME
			));

			if ($resp2[0] === true) {
				return "WEATHER_UPDATED";
			}
		}
		return "WEATHER_NOT_UPDATED";
	}


	public static function parseURL($LATITUDE, $LONGITUDE)
	{
		return weather::$API_URL_1 . $LATITUDE . weather::$API_URL_2 . $LONGITUDE . weather::$API_URL_3;
	}
}
