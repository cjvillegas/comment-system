<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\PostComment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCommentTest extends TestCase
{
	use RefreshDatabase;

	public function setUp() : void
	{
		parent::setUp();

		$this->artisan("db:seed");
	}

    /**
 	 * Check if the children relationship returns an instance of collection
     */
    public function testChildrenIsACollection()
    {
    	$model = factory(PostComment::class)->make();

    	PostComment::make([
    		'content' => 'Child comment',
    		'post_id' => $model->post_id,
	        'parent_id' => $model->id,
	        'level' => 2,
	        'created_by' => 1,
	        'created_at' => \Carbon::now()
    	]);

    	$this->assertTrue($model->children instanceof \Illuminate\Database\Eloquent\Collection);
    }

    /**
	 * Test the number of child comment
     */
    public function testChildrenCount()
    {
    	$model = factory(PostComment::class)->create();
    	$children = factory(PostComment::class, 5)->states('child')->create();
        $model = PostComment::where('id', 1)->first();

    	$this->assertEquals(5, $model->children->count());
    }

    /**
	 * Test if the custom field show_reply is default to false
     */
    public function testShowReplyDefaultToFalse()
    {
    	$model = PostComment::where('id', 1)->first();

    	$this->assertEquals(false, $model->show_reply);
    	$this->assertFalse($model->show_reply);
    }
}
