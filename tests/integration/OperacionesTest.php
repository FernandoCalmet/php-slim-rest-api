<?php declare(strict_types=1);

namespace Tests\integration;

class OperacionesTest extends TestCase
{
    private static $id;

    public function testCreateOperaciones()
    {
        $params = [
                '' => '',
                'nombre' => 'aaa',
		'id_modulo' => 1,
        ];
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/operaciones');
        $request = $request->withParsedBody($params);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOperacioness()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/operaciones');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOperaciones()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/operaciones/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOperacionesNotFound()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/operaciones/123456789');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdateOperaciones()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('PUT', '/operaciones/' . self::$id);
        $request = $request->withParsedBody(['' => '']);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testDeleteOperaciones()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('DELETE', '/operaciones/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
