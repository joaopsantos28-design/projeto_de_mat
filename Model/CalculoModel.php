<?php

namespace Model;

use Model\Connection;

use PDO;
use PDOException;

class CalculoModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM calculos ORDER BY data_calculo DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM calculos WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $calculo = $stmt->fetch(PDO::FETCH_ASSOC);

        return $calculo ?: null;
    }

    public function create(
        string $operacao,
        string $entrada,
        string $resultado
    ): int {
        $sql = "INSERT INTO calculos 
                (operacao, entrada, resultado)
                VALUES 
                (:operacao, :entrada, :resultado)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            "operacao" => $operacao,
            "entrada" => $entrada,
            "resultado" => $resultado
        ]);

        return (int) $this->db->lastInsertId();
    }


     public function delete(int $id): bool
    {
        $sql = "DELETE FROM calculos WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            "id" => $id
        ]);
    }
}