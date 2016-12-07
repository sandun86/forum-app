<?php

/**
 * @file  UserControllerTest.php
 *
 * UserControllerTest TestCase
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

// class UserControllerTest extends TestCase {


//     private function getUserStoreInput() {
//         $input = [
//             'first_name'       => 'Sandun',
//             'last_name'        => 'Dissanayake',
//             'password'         => '1234567890',
//             'confirm_password' => '1234567890',
//             'email'            => 'sandunccc@gmail.com',
//         ];

//         return $input;
//     }

//     /**
//      *  Test user store function if output is success
//      */
//     public function testStoreIfSuccess() {
//         $this->withoutMiddleware();

//         $userObject = ['id' => 1, 'first_name' => 'Sandun'];
//         $return = [(object)$userObject];
//         $input = $this->getUserStoreInput();

//         $usersRepositoryMock = \Mockery::mock('App\Repositories\v1\UserRepository');
//         $usersRepositoryMock->shouldReceive('create')
//             ->once()->with($input)->andReturn($return);
//         $this->app->instance('App\Repositories\v1\UserRepository', $usersRepositoryMock);

//         $response = $this->call('POST', 'user', $input);
//         $this->assertResponseOk();
//         $this->assertResponseStatus(200);

//     }

 

// }
