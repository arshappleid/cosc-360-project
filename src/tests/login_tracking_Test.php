<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../server/functions/login_tracking.php';
class login_tracking_Test extends TestCase{

    /** @test */
    public function AddDefaultForCurrentMonth_ValidUser()
    {
        $resp = Login_tracking::AddDefaultForCurrentMonth("1");
        $this->assertEquals($resp,'ADDED');
    }

    /** @test */
    public function AddDefaultForCurrentMonth_InvalidUser()
    {
        $resp = Login_tracking::AddDefaultForCurrentMonth("99");
        $this->assertEquals($resp,'USER_DOES_NOT_EXIST');
    }

    /** @test */
    public function getCountForCurrentMonth_ValidUser()
    {
        $resp = Login_tracking::getCountForCurrentMonth("1");
        $this->assertEquals($resp,'0');
    }

    /** @test */
    public function incrementLogin_ValidUser()
    {
        $resp = Login_tracking::incrementLoginCount("1");
        $this->assertEquals($resp,'UPDATED');
        $resp2 = Login_tracking::getCountForCurrentMonth("1");
        $this->assertEquals($resp2,'1');
    }
    /** @test */
    public function incrementLogin_InValidUser()
    {
        $resp = Login_tracking::incrementLoginCount("99");
        $this->assertEquals($resp,'USER_DOES_NOT_EXIST');
    }

    /** @test */
    public function incrementLogin_NoInitialRecord()
    {
        $resp1 = Login_tracking::incrementLoginCount("2");
        $this->assertEquals($resp1,'UPDATED');
        $resp2 = Login_tracking::getCountForCurrentMonth("1");
        $this->assertEquals($resp2,'1');

    }

}