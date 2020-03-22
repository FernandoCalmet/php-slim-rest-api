<?php

declare(strict_types=1);

namespace Tests\integration;

class UsuariosTest extends TestCase
{
    private static $id;

    public function testCreate()
    {
        $params = [
            '' => '',
            'id_rol' => 1,
            'correo' => 'aaa',
            'clave' => 'aaa',
            'dni' => 1,
            'nombres' => 'aaa',
            'apellidos' => 'aaa',
            'telefono' => 1,
        ];
        $app = $this->getAppInstance();
        $req = $this->createRequest('POST', '/usuarios');
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
        $request = $this->createRequest('GET', '/usuarios');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOne()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/usuarios/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOneNotFound()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/usuarios/123456789');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdate()
    {
        $app = $this->getAppInstance();
        $req = $this->createRequest('PUT', '/usuarios/' . self::$id);
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
        $request = $this->createRequest('DELETE', '/usuarios/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
