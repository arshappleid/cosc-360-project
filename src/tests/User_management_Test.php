// tests/CalculatorTest.php
<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../server/functions/User_management.php';


class User_management_Test extends TestCase
{
	/** @test */
	public function validateUserLogin_ValidLogin()
	{

		$this->assertEquals(User_management::validateUserLogin("test@gmail.com", MD5("password")), "VALID_LOGIN");
	}
	/** @test */
	public function validateUserLogin_InValidLogin()
	{

		$this->assertEquals(User_management::validateUserLogin("test2@gmail.com", MD5("password1")), "INVALID_LOGIN");
	}
}