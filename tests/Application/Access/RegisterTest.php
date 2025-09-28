<?php

declare(strict_types=1);

namespace App\Tests\Application\Access;

use App\Access\Application\Exception\UserWithAlreadyExistsException;
use App\Access\Infrastructure\Fixtures\Test\UserFixtures;
use App\Tests\E2EWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterTest extends E2EWebTestCase
{
    private const REGISTER_ENDPOINT = '/api/auth/register';

    private const LOGIN_IDENTIFIER_FIELD = 'email';
    private const LOGIN_PASSWORD_FIELD = 'password';
    private const NEW_TEST_USER_EMAIL = 'test@example2.com';


    public function testRegisterWithValidCredentials(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            self::REGISTER_ENDPOINT,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                self::LOGIN_IDENTIFIER_FIELD => self::NEW_TEST_USER_EMAIL,
                self::LOGIN_PASSWORD_FIELD => UserFixtures::TEST_USER_PASSWORD,
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function testRegisterWithNotValidCredentials(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            self::REGISTER_ENDPOINT,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                self::LOGIN_IDENTIFIER_FIELD => '',
                self::LOGIN_PASSWORD_FIELD => '',
            ])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    public function testRegisterExistCredentials(): void
    {
        $client = static::createClient();

        $client->request(
            Request::METHOD_POST,
            self::REGISTER_ENDPOINT,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                self::LOGIN_IDENTIFIER_FIELD => UserFixtures::TEST_USER_EMAIL,
                self::LOGIN_PASSWORD_FIELD => UserFixtures::TEST_USER_PASSWORD,
            ])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CONFLICT);

        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $expectedJson = json_encode([
            'message' => UserWithAlreadyExistsException::MESSAGE,
        ]);
        $this->assertJsonStringEqualsJsonString(
            $expectedJson,
            $client->getResponse()->getContent()
        );
    }
}
