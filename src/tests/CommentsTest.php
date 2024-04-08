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
	public function getAllCommentsForItem_ONLY1COMMENTSEXIST()
	{
		$resp = Comments::getAllCommentsForItem("4");
		$this->assertIsArray($resp);
		$this->assertArrayHasKey('COMMENT_ID', $resp);
	}

	/** @test */
	public function getAllCommentsForItem_MULTIPLECOMMENTSEXIST()
	{
		$resp = Comments::getAllCommentsForItem("2");
		$this->assertIsArray($resp, "RESPONSE SHOULD BE AN ARRAY");
		$this->assertIsArray($resp[0], "RESP[0] , is not of type array"); // Comment 1
		$this->assertIsArray($resp[1], "RESP[1] , is not of type array"); // Comment 2
	}
	/** @test */
	public function getAllCommentsForItem_NOCOMMENTSEXIST()
	{
		$resp = Comments::getAllCommentsForItem("6");
		$this->assertEquals("NO_COMMENTS_ADDED_YET", $resp);
	}

	/** @test */
	public function deleteComment_Comment_Exists()
	{
		$resp = Comments::deleteComment("1");
		$this->assertEquals("COMMENT_DELETED", $resp);
	}

	/** @test */
	public function deleteComment_Comment_DNExists()
	{
		$resp = Comments::deleteComment("99");
		$this->assertEquals("COMMENT_NOT_EXISTS", $resp);
	}
	/** @test */
	public function addComment_UserExists_ItemExists()
	{
		$resp = Comments::addComment("New Comment", "1", "test@gmail.com");
		$this->assertEquals("COMMENT_ADDED", $resp);
	}

	/** @test */
	public function addComment_UserExists_ItemDoesNotExists()
	{
		$resp = Comments::addComment("New Comment", "99", "test@gmail.com");
		$this->assertEquals("ITEM_NOT_EXISTS", $resp);
	}
}
