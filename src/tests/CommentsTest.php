<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../server/functions/comments.php';
class CommentsTest extends TestCase
{

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
		$this->assertIsArray($resp);
		$this->assertIsArray($resp[0]);
	}

	/** @test */
	public function getAllCommentsForItem_MULTIPLECOMMENTSEXIST()
	{
		$resp = Comments::getAllCommentsForItem("1");
		$this->assertIsArray($resp, "RESPONSE SHOULD BE AN ARRAY");
		$this->assertIsArray($resp[0], "RESP[0] , is not of type array"); // Comment 1
		$this->assertIsArray($resp[1], "RESP[1] , is not of type array"); // Comment 2
	}
	/** @test */
	public function getAllCommentsForItem_NOCOMMENTSEXIST()
	{
		$resp = Comments::getAllCommentsForItem("3");
		$this->assertEquals("NO_COMMENTS_ADDED_YET", $resp);
	}
}
