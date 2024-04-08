<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../server/functions/weather.php';
class weatherTest extends TestCase
{
	static $CITYNAME = "Kelowna";
	/** @test */
	public function weatherUpdatedInThePastNMins_Test()
	{
		$resp = weather::weatherUpdatedInThePastNMins(weatherTest::$CITYNAME);
		$this->assertEquals("NOT_UPDATED", $resp);
	}

	/**
	 * @test
	 * @depends weatherUpdatedInThePastNMins_Test
	 * */
	public function updateWeather_Test()
	{
		$resp = weather::updateWeather(weatherTest::$CITYNAME);
		$this->assertEquals("WEATHER_UPDATED", $resp);
	}

	/** @test
	 * @depends updateWeather_Test
	 */
	public function getWeather_Test()
	{
		$resp = weather::getWeather(weatherTest::$CITYNAME);
		$this->assertIsArray($resp);
		$this->assertArrayHasKey('CURRENT_WEATHER_CELCIUS', $resp);
		$this->assertArrayHasKey('WINDSPEED_KMH', $resp);
		$this->assertArrayHasKey('WIND_DIRECTION', $resp);
	}

	/** @test */
	public function parseURL()
	{
		$resp = weather::parseURL("49.44", "-119.34");
		$this->assertIsString($resp);
	}
}
