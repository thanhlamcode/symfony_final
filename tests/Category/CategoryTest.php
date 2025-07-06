<?php

namespace App\Tests\Category;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class CategoryTest extends ApiTestCase
{
    private \ApiPlatform\Symfony\Bundle\Test\Client $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->disableReboot(); // giữ state DB giữa các request
    }

    private function createCategory(array $data = []): array
    {
        $response = $this->client->request('POST', '/api/categories', [
            'headers' => [
                'Accept' => 'application/ld+json',
                'Content-Type' => 'application/ld+json',
            ],
            'json' => array_merge([
                'name' => 'Coffee',
                'description' => 'All types of coffee products',
                'status' => 'active',
            ], $data),
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        return $response->toArray();
    }

    public function testCreateCategory(): void
    {
        $data = $this->createCategory();

        $this->assertArrayHasKey('@id', $data); // Sửa 'id' → '@id' vì API Platform trả về theo định dạng Hydra
        $this->assertSame('Coffee', $data['name']);
        $this->assertSame('active', $data['status']);
    }

    public function testGetCategory(): void
    {
        $category = $this->createCategory();

        $this->client->request('GET', $category['@id'], [
            'headers' => ['Accept' => 'application/ld+json'],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'name' => 'Coffee',
            'description' => 'All types of coffee products',
            'status' => 'active',
        ]);
    }

    public function testGetCategoryCollection(): void
    {
        $this->createCategory(['name' => 'Espresso']);
        $this->createCategory(['name' => 'Latte']);

        $this->client->request('GET', '/api/categories', [
            'headers' => ['Accept' => 'application/ld+json'],
        ]);

        $this->assertArrayHasKey('@type', $this->client->getResponse()->toArray());

    }

    public function testDeleteCategory(): void
    {
        $category = $this->createCategory();

        $this->client->request('DELETE', $category['@id'], [
            'headers' => ['Accept' => 'application/ld+json'],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $category['@id'], [
            'headers' => ['Accept' => 'application/ld+json'],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testInvalidStatusThrows422(): void
    {
        $this->client->request('POST', '/api/categories', [
            'headers' => [
                'Accept' => 'application/ld+json',
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                'name' => 'Invalid',
                'status' => 'deleted',
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
