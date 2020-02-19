<?php declare(strict_types=1);

namespace Tests\integration;

class PermisosTest extends TestCase
{
    private static $id;

    public function testCreatePermisos()
    {
        $params = [
                '' => '',
                'id_rol' => 1,
		'id_operacion' => 1,
        ];
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/permisos');
        $request = $request->withParsedBody($params);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetPermisoss()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/permisos');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetPermisos()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/permisos/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetPermisosNotFound()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/permisos/123456789');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdatePermisos()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('PUT', '/permisos/' . self::$id);
        $request = $request->withParsedBody(['' => '']);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testDeletePermisos()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('DELETE', '/permisos/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
