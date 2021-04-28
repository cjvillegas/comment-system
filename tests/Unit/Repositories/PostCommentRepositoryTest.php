<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\PostComment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCommentRepositoryTest extends TestCase
{
	use RefreshDatabase;

	public function setUp() : void
	{
		parent::setUp();

		$this->artisan("db:seed");
	}

	/**
 	 * Test if get method returns an instance of PostComment
	 */
    public function testInstanceOfPostComment()
    {
    	$model = factory(PostComment::class)->create();

    	$repository = new \App\Repositories\PostCommentRepository(new PostComment);

    	$this->assertTrue($repository->get(1) instanceof \App\Models\PostComment);
    }

    /**
	 * Assert if return value is object when creation is successful
     */
    public function testNewCommentCreted()
    {
    	$repository = new \App\Repositories\PostCommentRepository(new PostComment);

    	$this->assertIsObject($repository->create([
    		'content' => 'Google',
    		'post_id' => 1,
    		'parent_id' => null,
    		'level' => 1
    	]));
    }
}
