<?php

namespace Controller;

use Model\CalculoModel;
use Exception;

class CalculoController
{
    public function __construct(
        private CalculoModel $calculoModel
    ) {}

    public function ProcessRequest(string $method, ?string $id = null): void
    {
        try {
            if ($id !== null) {
                $this->processItemRequest($method, $id);
            } else {
                $this->processCollectionRequest($method);
            }
        } catch (Exception $e) {
            http_response_code(400);

            echo json_encode([
                "erro" => $e->getMessage()
            ]);
        }
    }

    private function processCollectionRequest(string $method): void
    {
        switch ($method) {

            case "GET":
                $calculos = $this->calculoModel->getAll();

                http_response_code(200);

                echo json_encode($calculos);
                break;

            case "POST":
                $data = json_decode(
                    file_get_contents("php://input"),
                    true
                );

                if (
                    !isset($data["operacao"]) ||
                    !isset($data["entrada"]) ||
                    !isset($data["resultado"])
                ) {
                    throw new Exception(
                        "Operação, entrada e resultado são obrigatórios."
                    );
                }

                $id = $this->calculoModel->create(
                    $data["operacao"],
                    $data["entrada"],
                    $data["resultado"]
                );

                http_response_code(201);

                echo json_encode([
                    "mensagem" => "Cálculo registrado com sucesso.",
                    "id" => $id
                ]);
                break;

            default:
                http_response_code(405);

                echo json_encode([
                    "erro" => "Método não permitido."
                ]);
        }
    }

    private function processItemRequest(
        string $method,
        string $id
    ): void {
        switch ($method) {

            case "GET":
                $calculo = $this->calculoModel->getById($id);

                if (!$calculo) {
                    http_response_code(404);

                    echo json_encode([
                        "erro" => "Cálculo não encontrado."
                    ]);

                    return;
                }

                http_response_code(200);

                echo json_encode($calculo);
                break;

            case "DELETE":
                $this->calculoModel->delete($id);

                http_response_code(200);

                echo json_encode([
                    "mensagem" => "Cálculo excluído com sucesso."
                ]);
                break;

            default:
                http_response_code(405);

                echo json_encode([
                    "erro" => "Método não permitido."
                ]);
        }
    }
}