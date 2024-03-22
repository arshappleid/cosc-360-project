<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../server/functions/comments.php';
class CommentsTest extends TestCase
{
	/** @test */
	public function getUserID_USER_EXISTS()
	{
		$this->assertEquals("1", Comments::getUserID("test@gmail.com"));
	}

	/** @test */
	public function getUserID_USER_DOES_NOT_EXIST()
	{
		$this->assertEquals("USER_NOT_EXISTS", Comments::getUserID("doesNotExist@gmail.com"));
	}
	/** @test */
	public function getUserID_EMPTY_VALUE()
	{
		$this->assertEquals("USER_NOT_EXISTS", Comments::getUserID(""));
	}

	/** @test */
	public function commentExists_Exists()
	{
		$this->assertEquals("COMMENT_EXISTS", Comments::commentExists("1"));
	}

	/** @test */
	public function commentExists_DNExists()
	{
		$this->assertEquals("COMMENT_NOT_EXISTS", Comments::commentExists("-1"));
	}
	/** @test */
	public function commentExists_EmptyValue()
	{
		$this->assertEquals("COMMENT_NOT_EXISTS", Comments::commentExists(""));
	}

	/** @test */
	public function getAllCommentsForItem_1COMMENTSEXIST()
	{
		$resp = Comments::getAllCommentsForItem("2");
		$this->assertCount(1, $resp[1]);
	}

	/** @test */
	public function getAllCommentsForItem_MULTIPLECOMMENTSEXIST()
	{
		$resp = Comments::getAllCommentsForItem("2");
		$this->assertCount(1, $resp[1]);
	}
	/** @test */
	public function getAllCommentsForItem_NOCOMMENTSEXIST()
	{
		$resp = Comments::getAllCommentsForItem("99");
		$this->assertCount(0, count($resp[1]));
	}
}
