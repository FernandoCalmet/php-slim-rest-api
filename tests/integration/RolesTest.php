<?php declare(strict_types=1);

namespace Tests\integration;

class RolesTest extends TestCase
{
    private static $id;

    public function testCreateRoles()
    {
        $params = [
                '' => '',
                'nombre' => 'aaa',
        ];
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/roles');
        $request = $request->withParsedBody($params);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetRoless()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/roles');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetRoles()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/roles/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetRolesNotFound()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/roles/123456789');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdateRoles()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('PUT', '/roles/' . self::$id);
        $request = $request->withParsedBody(['' => '']);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testDeleteRoles()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('DELETE', '/roles/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
