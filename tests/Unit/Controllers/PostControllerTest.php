<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * Test if the given route is working
     *
     * @return void
     */
    public function testViewPostNavigation()
    {
    	$response = $this->get('/');

        $response->assertStatus(200);
        
    }

    /**
     * Test if loaded view is correct
     *
     * @return void
     */
    public function testIsViewCorrect()
    {
    	$response = $this->get('/');

    	$response->assertViewIs('post-index');
    }

    /**
     * Test if the post bound data has post variable
     *
     * @return void
     */
    public function testHasPostBoundData()
    {
    	$response = $this->get('/');

    	$response->assertViewHas('post');
    }
}
