<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "./../server/functions/admin_management.php";
class Admin_management_Test extends TestCase
{
    /**function validateAdminLogin($email, $hashed_password)
     * @return string if the given hashed password , matches the hashed password in the database
     */

    /** @test */
    public function validateAdminLogin_ValidLogin()
    {   //email and password match
        $this->assertEquals("VALID_LOGIN", Admin_management::validateAdminLogin("test@gmail.com", md5("password")));
    }
    public function validateAdminLogin_InvalidPassword()
    {   //email matches entry in db, but not password 
        $this->assertEquals("INVALID_LOGIN", Admin_management::validateAdminLogin("test@gmail.com", md5("IncorrectPassword")));
    }
    public function validateUserLogin_EmailNotFound()
    {   //email not found in table
        $this->assertEquals("ADMIN_NOT_FOUND", Admin_management::validateAdminLogin("invalidemail@gmail.com", md5("password")));
    }

    /**unction toggleBanUserAccount($userEmail)
     *
     * Toggles between the banned status for a UserEmail provided.
     *returns "STATUS_UPDATED" if $reponse[0]==true, else it returns "STATUS_NOT_UPDATED"
     */

    /** @test */
    public function toggleBanUserAccount_StatusChanged()
    {

        //I commented out this test because it may ban the only admin account if ran
        //$this->assertEquals("STATUS_UPDATED", Admin_management::toggleBanUserAccount("test@gmail.com"));
    }
    /** @test */
    public function toggleBanUserAccount_StatusNotChanged()
    {
        $this->assertEquals("STATUS_NOT_UPDATED", Admin_management::toggleBanUserAccount("invalidemail@gmail.com"));
    }

    /**function getAllUsers()
     *returns $response[1](a non empty array??) if (count($response[1]) == true) 
     *returns "USERS_NOT_FOUND" if count($response[1]) != true
     *returns "DID_NOT_EXECUTE" if query did not execute 
     */

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
    public function getAllUsers_GotNoUsers()
    {
        //array returned is empty
        //$result = Admin_management::getAllUsers();
        // I commented out this test cause it will not pass unless the USERS table is empty
        //$this-> assertEquals("NO_USERS_FOUND",Admin_management::getAllUsers());
    }
    /** @test */
    public function getAllUsers_DidNotExecute()
    {
        //Query did not execute
        // This test will also not execute without forcing an error somehow
        //$this-> assertEquals("DID_NOT_EXECUTE",Admin_management::getAllUsers());
    }


    /*function checkAdminExists($email)
	 * Returns String if an Admin is already registered or not
     *returns "ADMIN_EXISTS"if $response[0]==true && $response[1] != "NO_DATA_RETURNED"
     *returns "ADMIN_NOT_EXISTS" if ($response[1] == "NO_DATA_RETURNED") 
     */

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

    //function createAdmin($firstName, $lastName, $email, $md5password, $userImage = null)
    /**
     * Creates an admin user in the database.
     *returns "ADMIN_ALREADY_REGISTERED" if checkAdminExists($email) == "ADMIN_EXISTS"
     *else it returns:
     * "ADMIN_NOT_EXIST" if  response[0]==true && response[1] == "NO_DATA_RETURNED"
     * "ADMIN_EXISTS" if response[0] is true && response[1] != "NO_DATA_RETURNED"
     */

    /** @test */
    public function createAdmin_AdminCreated()
    {
        //todo
    }
    /** @test */
    public function createAdmin_AdminNotCreated()
    {
        //todo
    }
    /** @test */
    public function createAdmin_AdminExists()
    {
        //todo
    }

    //function displayName($email)
    //if successful, concatenated string of firstName . " " . lastName for the user 
    //else it returns "USER_NOT_FOUND"

    /** @test */
    public function displayName_NameDisplayed()
    {
        //true if the returned string is the users first and last name with space between
        $this->assertEquals("Test User", Admin_management::displayName("test@gmail.com"));
    }
    /** @test */
    public function displayName_NameNotDisplayed()
    {
        //the user was not found in either Users or Admins
        $this->assertEquals("USER_NOT_FOUND", Admin_management::displayName("invalidemail@gmail.com"));
    }

    /*function getItemID($ITEM_NAME,$STORE_ID)
    * Returs the ITEM_ID of an given ITEM_NAME, if it exists in ITEMS Database
     * - ITEM_ID as String
	 * - ITEM_NOT_FOUND
	 * - COULD_NOT_EXECUTE_QUERY
	 */

    /** @test */
    public function getItemID_gotItemID()
    {
        //should return itemId(1) for with store ID 1 
        $this->assertEquals(1, Admin_management::getItemID("Smartphone", 1));
    }
    /** @test */
    public function getItemID_ItemNotFound()
    {
        //assumes Smartwatch is not added to store 3
        $this->assertEquals("ITEM_NOT_FOUND", Admin_management::getItemID("Smartwatch", 2));
    }

    /*function itemExistsInStore($ITEM_ID,$STORE_ID){
	*ITEM_EXISTS_IN_STORE
	*ITEM_DOES_NOT_EXIST_IN_STORE
	*COULD_NOT_CHECK - query failed
    */

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

    /*function addItem($ITEM_NAME, $ITEM_DESCRIPTION, $STORE_ID, $ITEM_PRICE, $EXTERNAL_LINK)
	 * Possible Return Values :
	 * - ITEM_NOT_ADDED
	 * - ITEM_ADDED
	 * - ITEM_WITH_NAME_ALREADY_EXISTS
	 */

    /** @test */
    public function AddItem_ItemAdded()
    {
        //todo
    }
    /** @test */
    public function AddItem_ItemExists()
    {
        //todo
    }
    /** @test */
    public function AddItem_ItemNotAdded()
    {
        //todo
    }
}
