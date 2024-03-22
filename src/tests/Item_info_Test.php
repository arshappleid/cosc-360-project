<?php

use PHPUnit\Framework\TestCase;

class ItemInfoTest extends TestCase
{
    /** @test */
    public function itemExists_ItemExists()
    {
        $this->assertEquals("ITEM_EXISTS",Item_info::itemExists(1));
    }

    /** @test */
    public function itemExists_ItemNotExists()
    {
        $this->assertEquals("ITEM_NOT_EXISTS",Item_info::itemExists(9999));
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
        $this->assertEquals("NO_ITEMS_AVAILABLE_AT_STORE",Item_info::getAllItems_IDS_AtStore(9999));
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
        $this->assertEquals("NO_ITEM_FOUND",Item_info::getItemInfo(9999));
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
        $this->assertEquals("NO_STORES_IN_DATABASE",Item_info::getAllStoreList());
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
        $this->assertEquals("NO_ITEMS_IN_DATABASE",Item_info::getAllItems());
    }

}
?>
