<?php

declare(strict_types=1);

namespace Tests\integration;

class RoleTest extends BaseTestCase
{
    /**
     * @var int
     */
    private static $id;

    /**
     * Test Get All Roles.
     */
    public function testGetRoles(): void
    {
        $response = $this->runApp('GET', '/api/v1/roles');

        $result = (string) $response->getBody();
        $value = json_encode(json_decode($result));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('name', $result);
        $this->assertStringContainsString('description', $result);
        $this->assertMatchesRegularExpression('{"code":200,"status":"success"}', $value);
        $this->assertMatchesRegularExpression('{"name":"[A-Za-z0-9_. ]+","description":"[A-Za-z0-9_. ]+"}', $value);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get One Role.
     */
    public function testGetRole(): void
    {
        $response = $this->runApp('GET', '/api/v1/roles/1');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('name', $result);
        $this->assertStringContainsString('description', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get Role Not Found.
     */
    public function testGetRoleNotFound(): void
    {
        $response = $this->runApp('GET', '/api/v1/roles/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('description', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Search Roles.
     */
    public function testSearchRoles(): void
    {
        $response = $this->runApp('GET', '/api/v1/roles/search/n');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('description', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Search Role Not Found.
     */
    public function testSearchRoleNotFound(): void
    {
        $response = $this->runApp('GET', '/api/v1/roles/search/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Role.
     */
    public function testCreateRole(): void
    {
        $response = $this->runApp(
            'POST', '/api/v1/roles',
            ['name' => 'My Test Role', 'description' => 'New Role...']
        );

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->message->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('name', $result);
        $this->assertStringContainsString('description', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get Role Created.
     */
    public function testGetRoleCreated(): void
    {
        $response = $this->runApp('GET', '/api/v1/roles/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('name', $result);
        $this->assertStringContainsString('description', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Create Role Without Name.
     */
    public function testCreateRoleWithoutName(): void
    {
        $response = $this->runApp('POST', '/api/v1/roles');

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('description', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Role With Invalid Name.
     */
    public function testCreateRoleWithInvalidName(): void
    {
        $response = $this->runApp(
            'POST', '/api/v1/roles',
            ['name' => 'z']
        );

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('description', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Update Role.
     */
    public function testUpdateRole(): void
    {
        $response = $this->runApp(
            'PUT', '/api/v1/roles/' . self::$id,
            ['name' => 'Victor Roles', 'description' => 'Pep.']
        );

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('name', $result);
        $this->assertStringContainsString('description', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Update Role Without Send Data.
     */
    public function testUpdateRoleWithOutSendData(): void
    {
        $response = $this->runApp('PUT', '/api/v1/roles/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('name', $result);
        $this->assertStringNotContainsString('description', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Update Role Not Found.
     */
    public function testUpdateRoleNotFound(): void
    {
        $response = $this->runApp(
            'PUT', '/api/v1/roles/123456789', ['name' => 'Role']
        );

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('name', $result);
        $this->assertStringNotContainsString('description', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Delete Role.
     */
    public function testDeleteRole(): void
    {
        $response = $this->runApp('DELETE', '/api/v1/roles/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Delete Role Not Found.
     */
    public function testDeleteRoleNotFound(): void
    {
        $response = $this->runApp('DELETE', '/api/v1/roles/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('name', $result);
        $this->assertStringNotContainsString('description', $result);
        $this->assertStringContainsString('error', $result);
    }
}
