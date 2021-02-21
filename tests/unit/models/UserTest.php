<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('makmur');

        expect_not(User::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('1-token'));
        expect($user->username)->equals('makmur');

        expect_not(User::findIdentityByAccessToken('non-existing'));        
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('makmur'));
        expect_not(User::findByUsername('not-makmur'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('makmur');
        expect_that($user->validateAuthKey('test1key'));
        expect_not($user->validateAuthKey('test2key'));

        expect_that($user->validatePassword('makmur'));
        expect_not($user->validatePassword('123456'));        
    }

}
