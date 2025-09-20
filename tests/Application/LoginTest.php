<?php

namespace App\Tests\Application;

use App\Access\Fixtures\Test\UserFixtures;
use App\Tests\E2EWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends E2EWebTestCase
{
    private const HTTP_UNAUTHORIZED_BODY = '{"code":401,"message":"Invalid credentials."}';
    private const LOGIN_ENDPOINT = '/api/login';

    private const LOGIN_IDENTIFIER_FIELD = 'email';
    private const LOGIN_PASSWORD_FIELD = 'password';
    public function testLoginWithValidCredentials(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            self::LOGIN_ENDPOINT,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                self::LOGIN_IDENTIFIER_FIELD => UserFixtures::TEST_USER_EMAIL,
                self::LOGIN_PASSWORD_FIELD => UserFixtures::TEST_USER_PASSWORD,
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function testLoginWithNotValidCredentials(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            self::LOGIN_ENDPOINT,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                self::LOGIN_IDENTIFIER_FIELD => '',
                self::LOGIN_PASSWORD_FIELD => '',
            ])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJsonStringEqualsJsonString(
            self::HTTP_UNAUTHORIZED_BODY,
            $client->getResponse()->getContent()
        );
    }
}
