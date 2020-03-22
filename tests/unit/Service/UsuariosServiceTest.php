<?php declare(strict_types=1);

namespace Tests\integration;

class UsuariosServiceTest extends BaseTestCase
{
    private static $id;

    private function getDatabase()
    {
        $database = sprintf('mysql:host=%s;dbname=%s', getenv('DB_HOSTNAME'), getenv('DB_DATABASE'));

        return new \PDO($database, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    }

    public function testGetUsuario()
    {
        $usuariosRepository = new \App\Repository\UsuariosRepository($this->getDatabase());
        $redisService = new \App\Service\RedisService(new \Predis\Client());
        $usuariosService = new \App\Service\UsuariosService($usuariosRepository, $redisService);
        $usuario = $usuariosService->getOne(1);
        $this->assertStringContainsString('Fernando', $usuario->name);
    }

    public function testCreateUsuario()
    {
        $usuariosRepository = new \App\Repository\UsuariosRepository($this->getDatabase());
        $redisService = new \App\Service\RedisService(new \Predis\Client());
        $usuariosService = new \App\Service\UsuariosService($usuariosRepository, $redisService);
        $input = ['name' => 'Fernando', 'email' => 'fercalmet@gmail.com', 'password' => 'ClavePrueba123'];
        $usuario = $usuariosService->create($input);
        self::$id = $usuario->id;
        $this->assertStringContainsString('Fernando', $usuario->name);
    }

    public function testCreateUsuarioWithoutNameExpectError()
    {
        $this->expectException(\App\Exception\UsuariosException::class);

        $usuariosRepository = new \App\Repository\UsuariosRepository($this->getDatabase());
        $redisService = new \App\Service\RedisService(new \Predis\Client());
        $usuariosService = new \App\Service\UsuariosService($usuariosRepository, $redisService);
        $input = ['email' => 'fercalmet@gmail.com', 'password' => 'ClavePrueba123'];
        $usuario = $usuariosService->create($input);
        self::$id = $usuario->id;
        $this->assertStringContainsString('Fernando', $usuario->name);
    }

    public function testDeleteUsuario()
    {
        $usuariosRepository = new \App\Repository\UsuariosRepository($this->getDatabase());
        $redisService = new \App\Service\RedisService(new \Predis\Client());
        $usuariosService = new \App\Service\UsuariosService($usuariosRepository, $redisService);
        $usuarioId = self::$id;
        $usuario = $usuariosService->delete((int) $usuarioId);
        $this->assertStringContainsString('The user was deleted.', $usuario);
    }
}
