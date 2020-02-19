<?php declare(strict_types=1);

namespace Tests\integration;

class UsuariosTest extends TestCase
{
    private static $id;

    public function testCreateUsuarios()
    {
        $params = [
                '' => '',
                'correo' => 'aaa',
		'clave' => 'aaa',
		'nombre' => 'aaa',
		'id_rol' => 1,
        ];
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/usuarios');
        $request = $request->withParsedBody($params);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetUsuarioss()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/usuarios');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetUsuarios()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/usuarios/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetUsuariosNotFound()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/usuarios/123456789');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdateUsuarios()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('PUT', '/usuarios/' . self::$id);
        $request = $request->withParsedBody(['' => '']);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testDeleteUsuarios()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('DELETE', '/usuarios/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
