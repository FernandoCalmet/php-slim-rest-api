<?php

declare(strict_types=1);

namespace Tests\integration;

class PermissionTest extends BaseTestCase
{
    /**
     * @var int
     */
    private static $id;

    /**
     * Test Get All Permissions.
     */
    public function testGetPermissions(): void
    {
        $response = $this->runApp('GET', '/api/v1/permissions');

        $result = (string) $response->getBody();
        $value = json_encode(json_decode($result));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('role_id', $result);
        $this->assertStringContainsString('operation_id', $result);
        $this->assertMatchesRegularExpression('{"code":200,"status":"success"}', $value);
        $this->assertMatchesRegularExpression('{"role_id":"[0-9]","operation_id":"[0-9]"}', $value);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get One Permission.
     */
    public function testGetPermission(): void
    {
        $response = $this->runApp('GET', '/api/v1/permissions/1');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('role_id', $result);
        $this->assertStringContainsString('operation_id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get Permission Not Found.
     */
    public function testGetPermissionNotFound(): void
    {
        $response = $this->runApp('GET', '/api/v1/permissions/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('operation_id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Search Permissions.
     */
    public function testSearchPermissions(): void
    {
        $response = $this->runApp('GET', '/api/v1/permissions/search/1');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('operation_id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Search Permission Not Found.
     */
    public function testSearchPermissionNotFound(): void
    {
        $response = $this->runApp('GET', '/api/v1/permissions/search/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Permission.
     */
    public function testCreatePermission(): void
    {
        $response = $this->runApp(
            'POST', '/api/v1/permissions',
            ['role_id' => 1, 'operation_id' => 1]
        );

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->message->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('role_id', $result);
        $this->assertStringContainsString('operation_id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get Permission Created.
     */
    public function testGetPermissionCreated(): void
    {
        $response = $this->runApp('GET', '/api/v1/permissions/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('role_id', $result);
        $this->assertStringContainsString('operation_id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Create Permission Without Name.
     */
    public function testCreatePermissionWithoutName(): void
    {
        $response = $this->runApp('POST', '/api/v1/permissions');

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('operation_id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Permission With Invalid Name.
     */
    public function testCreatePermissionWithInvalidName(): void
    {
        $response = $this->runApp(
            'POST', '/api/v1/permissions',
            ['role_id' => 'z']
        );

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('operation_id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Update Permission.
     */
    public function testUpdatePermission(): void
    {
        $response = $this->runApp(
            'PUT', '/api/v1/permissions/' . self::$id,
            ['role_id' => 2, 'operation_id' => 2]
        );

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('role_id', $result);
        $this->assertStringContainsString('operation_id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Update Permission Without Send Data.
     */
    public function testUpdatePermissionWithOutSendData(): void
    {
        $response = $this->runApp('PUT', '/api/v1/permissions/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('role_id', $result);
        $this->assertStringNotContainsString('operation_id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Update Permission Not Found.
     */
    public function testUpdatePermissionNotFound(): void
    {
        $response = $this->runApp(
            'PUT', '/api/v1/permissions/123456789', ['role_id' => 'Permission']
        );

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('role_id', $result);
        $this->assertStringNotContainsString('operation_id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Delete Permission.
     */
    public function testDeletePermission(): void
    {
        $response = $this->runApp('DELETE', '/api/v1/permissions/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Delete Permission Not Found.
     */
    public function testDeletePermissionNotFound(): void
    {
        $response = $this->runApp('DELETE', '/api/v1/permissions/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('role_id', $result);
        $this->assertStringNotContainsString('operation_id', $result);
        $this->assertStringContainsString('error', $result);
    }
}
