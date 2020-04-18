<?php

declare(strict_types=1);

namespace Tests\integration;

class ModuleTest extends BaseTestCase
{
    private static $id;

    /**
     * Test Get All Modules.
     */
    public function testGetModules()
    {
        $response = $this->runApp('GET', '/api/v1/modules');

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
     * Test Get One Module.
     */
    public function testGetModule()
    {
        $response = $this->runApp('GET', '/api/v1/modules/1');

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
     * Test Get Module Not Found.
     */
    public function testGetModuleNotFound()
    {
        $response = $this->runApp('GET', '/api/v1/modules/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('description', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Search Modules.
     */
    public function testSearchModules()
    {
        $response = $this->runApp('GET', '/api/v1/modules/search/n');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('description', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Search Module Not Found.
     */
    public function testSearchModuleNotFound()
    {
        $response = $this->runApp('GET', '/api/v1/modules/search/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Module.
     */
    public function testCreateModule()
    {
        $response = $this->runApp(
            'POST', '/api/v1/modules',
            ['name' => 'My Test Module', 'description' => 'New Module...']
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
     * Test Get Module Created.
     */
    public function testGetModuleCreated()
    {
        $response = $this->runApp('GET', '/api/v1/modules/' . self::$id);

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
     * Test Create Module Without Name.
     */
    public function testCreateModuleWithoutName()
    {
        $response = $this->runApp('POST', '/api/v1/modules');

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('description', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Module With Invalid Name.
     */
    public function testCreateModuleWithInvalidName()
    {
        $response = $this->runApp(
            'POST', '/api/v1/modules',
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
     * Test Update Module.
     */
    public function testUpdateModule()
    {
        $response = $this->runApp(
            'PUT', '/api/v1/modules/' . self::$id,
            ['name' => 'Victor Modules', 'description' => 'Pep.']
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
     * Test Update Module Without Send Data.
     */
    public function testUpdateModuleWithOutSendData()
    {
        $response = $this->runApp('PUT', '/api/v1/modules/' . self::$id);

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
     * Test Update Module Not Found.
     */
    public function testUpdateModuleNotFound()
    {
        $response = $this->runApp(
            'PUT', '/api/v1/modules/123456789', ['name' => 'Module']
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
     * Test Delete Module.
     */
    public function testDeleteModule()
    {
        $response = $this->runApp('DELETE', '/api/v1/modules/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Delete Module Not Found.
     */
    public function testDeleteModuleNotFound()
    {
        $response = $this->runApp('DELETE', '/api/v1/modules/123456789');

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
