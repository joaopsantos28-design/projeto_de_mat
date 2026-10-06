<?php

namespace Model;

use Model\Connection;

use PDO;
use PDOException;

class CalculoModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        $sql = "SELECT * FROM calculos ORDER BY data_calculo DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getById(int $id): ?array {
        $sql = "SELECT * FROM calculos WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function create(string $operacao, string $entrada, string $resultado): int {
        $sql = "INSERT INTO calculos (operacao, entrada, resultado) VALUES (:operacao, :entrada, :resultado)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':operacao', $operacao);
        $stmt->bindParam(':entrada', $entrada);
        $stmt->bindParam(':resultado', $resultado);

        if ($stmt->execute()) {
            return (int)$this->db->lastInsertId();
        } else {
            throw new PDOException("Erro ao criar o cálculo.");
        }
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM calculos WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute([
            "id" => $id
        ]);
    }
}