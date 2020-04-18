<?php

declare(strict_types=1);

namespace Tests\integration;

class UserTest extends BaseTestCase
{
    private static $id;

    /**
     * Test Get All Users.
     */
    public function testGetUsers()
    {
        $response = $this->runApp('GET', '/api/v1/users');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('nombres', $result);
        $this->assertStringContainsString('correo', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get One User.
     */
    public function testGetUser()
    {
        $response = $this->runApp('GET', '/api/v1/users/1');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('nombres', $result);
        $this->assertStringContainsString('apellidos', $result);
        $this->assertStringContainsString('correo', $result);
        $this->assertStringContainsString('rol_id', $result);
        $this->assertStringContainsString('rol_nombre', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get User Not Found.
     */
    public function testGetUserNotFound()
    {
        $response = $this->runApp('GET', '/api/v1/users/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('nombres', $result);
        $this->assertStringNotContainsString('apellidos', $result);
        $this->assertStringNotContainsString('correo', $result);
        $this->assertStringNotContainsString('rol_id', $result);
        $this->assertStringNotContainsString('rol_nombre', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Search Users.
     */
    public function testSearchUsers()
    {
        $response = $this->runApp('GET', '/api/v1/users/search/j');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('nombres', $result);
        $this->assertStringContainsString('apellidos', $result);
        $this->assertStringContainsString('correo', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Search User Not Found.
     */
    public function testSearchUserNotFound()
    {
        $response = $this->runApp('GET', '/api/v1/users/search/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('correo', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create User.
     */
    public function testCreateUser()
    {
        $response = $this->runApp(
            'POST', '/api/v1/users',
            [
                'correo' => 'fercalmet@gmail.com', 
                'clave' => 'clave123',
                'dni' => '12345678',
                'nombres' => 'Fernando',                
                'apellidos' => 'Calmet', 
                'telefono' => '999999999',
                'genero' => 'hombre',
                'interes' => 'mujer',
                'fecha_nacimiento' => '1989-06-09'
            ]
        );

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->message->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);        
        $this->assertStringContainsString('correo', $result);
        $this->assertStringContainsString('dni', $result);
        $this->assertStringContainsString('nombres', $result);
        $this->assertStringContainsString('apellidos', $result);
        $this->assertStringContainsString('telefono', $result);
        $this->assertStringContainsString('genero', $result);
        $this->assertStringContainsString('interes', $result);
        $this->assertStringContainsString('fecha_nacimiento', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get User Created.
     */
    public function testGetUserCreated()
    {
        $response = $this->runApp('GET', '/api/v1/users/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('nombres', $result);
        $this->assertStringContainsString('apellidos', $result);
        $this->assertStringContainsString('correo', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Create User Without Name.
     */
    public function testCreateUserWithoutName()
    {
        $response = $this->runApp('POST', '/api/v1/users');

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('correo', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create User Without Email.
     */
    public function testCreateUserWithoutEmail()
    {
        $response = $this->runApp('POST', '/api/v1/users', ['nombres' => 'z']);

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create User With Invalid Name.
     */
    public function testCreateUserWithInvalidName()
    {
        $response = $this->runApp(
            'POST', '/api/v1/users',
            [                 
                'correo' => 'fercalmet@gmail.com', 
                'clave' => 'clave123',
                'dni' => '12345678',
                'nombres' => 'z',               
                'apellidos' => 'Calmet', 
                'telefono' => '999999999',
                'genero' => 'hombre',
                'interes' => 'mujer',
                'fecha_nacimiento' => '1989-06-09'
            ]
        );

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('correo', $result);
        $this->assertStringNotContainsString('dni', $result);
        $this->assertStringNotContainsString('apellidos', $result);
        $this->assertStringNotContainsString('telefono', $result);
        $this->assertStringNotContainsString('genero', $result);
        $this->assertStringNotContainsString('interes', $result);
        $this->assertStringNotContainsString('fecha_nacimiento', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create User With Invalid Email.
     */
    public function testCreateUserWithInvalidEmail()
    {
        $response = $this->runApp(
            'POST', '/api/v1/users',
            [
                'correo' => 'email.incorrecto', 
                'clave' => 'clave123',
                'dni' => '12345678',
                'nombres' => 'z',               
                'apellidos' => 'Calmet', 
                'telefono' => '999999999',
                'genero' => 'hombre',
                'interes' => 'mujer',
                'fecha_nacimiento' => '1989-06-09'              
            ]
        );

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create User With An Email That Already Exists.
     */
    public function testCreateUserWithEmailAlreadyExists()
    {
        $response = $this->runApp(
            'POST', '/api/v1/users',
            [              
                'correo' => 'fercalmet@gmail.com', 
                'clave' => 'clave123',
                'dni' => '12345678',
                'nombres' => 'z',               
                'apellidos' => 'Calmet', 
                'telefono' => '999999999',
                'genero' => 'hombre',
                'interes' => 'mujer',
                'fecha_nacimiento' => '1989-06-09' 
            ]
        );

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Update User.
     */
    public function testUpdateUser()
    {
        $response0 = $this->runApp('POST', '/login', [
            'correo' => 'fercalmet@gmail.com', 
            'clave' => 'clave123'
        ]);
        $result0 = (string) $response0->getBody();
        self::$jwt = json_decode($result0)->message->Authorization;

        $response = $this->runApp('PUT', '/api/v1/users/' . self::$id, [            
            'correo' => 'fercalmet@gmail.com',
            'clave' => 'clave456', 
            'nombres' => 'Andres', 
            'apellidos' => 'Calmet', 
            'telefono' => '999999999',
            'genero' => 'hombre',
            'interes' => 'mujer'
        ]);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('correo', $result);
        $this->assertStringContainsString('clave', $result);
        $this->assertStringContainsString('nombres', $result);
        $this->assertStringContainsString('apellidos', $result);
        $this->assertStringContainsString('telefono', $result);
        $this->assertStringContainsString('genero', $result);
        $this->assertStringContainsString('interes', $result);    
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Update User Without Send Data.
     */
    public function testUpdateUserWithOutSendData()
    {
        $response = $this->runApp('PUT', '/api/v1/users/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('correo', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Update User Permissions Failed.
     */
    public function testUpdateUserPermissionsFailed()
    {
        $response = $this->runApp(
            'PUT', '/api/v1/users/1', ['nombres' => 'Khanakat']
        );

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringNotContainsString('nombres', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Update User With Invalid Data.
     */
    public function testUpdateUserWithInvalidData()
    {
        $response = $this->runApp(
            'PUT', '/api/v1/users/' . self::$id,
            [                
                'correo' => 'email-incorrecto...',
                'clave' => 'f', 
                'nombres' => 'a', 
                'apellidos' => 'z', 
                'telefono' => '5',
                'genero' => 'x',
                'interes' => 'y'
            ]
        );

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('correo', $result);
        $this->assertStringNotContainsString('clave', $result);
        $this->assertStringNotContainsString('nombres', $result);
        $this->assertStringNotContainsString('apellidos', $result);
        $this->assertStringNotContainsString('telefono', $result);
        $this->assertStringNotContainsString('genero', $result);
        $this->assertStringNotContainsString('interes', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Delete User.
     */
    public function testDeleteUser()
    {
        $response = $this->runApp('DELETE', '/api/v1/users/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Delete User Permissions Failed.
     */
    public function testDeleteUserPermissionsFailed()
    {
        $response = $this->runApp('DELETE', '/api/v1/users/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test that user login endpoint it is working fine.
     */
    public function testLoginUser()
    {
        $response = $this->runApp('POST', '/login', [
            'correo' => 'fercalmet@gmail.com', 
            'clave' => 'clave123'
        ]);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('status', $result);
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('message', $result);
        $this->assertStringContainsString('Authorization', $result);
        $this->assertStringContainsString('Bearer', $result);
        $this->assertStringContainsString('ey', $result);
        $this->assertStringNotContainsString('ERROR', $result);
        $this->assertStringNotContainsString('Failed', $result);
    }

    /**
     * Test login endpoint with invalid credentials.
     */
    public function testLoginUserFailed()
    {
        $response = $this->runApp('POST', '/login', ['correo' => 'a@b.com', 'clave' => 'p']);

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('Login failed', $result);
        $this->assertStringContainsString('UserException', $result);
        $this->assertStringContainsString('error', $result);
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('Authorization', $result);
        $this->assertStringNotContainsString('Bearer', $result);
    }

    /**
     * Test login endpoint without send required field email.
     */
    public function testLoginWithoutEmailField()
    {
        $response = $this->runApp('POST', '/login', ['clave' => 'p']);

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('UserException', $result);
        $this->assertStringContainsString('error', $result);
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('Authorization', $result);
        $this->assertStringNotContainsString('Bearer', $result);
    }

    /**
     * Test login endpoint without send required field password.
     */
    public function testLoginWithoutPasswordField()
    {
        $response = $this->runApp('POST', '/login', ['correo' => 'a@b.com']);

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('UserException', $result);
        $this->assertStringContainsString('error', $result);
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('Authorization', $result);
        $this->assertStringNotContainsString('Bearer', $result);
    }
}
