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
        $this->assertEquals("NO_ITEM_FOUND", Item_info::getItemInfo(9999));
    }

    /** @test */
    public function getAllStoreList_gotAllStores()
    {
        $result = Item_info::getAllStoreList();
        $this->assertIsArray($result);
    }

    /** @test */
    public function getAllStoreList_gotNoStores()
    {
        $this->assertEquals("NO_STORES_IN_DATABASE", Item_info::getAllStoreList());
    }

    /** @test */
    public function getAllItems_GotAllItems()
    {
        $result = Item_info::getAllItems();
        $this->assertisArray($result);
    }

    /** @test */
    public function getAllItems_GotNoItems()
    {
        $this->assertEquals("NO_ITEMS_IN_DATABASE", Item_info::getAllItems());
    }

    /** @test */
    public function getAllPrices_ValuesExist()
    {
        $resp = Item_info::getAllPrices_Latest_To_Oldest("1");
        $this->assertIsArray($resp);
        $this->assertArrayHasKey('TIME_UPDATED', $resp[0]);
        $this->assertArrayHasKey('ITEM_PRICE', $resp[0]);
    }

    /** @test */
    public function getAllPrices_InvalidItemID()
    {
        $resp = Item_info::getAllPrices_Latest_To_Oldest("99");
        $this->assertEquals($resp, "INVALID_ITEM_ID");
    }

    /** @test */
    public function getAllPrices_NoRecordsFound()
    {
        $resp = Item_info::getAllPrices_Latest_To_Oldest("3");
        $this->assertEquals($resp, "NO_ENTRIES_FOUND");
    }
}