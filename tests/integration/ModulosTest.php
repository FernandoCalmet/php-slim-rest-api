<?php declare(strict_types=1);

namespace Tests\integration;

class ModulosTest extends TestCase
{
    private static $id;

    public function testCreateModulos()
    {
        $params = [
                '' => '',
                'nombre' => 'aaa',
        ];
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/modulos');
        $request = $request->withParsedBody($params);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetModuloss()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/modulos');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetModulos()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/modulos/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetModulosNotFound()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/modulos/123456789');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdateModulos()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('PUT', '/modulos/' . self::$id);
        $request = $request->withParsedBody(['' => '']);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testDeleteModulos()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('DELETE', '/modulos/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
