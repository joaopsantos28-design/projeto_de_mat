<?php

namespace Controller;

use Exception;
use Model\CalculoModel;

class CalculoController
{
    //private CalculoModel $calculoModel;

    public function __construct(private CalculoModel $calculoModel)
    {
        //$this->calculoModel = new CalculoModel();
    }

    public function somar(array $a, array $b): array
    {
        try {
            return $this->calculoModel->somar($a, $b);
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    public function subtrair(array $a, array $b): array
    {
        try {
            return $this->calculoModel->subtrair($a, $b);
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    public function multiplicar(array $a, array $b): array
    {
        try {
            return $this->calculoModel->multiplicar($a, $b);
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    public function transpor(array $matriz): array
    {
        try {
            return $this->calculoModel->transpor($matriz);
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    public function determinante(array $matriz): float|array
    {
        try {
            return $this->calculoModel->determinante($matriz);
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    public function resolverSistema(array $matriz, array $resultados): array
    {
        try {
            return $this->calculoModel->resolverSistema($matriz, $resultados);
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }
}