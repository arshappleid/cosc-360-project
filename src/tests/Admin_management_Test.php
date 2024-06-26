<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "./../server/functions/admin_management.php";
class Admin_management_Test extends TestCase
{
    /** @test */
    public function getUserID_UserExists()
    {
        $resp = Admin_management::getUserID("test@gmail.com");
        $this->assertEquals("1", $resp);
    }
    /** @test */
    public function getUserID_DoesNotExists()
    {
        $resp = Admin_management::getUserID("DNE@gmail.com");
        $this->assertEquals("USER_NOT_EXISTS", $resp);
    }

    /** @test */
    public function validateAdminLogin_ValidLogin()
    {
        //email and password match
        $this->assertEquals("VALID_LOGIN", Admin_management::validateAdminLogin("test@gmail.com", md5("password")));
    }
    public function validateAdminLogin_InvalidPassword()
    {
        //email matches entry in db, but not password
        $this->assertEquals("INVALID_LOGIN", Admin_management::validateAdminLogin("test@gmail.com", md5("IncorrectPassword")));
    }
    public function validateUserLogin_EmailNotFound()
    {
        //email not found in table
        $this->assertEquals("ADMIN_NOT_FOUND", Admin_management::validateAdminLogin("invalidemail@gmail.com", md5("password")));
    }

    /** @test */
    public function toggleBanUserAccount_ValidUser()
    {
        $this->assertEquals("STATUS_UPDATED", Admin_management::toggleBanUserAccount("test@gmail.com"));
    }

    /** @test */
    public function toggleBanUserAccount_StatusNotChanged()
    {
        $this->assertEquals("STATUS_NOT_UPDATED", Admin_management::toggleBanUserAccount("invalidemail@gmail.com"));
    }

    /** @test */
    public function getAllUsers_GotUsers()
    {
        //if returned array is not empty
        $result = Admin_management::getAllUsers();

        //Sorry, I was unsure if these should both be included in the same test
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function checkAdminExists_AdminExists()
    {
        $this->assertEquals("ADMIN_EXISTS", Admin_management::checkAdminExists("test@gmail.com"));
    }
    /** @test */
    public function checkAdminExists_AdminNotExists()
    {
        $this->assertEquals("ADMIN_NOT_EXIST", Admin_management::checkAdminExists("invalidemail@gmail.com"));
    }

    /** @test */
    public function displayName_NameNotDisplayed()
    {
        //the user was not found in either Users or Admins
        $this->assertEquals("USER_NOT_FOUND", Admin_management::displayName("invalidemail@gmail.com"));
    }

    /** @test */
    public function getItemID_ItemExists()
    {
        //should return itemId(1) for with store ID 1
        $this->assertEquals(1, Admin_management::getItemID("Smartphone", 1));
    }
    /** @test */
    public function getItemID_ItemDoesNotExists()
    {
        //assumes Smartwatch is not added to store 3
        $this->assertEquals("ITEM_NOT_FOUND", Admin_management::getItemID("Tablet", 2));
    }

    /** @test */
    public function itemExistsInStore_ItemExists()
    {
        $this->assertEquals("ITEM_EXISTS_IN_STORE", Admin_management::itemExistsInStore(1, 1));
    }
    /** @test */
    public function itemExistsInStore_ItemNotExists()
    {
        $this->assertEquals("ITEM_DOES_NOT_EXIST_IN_STORE", Admin_management::itemExistsInStore(1, 3));
    }


    /** @test */
    public function AddItem_Should_Be_Added_1()
    {
        $this->assertEquals("ITEM_ADDED", Admin_management::addItem("NEW ITEM", "NEW DESCRIPTION", 1, 100.99, "abc.com", "Food"));
    }

    /** @test */
    public function AddItem_Should_Be_Added_2()
    {
        $this->assertEquals("ITEM_ADDED", Admin_management::addItem("Iphone 13", "The New Iphone 13", 1, "1100.99", "abc.com", "Food"));
    }
    /** @test */
    public function AddItem_ItemWithNameAlreadyExists()
    {
        $this->assertEquals("ITEM_WITH_NAME_ALREADY_EXISTS", Admin_management::addItem("Smartphone", "NEW DESCRIPTION", 1, 100.99, "abc.com", "Food"));
    }

    //these tests assume there is at least 1 active and 1 inactive user in the DB.
    //commented the first one out, because all users in the db are inactive 
    /** @test */
    /*
    public function getActiveUsers_gotActiveUsers(){
        $result = Admin_management::getActiveUsers();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

    }

    */
    /** @test */
    public function getInactiveUsers_gotInactiveUsers()
    {
        $result = Admin_management::getInactiveUsers();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }
}
