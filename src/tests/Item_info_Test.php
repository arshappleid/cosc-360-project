<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../server/functions/item_info.php';
class Item_info_Test extends TestCase
{
    /** @test */
    public function getHomePageItems_Test()
    {
        $resp = Item_info::getHomePageItems();
        $this->assertIsArray($resp);
        if (is_array($resp[0])) {
            $this->assertArrayHasKey('ITEM_ID', $resp[0]);
            $this->assertArrayHasKey('ITEM_NAME', $resp[0]);
            $this->assertArrayHasKey('STORE_ID', $resp[0]);
            $this->assertArrayHasKey('Item_Entry', $resp[0]);
        } else {
            $this->assertArrayHasKey('ITEM_ID', $resp);
            $this->assertArrayHasKey('ITEM_NAME', $resp);
            $this->assertArrayHasKey('STORE_ID', $resp);
            $this->assertArrayHasKey('Item_Entry', $resp);
        }
    }
    /** @test */
    public function itemExists_ItemExists()
    {
        $this->assertEquals("ITEM_EXISTS", Item_info::itemExists(1));
    }

    /** @test */
    public function itemExists_ItemNotExists()
    {
        $this->assertEquals("ITEM_NOT_EXISTS", Item_info::itemExists(9999));
    }

    /** @test */
    public function getAllItems_IDS_AtStore_gotAllItems()
    {
        $result = Item_info::getAllItems_IDS_AtStore(1);
        $this->assertIsArray($result);
    }

    /** @test */
    public function getAllItems_IDS_AtStore_gotNoItems()
    {
        $this->assertEquals("NO_ITEMS_AVAILABLE_AT_STORE", Item_info::getAllItems_IDS_AtStore(9999));
    }

    /** @test */
    public function getItemInfo_ValidInfo()
    {
        $result = Item_info::getItemInfo(2);
        $this->assertIsArray($result);
    }

    /** @test */
    public function getItemInfo_InvalidInfo()
    {
        $this->assertEquals("INVALID_ITEM_ID", Item_info::getItemInfo(9999));
    }

    /** @test */
    public function getAllStoreList_gotAllStores()
    {
        $result = Item_info::getAllStoreList();
        $this->assertIsArray($result);
    }


    /** @test */
    public function getAllItemsAtStore_GotAllItems()
    {
        $result = Item_info::getAllItemsAtStore("1");
        $this->assertisArray($result);
    }

    /** @test */
    public function getAllItemsAtStore_InvalidStore()
    {
        $result = Item_info::getAllItemsAtStore("99");
        $this->assertEquals($result, "INVALID_STORE_ID");
    }


    /** @test */
    public function getAllPrices_ValuesExist()
    {
        $resp = Item_info::getAllPrices_Latest_To_Oldest("1", "1");
        $this->assertIsArray($resp);
        if (isset($resp[0]) && is_array($resp[0])) {
            $this->assertArrayHasKey('TIME_UPDATED', $resp[0]);
            $this->assertArrayHasKey('Item_Price', $resp[0]);
        } else {
            $this->assertArrayHasKey('TIME_UPDATED', $resp);
            $this->assertArrayHasKey('Item_Price', $resp);
        }
    }

    /** @test */
    public function getAllPrices_InvalidItemID()
    {
        $resp = Item_info::getAllPrices_Latest_To_Oldest("99", "1");
        $this->assertEquals($resp, "INVALID_ITEM_ID");
    }

    /** @test */
    public function getAllPrices_INVALID_STORE_ID()
    {
        $resp = Item_info::getAllPrices_Latest_To_Oldest("1", "99");
        $this->assertEquals($resp, "INVALID_STORE_ID");
    }
    /** @test */
    public function getAllPrices_NoRecordsFound()
    {
        $resp = Item_info::getAllPrices_Latest_To_Oldest("2", "4");
        $this->assertEquals($resp, "NO_ENTRIES_FOUND");
    }

    /** @test */
    public function ValidateStoreId_Valid_Store_ID()
    {
        $resp = Item_info::ValidateStoreId("1");
        $this->assertEquals($resp, "STORE_EXISTS");
    }

    /** @test */
    public function ValidateStoreId_InValid_Store_ID()
    {
        $resp = Item_info::ValidateStoreId("99");
        $this->assertEquals($resp, "INVALID_STORE_ID");
    }

    /** @test */
    public function getAllCategories_RecordsExist()
    {
        $resp = Item_info::getAllCategories();
        $this->assertIsArray($resp);
    }

    /** @test */
    public function upvoteItem_Test()
    {
        $resp = Item_info::upvoteItem(1);
        $this->assertEquals("UPDATED", $resp);
    }

    /** @test */
    public function addCategory_Test()
    {
        $resp = Item_info::addCategory("NEW CATEGORY", "Something that will make your life better");
        $this->assertEquals("ADDED", $resp);
    }

    /** @test @depends addCategory_Test*/
    public function addCategory_Test_AGAIN()
    {
        $resp = Item_info::addCategory("NEW CATEGORY", "Something that will make your life better");
        $this->assertEquals("CATEGORY_WITH_NAME_ALREADY_EXISTS", $resp);
    }
    /** @test  @depends addCategory_Test */
    public function getAllCategories_Test()
    {
        $resp = Item_info::getAllCategories();
        $this->assertIsArray($resp);
    }

    /** @test  @depends addCategory_Test */
    public function checkCategoryExists_Record_Exists()
    {
        $resp = Item_info::checkCategoryExists("NEW CATEGORY");
        $this->assertEquals("EXISTS", $resp);
    }

    /** @test  @depends addCategory_Test */
    public function checkCategoryExists_Record_Does_Not_Exists()
    {
        $resp = Item_info::checkCategoryExists("NOT_EXISTS");
        $this->assertEquals("NOT_EXISTS", $resp);
    }

    /** @test  */
    public function getStoreID_forItem_itemFoundInStores()
    {
        $resp = Item_info::getStoreID_forItem("1");
        $this->assertEquals("1", $resp);
    }
    /** @test  */
    public function getStoreID_forItem_itemNotFoundInStores()
    {   

        //assuming item 12 has not had any entries put in 
        //this will break if every item ID in the store is given a price entry 
        $resp = Item_info::getStoreID_forItem("12");
        $this->assertEquals("ITEM_NOT_FOUND_IN_STORES", $resp);
    }
    /** @test  */
    public function getStoreID_forItem_itemNotExists()
    {
        $resp = Item_info::getStoreID_forItem("99");
        $this->assertEquals("ITEM_NOT_EXISTS", $resp);
    }
}

