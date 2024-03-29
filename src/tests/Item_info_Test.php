<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../server/functions/item_info.php';
class Item_info_Test extends TestCase
{
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
        $this->assertArrayHasKey('TIME_UPDATED', $resp[0]);
        $this->assertArrayHasKey('Item_Price', $resp[0]);
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
        $resp = Item_info::getAllPrices_Latest_To_Oldest("2", "2");
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
}
