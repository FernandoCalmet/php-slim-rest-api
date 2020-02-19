<?php declare(strict_types=1);

namespace App\Repository;

use App\Exception\UsuariosException;

class UsuariosRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGetUsuarios(int $usuariosId)
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

    public function getAllUsuarios(): array
    {
        $query = 'SELECT * FROM `usuarios` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function createUsuarios($usuarios)
    {
        $query = 'INSERT INTO `usuarios` (`id`, `correo`, `clave`, `nombre`, `id_rol`) VALUES (:id, :correo, :clave, :nombre, :id_rol)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuarios->id);
	$statement->bindParam('correo', $usuarios->correo);
	$statement->bindParam('clave', $usuarios->clave);
	$statement->bindParam('nombre', $usuarios->nombre);
	$statement->bindParam('id_rol', $usuarios->id_rol);
        $statement->execute();

        return $this->checkAndGetUsuarios((int) $this->getDb()->lastInsertId());
    }

    public function updateUsuarios($usuarios, $data)
    {
        if (isset($data->correo)) { $usuarios->correo = $data->correo; }
        if (isset($data->clave)) { $usuarios->clave = $data->clave; }
        if (isset($data->nombre)) { $usuarios->nombre = $data->nombre; }
        if (isset($data->id_rol)) { $usuarios->id_rol = $data->id_rol; }

        $query = 'UPDATE `usuarios` SET `correo` = :correo, `clave` = :clave, `nombre` = :nombre, `id_rol` = :id_rol WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuarios->id);
	$statement->bindParam('correo', $usuarios->correo);
	$statement->bindParam('clave', $usuarios->clave);
	$statement->bindParam('nombre', $usuarios->nombre);
	$statement->bindParam('id_rol', $usuarios->id_rol);
        $statement->execute();

        return $this->checkAndGetUsuarios((int) $usuarios->id);
    }

    public function deleteUsuarios(int $usuariosId)
    {
        $query = 'DELETE FROM `usuarios` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $usuariosId);
        $statement->execute();
    }
}
