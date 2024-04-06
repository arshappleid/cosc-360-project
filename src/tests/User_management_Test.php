<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../server/functions/user_management.php';
require_once __DIR__ . '/../server/functions/admin_management.php';

class User_management_Test extends TestCase
{
    /** @test */
    public function getUser_First_Last_Name_Found()
    {
        $this->assertEquals("Test User", User_management::getUser_First_Last_Name(1));
    }

    /** @test */
    public function validateUserLogin_ValidLogin()
    {
        $this->assertEquals("VALID_LOGIN", User_management::validateUserLogin("test@gmail.com", md5("password")));
    }

    /** @test */
    public function validateUserLogin_InvalidLogin()
    {
        $this->assertEquals("INVALID_LOGIN", User_management::validateUserLogin("test2@gmail.com", md5("wrongpassword")));
    }

    /** @test */
    public function validateUserID_VALIDID()
    {
        $this->assertEquals("VALID_USER", User_management::validateUserID("1"));
    }
    /** @test */
    public function validateUserID_INVALIDID()
    {
        $this->assertEquals("USER_DOES_NOT_EXIST", User_management::validateUserID("99"));
    }



    /** @test */
    public function getAllUserComments_1Comment()
    {
        $resp = User_management::getAllUserComments("3");
        $this->assertIsArray($resp);
        $this->assertNotEmpty($resp);
        $this->assertArrayHasKey('COMMENT_TEXT', $resp);
        $this->assertArrayHasKey('COMMENT_ID', $resp);
        $this->assertIsString($resp['COMMENT_TEXT']);
        $this->assertIsString($resp['ITEM_NAME']);
    }

    /** @test */
    public function getAllUserComments_MoreThan1Comments()
    {
        $resp = User_management::getAllUserComments("1");
        $this->assertIsArray($resp);
        $this->assertNotEmpty($resp);
        foreach ($resp as $comment) {
            $this->assertIsArray($comment);
            $this->assertArrayHasKey('COMMENT_ID', $comment);
            $this->assertIsString($comment['COMMENT_TEXT']);
            $this->assertIsString($comment['ITEM_NAME']);
        }
    }


    /** @test */
    public function createUser_AlreadyExists()
    {
        $this->assertEquals("USER_ALREADY_EXISTS", User_management::createUser("test@gmail.com", "First", "Last", md5("password")));
    }

    /** @test */
    public function createUser_SuccessfulCreation()
    {
        // Ensure that this email does not exist in the database before testing
        $this->assertEquals("USER_CREATED", User_management::createUser("uniqueemail@gmail.com", "First", "Last", md5("password")));
    }


    /** @test */
    public function userExists_Exists()
    {
        $resp = User_management::userExists("test@gmail.com");
        $this->assertEquals("USER_EXISTS", $resp);
    }

    /** @test */
    public function userExists_NotExists()
    {
        $resp = User_management::userExists("doesnotexist@gmail.com");
        $this->assertEquals("USER_NOT_EXISTS", $resp);
    }

    /** @test */
    public function userUpdatePassword_SuccessfulUpdate()
    {
        $this->assertEquals("PASSWORD_UPDATED", User_management::userUpdatePassword("test2@gmail.com", md5("password"), md5("newpassword")));
    }

    /** @test */
    public function editUserFirstName_SuccessfulUpdate()
    {
        $this->assertEquals("NAME_UPDATED", User_management::editUserFirstName("test@gmail.com", "NewFirstName"));
    }

    /** @test */
    public function editUserLastName_SuccessfulUpdate()
    {
        $this->assertEquals("NAME_UPDATED", User_management::editUserLastName("test@gmail.com", "NewLastName"));
    }

    /** @test */
    public function getBanStatus_NotBanned()
    {
        $this->assertEquals("NOT_BANNED", User_management::getBanStatus("test@gmail.com"));
    }

    /** @test @depends ValidateUserLogin_ValidLogin @depends GetBanStatus_NotBanned*/
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

    /** @test */
    public function getAllUserData_Found()
    {
        // Assuming data exists for "test@gmail.com"
        $data = User_management::getAllUserData("test@gmail.com");
        $this->assertIsArray($data);
        $this->assertEquals("test@gmail.com", $data['Email']); // Basic check to ensure some data matches
    }
    /** @test */
    public function getUserID_USER_EXISTS()
    {
        $this->assertEquals("1", User_management::getUserID("test@gmail.com"));
    }

    /** @test */
    public function getUserID_USER_DOES_NOT_EXIST()
    {
        $this->assertEquals("USER_NOT_EXISTS", User_management::getUserID("doesNotExist@gmail.com"));
    }
    /** @test */
    public function getUserID_EMPTY_VALUE()
    {
        $this->assertEquals("USER_NOT_EXISTS", User_management::getUserID(""));
    }
    /** @test */
    public function getAllUserComments_NoComments()
    {
        $resp =  User_management::getAllUserComments("4");
        $this->assertEquals("NO_COMMENTS_FOUND", $resp);
    }
}
