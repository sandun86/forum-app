<?php

/**
 * @file  PostControllerTest.php
 *
 * PostControllerTest TestCase
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostControllerTest extends TestCase {


    private function getPostStoreInput() {
        $input = [
            'title' => 'title',
            'description' => 'description',
            'tag' => 'tag',
            'user_id' => 3
        ];

        return $input;
    }

    /**
     *  Test post store function if output is success
     */
    public function testStoreIfSuccess() 
    {
        $this->withoutMiddleware();

        $postObject = ['id' => 1, 'title' => 'title'];
        $return = [(object)$postObject];
        $input = $this->getPostStoreInput();

        $postRepositoryMock = \Mockery::mock('App\Repositories\v1\PostRepository');
        $postRepositoryMock->shouldReceive('create')
            ->once()->with($input)->andReturn($return);
        $this->app->instance('App\Repositories\v1\PostRepository', $postRepositoryMock);

        $response = $this->call('POST', 'post', $input);
        $this->assertResponseOk();
        $this->assertResponseStatus(200);

    }

    /**
    * Test post store function if output is not success
    */
    public function testStoreIfNotSuccess() 
    {
        $this->withoutMiddleware();
        $postObject = ['id' => 1, 'title' => 'title'];
        $input = $this->getPostStoreInput();
        $return = [];

        $postRepositoryMock = \Mockery::mock('App\Repositories\v1\PostRepository');
        $postRepositoryMock->shouldReceive('create')->once()->withAnyArgs()->andReturn($return);
        $this->app->instance('App\Repositories\v1\PostRepository', $postRepositoryMock);
        $response = $this->call('POST', 'post', $input);

        $this->assertResponseStatus(400);
    }

    /**
     *  Test post update function if output is success
     */
    public function testUpdateIfSuccess() 
    {
        $this->withoutMiddleware();

        $postObject = ['id' => 1, 'title' => 'title'];
        $return = [(object)$postObject];
        $input = $this->getPostStoreInput();

        $postRepositoryMock = \Mockery::mock('App\Repositories\v1\PostRepository');
        $postRepositoryMock->shouldReceive('update')
            ->once()->withAnyArgs([])->andReturn(true);
        $postRepositoryMock->shouldReceive('find')
            ->once()->withAnyArgs([])->andReturn($return);
        $this->app->instance('App\Repositories\v1\PostRepository', $postRepositoryMock);

        $response = $this->call('PUT', 'post/3', $input);
        $this->assertResponseOk();
        $this->assertResponseStatus(200);

    }

    /**
     *  Test post update function if output is not success
     */
    public function testUpdateIfNotSuccess() 
    {
        $this->withoutMiddleware();

        $postObject = ['id' => 1, 'title' => 'title'];
        $return = [(object)$postObject];
        $input = $this->getPostStoreInput();

        $postRepositoryMock = \Mockery::mock('App\Repositories\v1\PostRepository');
        $postRepositoryMock->shouldReceive('update')
            ->once()->withAnyArgs([])->andReturn(false);
        $this->app->instance('App\Repositories\v1\PostRepository', $postRepositoryMock);

        $response = $this->call('PUT', 'post/3', $input);
        $this->assertResponseStatus(400);

    } 

    /**
     *  Test post update function if output is success
     */
    public function testDestoryIfSuccess() 
    {
        $this->withoutMiddleware();

        $postObject = ['id' => 1, 'title' => 'title'];
        $return = [(object)$postObject];
        $input = $this->getPostStoreInput();

        $postRepositoryMock = \Mockery::mock('App\Repositories\v1\PostRepository');
        $postRepositoryMock->shouldReceive('update')
            ->once()->withAnyArgs([])->andReturn(true);
        $this->app->instance('App\Repositories\v1\PostRepository', $postRepositoryMock);

        $response = $this->call('DELETE', 'post/3', $input);
        $this->assertResponseOk();
        $this->assertResponseStatus(200);

    }

    /**
     *  Test post update function if delete is not success
     */
    public function testDeleteIfNotSuccess() 
    {
        $this->withoutMiddleware();

        $postObject = ['id' => 1, 'title' => 'title'];
        $return = [(object)$postObject];
        $input = $this->getPostStoreInput();

        $postRepositoryMock = \Mockery::mock('App\Repositories\v1\PostRepository');
        $postRepositoryMock->shouldReceive('update')
            ->once()->withAnyArgs([])->andReturn(false);
        $this->app->instance('App\Repositories\v1\PostRepository', $postRepositoryMock);

        $response = $this->call('DELETE', 'post/3', $input);
        $this->assertResponseStatus(400);

    } 

}
