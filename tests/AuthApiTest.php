<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthApiTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testRegisterUser(): void
    {
        $this->client->request('POST', '/api/auth/register', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'test@example.com',
            'password' => 'password123',
            'confirmPassword' => 'password123',
            'role' => 'ROLE_USER'
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('email', $responseData);
        $this->assertEquals('test@example.com', $responseData['email']);
    }

    public function testRegisterUserWithMismatchedPasswords(): void
    {
        $this->client->request('POST', '/api/auth/register', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'test2@example.com',
            'password' => 'password123',
            'confirmPassword' => 'differentpassword',
            'role' => 'ROLE_USER'
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testLoginUser(): void
    {
        // First register a user
        $this->client->request('POST', '/api/auth/register', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'login@example.com',
            'password' => 'password123',
            'confirmPassword' => 'password123',
            'role' => 'ROLE_USER'
        ]));

        // Then try to login
        $this->client->request('POST', '/api/auth/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'login@example.com',
            'password' => 'password123'
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        
        $this->assertArrayHasKey('token', $responseData);
        $this->assertArrayHasKey('user', $responseData);
        $this->assertEquals('login@example.com', $responseData['user']['email']);
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $this->client->request('POST', '/api/auth/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword'
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetCurrentUser(): void
    {
        // First register and login to get a token
        $this->client->request('POST', '/api/auth/register', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'me@example.com',
            'password' => 'password123',
            'confirmPassword' => 'password123',
            'role' => 'ROLE_USER'
        ]));

        $this->client->request('POST', '/api/auth/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'me@example.com',
            'password' => 'password123'
        ]));

        $loginResponse = json_decode($this->client->getResponse()->getContent(), true);
        $token = $loginResponse['token'];

        // Now test the /me endpoint
        $this->client->request('GET', '/api/auth/me', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token,
            'CONTENT_TYPE' => 'application/json',
        ]);

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        
        $this->assertArrayHasKey('user', $responseData);
        $this->assertEquals('me@example.com', $responseData['user']['email']);
    }

    public function testGetCurrentUserWithoutToken(): void
    {
        $this->client->request('GET', '/api/auth/me', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testRefreshToken(): void
    {
        // First register and login to get a token
        $this->client->request('POST', '/api/auth/register', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'refresh@example.com',
            'password' => 'password123',
            'confirmPassword' => 'password123',
            'role' => 'ROLE_USER'
        ]));

        $this->client->request('POST', '/api/auth/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'refresh@example.com',
            'password' => 'password123'
        ]));

        $loginResponse = json_decode($this->client->getResponse()->getContent(), true);
        $originalToken = $loginResponse['token'];

        // Now test the refresh endpoint
        $this->client->request('POST', '/api/auth/refresh', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'token' => $originalToken
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        
        $this->assertArrayHasKey('token', $responseData);
        $this->assertArrayHasKey('user', $responseData);
        $this->assertNotEquals($originalToken, $responseData['token']);
    }

    public function testLogout(): void
    {
        $this->client->request('POST', '/api/auth/logout', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'token' => 'some.jwt.token'
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('success', $responseData);
        $this->assertTrue($responseData['success']);
    }
} 