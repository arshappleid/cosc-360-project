<?php

use PHPUnit\Framework\TestCase;

class UserManagementTest extends TestCase
{
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
    public function createUser_WithImage_SuccessfulCreation()
    {
        // Ensure that this email does not exist in the database before testing
        $imageBlob = file_get_contents('./../images/userImages/admin/test@gmail.com.jpeg');
        $this->assertEquals("USER_CREATED", User_management::createUser_WithImage("uniqueemailimage@gmail.com", "First", "Last", md5("password"), $imageBlob));
    }

    /** @test */
    public function userExists_Exists()
    {
        $this->assertEquals("USER_EXISTS", User_management::userExists("test@gmail.com"));
    }

    /** @test */
    public function userExists_NotExists()
    {
        $this->assertEquals("USER_NOT_EXISTS", User_management::userExists("doesnotexist@gmail.com"));
    }

    /** @test */
    public function userUpdatePassword_SuccessfulUpdate()
    {
        $this->assertEquals("PASSWORD_UPDATED", User_management::userUpdatePassword("test@gmail.com", md5("password"), md5("newpassword")));
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

    /** @test */
    public function deleteUser_SuccessfulDeletion()
    {
        $this->assertEquals("USER_DELETED", User_management::deleteUser("deletableuser@gmail.com"));
    }

    /** @test */
    public function getUser_First_Last_Name_Found()
    {
        $this->assertEquals("Test User", User_management::getUser_First_Last_Name(1));
    }

    /** @test */
    public function getAllUserData_Found()
    {
        // Assuming data exists for "test@gmail.com"
        $data = User_management::getAllUserData("test@gmail.com");
        $this->assertIsArray($data);
        $this->assertEquals("test@gmail.com", $data['Email']); // Basic check to ensure some data matches
    }
}
