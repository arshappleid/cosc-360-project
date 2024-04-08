<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../server/functions/user_management.php';
require_once __DIR__ . '/../server/functions/admin_management.php';

class User_Ban_Test extends TestCase
{
	/** @test 
	 * */
	public function getBanStatus_Banned()
	{
		Admin_management::toggleBanUserAccount("test3@gmail.com");
		$this->assertEquals("BANNED", User_management::getBanStatus("test3@gmail.com"));
	}

	/** @test @depends getBanStatus_Banned */
	public function validateUserID_Banned_Account()
	{
		$this->assertEquals("USER_BANNED_FROM_LOGGING_IN", User_management::validateUserLogin("test3@gmail.com", md5("password")));
	}

	/** @test @depends validateUserID_Banned_Account*/
	public function deleteUser_SuccessfulDeletion()
	{
		$this->assertEquals("USER_DELETED", User_management::deleteUser("test3@gmail.com"));
	}
}
