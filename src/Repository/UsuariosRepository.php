<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\UsuariosException;

class UsuariosRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGet(int $usuariosId)
    {
        $query = 'SELECT * FROM `usuarios` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuariosId);
        $statement->execute();
        $usuarios = $statement->fetchObject();
        if (empty($usuarios)) {
            throw new UsuariosException('Usuarios not found.', 404);
        }

        return $usuarios;
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM `usuarios` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function create($usuarios)
    {
        $query = 'INSERT INTO `usuarios` (`id`, `id_rol`, `correo`, `clave`, `dni`, `nombres`, `apellidos`, `telefono`, `genero`, `interes`, `foto`, `fecha_nacimiento`, `fecha_registro`, `fecha_modificacion`, `estado`) VALUES (:id, :id_rol, :correo, :clave, :dni, :nombres, :apellidos, :telefono, :genero, :interes, :foto, :fecha_nacimiento, :fecha_registro, :fecha_modificacion, :estado)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuarios->id);
	    $statement->bindParam('id_rol', $usuarios->id_rol);
        $statement->bindParam('correo', $usuarios->correo);
        $statement->bindParam('clave', $usuarios->clave);
        $statement->bindParam('dni', $usuarios->dni);
        $statement->bindParam('nombres', $usuarios->nombres);
        $statement->bindParam('apellidos', $usuarios->apellidos);
        $statement->bindParam('telefono', $usuarios->telefono);
        $statement->bindParam('genero', $usuarios->genero);
        $statement->bindParam('interes', $usuarios->interes);
        $statement->bindParam('foto', $usuarios->foto);
        $statement->bindParam('fecha_nacimiento', $usuarios->fecha_nacimiento);
        $statement->bindParam('fecha_registro', $usuarios->fecha_registro);
        $statement->bindParam('fecha_modificacion', $usuarios->fecha_modificacion);
        $statement->bindParam('estado', $usuarios->estado);

        $statement->execute();

        return $this->checkAndGet((int) $this->getDb()->lastInsertId());
    }

    public function update($usuarios, $data)
    {
        if (isset($data->id_rol)) { $usuarios->id_rol = $data->id_rol; }
        if (isset($data->correo)) { $usuarios->correo = $data->correo; }
        if (isset($data->clave)) { $usuarios->clave = $data->clave; }
        if (isset($data->dni)) { $usuarios->dni = $data->dni; }
        if (isset($data->nombres)) { $usuarios->nombres = $data->nombres; }
        if (isset($data->apellidos)) { $usuarios->apellidos = $data->apellidos; }
        if (isset($data->telefono)) { $usuarios->telefono = $data->telefono; }
        if (isset($data->genero)) { $usuarios->genero = $data->genero; }
        if (isset($data->interes)) { $usuarios->interes = $data->interes; }
        if (isset($data->foto)) { $usuarios->foto = $data->foto; }
        if (isset($data->fecha_nacimiento)) { $usuarios->fecha_nacimiento = $data->fecha_nacimiento; }
        if (isset($data->fecha_registro)) { $usuarios->fecha_registro = $data->fecha_registro; }
        if (isset($data->fecha_modificacion)) { $usuarios->fecha_modificacion = $data->fecha_modificacion; }
        if (isset($data->estado)) { $usuarios->estado = $data->estado; }


        $query = 'UPDATE `usuarios` SET `id_rol` = :id_rol, `correo` = :correo, `clave` = :clave, `dni` = :dni, `nombres` = :nombres, `apellidos` = :apellidos, `telefono` = :telefono, `genero` = :genero, `interes` = :interes, `foto` = :foto, `fecha_nacimiento` = :fecha_nacimiento, `fecha_registro` = :fecha_registro, `fecha_modificacion` = :fecha_modificacion, `estado` = :estado WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuarios->id);
        $statement->bindParam('id_rol', $usuarios->id_rol);
        $statement->bindParam('correo', $usuarios->correo);
        $statement->bindParam('clave', $usuarios->clave);
        $statement->bindParam('dni', $usuarios->dni);
        $statement->bindParam('nombres', $usuarios->nombres);
        $statement->bindParam('apellidos', $usuarios->apellidos);
        $statement->bindParam('telefono', $usuarios->telefono);
        $statement->bindParam('genero', $usuarios->genero);
        $statement->bindParam('interes', $usuarios->interes);
        $statement->bindParam('foto', $usuarios->foto);
        $statement->bindParam('fecha_nacimiento', $usuarios->fecha_nacimiento);
        $statement->bindParam('fecha_registro', $usuarios->fecha_registro);
        $statement->bindParam('fecha_modificacion', $usuarios->fecha_modificacion);
        $statement->bindParam('estado', $usuarios->estado);

        $statement->execute();

        return $this->checkAndGet((int) $usuarios->id);
    }

    public function delete(int $usuariosId)
    {
        $query = 'DELETE FROM `usuarios` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuariosId);
        $statement->execute();
    }

    public function search(string $usersName): array
    {
        $query = 'SELECT `id`, `nombres`, `correo` FROM `usuarios` WHERE `nombres` LIKE :name ORDER BY `id`';
        $name = '%' . $usersName . '%';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('name', $name);
        $statement->execute();
        $users = $statement->fetchAll();
        if (!$users) {
            throw new UsuariosException('User name not found.', 404);
        }

        return $users;
    }

    public function loginUsuario(string $email, string $password)
    {
        $query = 'SELECT * FROM `usuarios` WHERE `correo` = :email AND `clave` = :password ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('email', $email);
        $statement->bindParam('password', $password);
        $statement->execute();
        $usuarios = $statement->fetchObject();
        if (empty($usuarios)) {
            throw new UsuariosException('Login failed: Email or password incorrect.', 400);
        }

        return $usuarios;
    }
}
