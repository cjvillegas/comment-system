<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCommentControllerTest extends TestCase
{
	use RefreshDatabase;

	public function setUp() : void
	{
		parent::setUp();

		$this->artisan("db:seed");
	}

    /**
     * Test the post comment route
     *
     * @return void
     */
    public function testCreateNewCommentRoute()
    {
    	$response = $this->post('/post-comment', [
    		'content' => 'Lorem Ipsum',
			'parent_id' => null,
			'post_id' => 1,
			'level' => 1
    	]);

        $response->assertStatus(200);
    }

    /**
     * Test invalid content data passed
     *
     * @return void
     */
    public function testInvalidContentData()
    {
    	$response = $this->post('/post-comment', [
    		'content' => null,
			'parent_id' => null,
			'post_id' => 1,
			'level' => 1
    	]);

    	$response->assertSessionHasErrors(['content'], $format = null, $errorBag = 'default');
    }

    /**
     * Test invalid post_id data passed
     *
     * @return void
     */
    public function testInvalidPostIdData()
    {
    	$response = $this->post('/post-comment', [
    		'content' => 'Ako Naman Muna',
			'parent_id' => null,
			'post_id' => null,
			'level' => 1
    	]);

    	$response->assertSessionHasErrors(['post_id'], $format = null, $errorBag = 'default');
    }

    /**
     * Test invalid level data passed
     *
     * @return void
     */
    public function testInvalidLevelData()
    {
    	$response = $this->post('/post-comment', [
    		'content' => 'The great outdoor',
			'parent_id' => null,
			'post_id' => 1,
			'level' => null
    	]);

    	$response->assertSessionHasErrors(['level'], $format = null, $errorBag = 'default');
    }

    /**
     * Test if response has id in its data
     *
     * @return void
     */
    public function testJsonHasId()
    {
    	$response = $this->post('/post-comment', [
    		'content' => 'The great outdoor',
			'parent_id' => null,
			'post_id' => 1,
			'level' => 1
    	]);

    	$response->assertJson(['id' => 2], $strict = false);
    }

    /**
     * Test if response has total_count response data
     *
     * @return void
     */
    public function testResponseHasTotalCount()
    {
    	$response = $this->post(route('post-comment.fetch-comments'), [
    		'offset' => 0
    	]);

    	$response->assertJson(['total_count' => 2], $strict = false);
    }

    /**
     * Test if response has comments with two items on the list
     *
     * @return void
     */
    public function testResponseHasComments()
    {
    	$response = $this->post(route('post-comment.fetch-comments'), [
    		'offset' => 0
    	]);

    	$response->assertJsonCount(2, 'comments');
    }
}
