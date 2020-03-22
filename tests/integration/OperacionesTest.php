<?php

declare(strict_types=1);

namespace Tests\integration;

class OperacionesTest extends TestCase
{
    private static $id;

    public function testCreate()
    {
        $params = [
            '' => '',
            'id_modulo' => 1,
            'nombre' => 'aaa',
        ];
        $app = $this->getAppInstance();
        $req = $this->createRequest('POST', '/operaciones');
        $request = $req->withParsedBody($params);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetAll()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/operaciones');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOne()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/operaciones/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOneNotFound()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/operaciones/123456789');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdate()
    {
        $app = $this->getAppInstance();
        $req = $this->createRequest('PUT', '/operaciones/' . self::$id);
        $request = $req->withParsedBody(['' => '']);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testDelete()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('DELETE', '/operaciones/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
