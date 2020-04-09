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
            throw new UsuariosException('No se a encontrado ningun usuario con ese ID.', 404);
        }
        return $usuarios;
    }

    public function checkByEmail(string $email)
    {
        $query = 'SELECT * FROM `usuarios` WHERE `correo` = :email';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('email', $email);
        $statement->execute();
        $user = $statement->fetchObject();
        if (empty(!$user)) {
            throw new UsuariosException('El correo electronico ya existe, por favor intente con otro.', 400);
        }
    }    
   
    public function getAllUsuarios(): array
    {
        $query = 'SELECT `id`, `nombre`, `correo` FROM `usuarios` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        $usuarios = $statement->fetchAll();
        if (empty($usuarios)) {
            throw new UsuariosException('No existe ningun registro de usuarios.', 404);
        }
        return $usuarios;
    }

    public function getAll(): array
    {
        $query = 'SELECT `id`, `nombre`, `correo` FROM `usuarios` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query); 
        $statement->execute();
        return  $statement->fetchAll();       
    }

    public function getUsuario(int $usuarioId)
    {
        $query = 'SELECT `id`, `nombre`, `correo` FROM `usuarios` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuarioId);
        $statement->execute();
        $usuario = $statement->fetchObject();
        if (empty($usuario)) {
            throw new UsuariosException('No se a encontrado ningun registro del usuario.', 404);
        }
        return $usuario;
    }

    public function create($usuarios)
    {
        $query = 'INSERT INTO `usuarios` (`correo`, `clave`, `nombre`) VALUES (:correo, :clave, :nombre)';
        $statement = $this->getDb()->prepare($query); 
        $statement->bindParam('correo', $usuarios->correo);
        $statement->bindParam('clave', $usuarios->clave);  
        $statement->bindParam('nombre', $usuarios->nombre);
        $statement->execute();
        return $this->checkAndGet((int) $this->getDb()->lastInsertId());
    }

    public function update($usuarios)
    {   
        $query = 'UPDATE `usuarios` SET `correo` = :correo, `nombre` = :nombre WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuarios->id);      
        $statement->bindParam('correo', $usuarios->correo);   
        $statement->bindParam('nombre', $usuarios->nombre);
        $statement->execute();
        return $this->checkAndGet((int) $usuarios->id);
    }

    public function delete(int $usuariosId)
    {
        $query = 'DELETE FROM `usuarios` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuariosId);
        $statement->execute();
        return 'El Usuario fue eliminado exitosamente.';
    }

    public function search($usuariosNombre): array
    {
        $query = $this->getSearchQuery();
        $nombres = '%' . $usuariosNombre . '%';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('nombre', $nombre);
        $statement->execute();
        $usuarios = $statement->fetchAll();
        if (!$usuarios) {
            throw new UsuariosException('No se a encontrado ningun registro de Usuarios con esos Nombres.', 404);
        }
        return $usuarios;
    }

    private function getSearchQuery()
    {        
        return "
            SELECT `id`, `nombre`, `correo` FROM `usuarios`
            WHERE `nombre` LIKE :nombre
            ORDER BY `id`
        ";
    }

    public function login(string $email, string $password)
    {
        $query = 'SELECT `id`, `nombre`, `correo` FROM `usuarios` WHERE `correo` = :email AND `clave` = :password ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('email', $email);
        $statement->bindParam('password', $password);
        $statement->execute();
        $usuario = $statement->fetchObject();
        if (empty($usuario)) {
            throw new UsuariosException('Error de inicio de sesión: correo electrónico o contraseña incorrectos.', 400);
        }
        return $usuario;
    }

    public function changePassword($usuarios)
    {   
        $query = 'UPDATE `usuarios` SET `clave` = :clave WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuarios->id);
        $statement->bindParam('clave', $usuarios->clave);
        $statement->execute();
        return $this->checkAndGet((int) $usuarios->id);
    }

    public function changeRole($usuarios)
    {   
        $query = 'UPDATE `usuarios` SET `id_rol` = :rol WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuarios->id);
        $statement->bindParam('rol', $usuarios->id_rol);
        $statement->execute();
        return $this->checkAndGet((int) $usuarios->id);
    }
}
