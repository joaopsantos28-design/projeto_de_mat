<?php

namespace Controller;

use Exception;
use Model\CalculoModel;


class CalculoController
{
    private const EPSILON = 1e-12;

    public function __construct(private CalculoModel $calculoModel)
    {
    }

    /* ------------------------------------------------------------------
     * Operações (a lógica matemática fica no Controller, como no fitCalc;
     * o Model só cuida de salvar/buscar no banco)
     * ------------------------------------------------------------------ */

    /**
     * Soma duas matrizes de mesma dimensão.
     */
    public function somar(array $a, array $b): array
    {
        try {
            $a = $this->normalizarMatriz($a);
            $b = $this->normalizarMatriz($b);
            $this->exigirMesmasDimensoes($a, $b);

            $resultado = [];
            foreach ($a as $i => $linha) {
                foreach ($linha as $j => $valor) {
                    $resultado[$i][$j] = $valor + $b[$i][$j];
                }
            }

            return $resultado;
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    /**
     * Subtrai duas matrizes de mesma dimensão (A - B).
     */
    public function subtrair(array $a, array $b): array
    {
        try {
            $a = $this->normalizarMatriz($a);
            $b = $this->normalizarMatriz($b);
            $this->exigirMesmasDimensoes($a, $b);

            $resultado = [];
            foreach ($a as $i => $linha) {
                foreach ($linha as $j => $valor) {
                    $resultado[$i][$j] = $valor - $b[$i][$j];
                }
            }

            return $resultado;
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    /**
     * Multiplica A (m x n) por B (n x p).
     */
    public function multiplicar(array $a, array $b): array
    {
        try {
            $a = $this->normalizarMatriz($a);
            $b = $this->normalizarMatriz($b);

            if (count($a[0]) !== count($b)) {
                throw new Exception(
                    'O número de colunas da primeira matriz deve ser igual ao número de linhas da segunda.'
                );
            }

            $linhas = count($a);
            $colunas = count($b[0]);
            $comum = count($b);
            $resultado = [];

            for ($i = 0; $i < $linhas; $i++) {
                for ($j = 0; $j < $colunas; $j++) {
                    $soma = 0;
                    for ($k = 0; $k < $comum; $k++) {
                        $soma += $a[$i][$k] * $b[$k][$j];
                    }
                    $resultado[$i][$j] = $soma;
                }
            }

            return $resultado;
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    /**
     * Transposta de uma matriz qualquer.
     */
    public function transpor(array $matriz): array
    {
        try {
            $matriz = $this->normalizarMatriz($matriz);

            $resultado = [];
            foreach ($matriz as $i => $linha) {
                foreach ($linha as $j => $valor) {
                    $resultado[$j][$i] = $valor;
                }
            }

            return $resultado;
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    /**
     * Determinante de uma matriz quadrada (eliminação de Gauss com pivoteamento).
     */
    public function determinante(array $matriz): float|array
    {
        try {
            $matriz = $this->normalizarMatriz($matriz);
            $this->exigirQuadrada($matriz);

            $n = count($matriz);
            $m = $this->paraFloat($matriz);
            $det = 1.0;

            for ($i = 0; $i < $n; $i++) {
                $pivo = $i;
                for ($r = $i + 1; $r < $n; $r++) {
                    if (abs($m[$r][$i]) > abs($m[$pivo][$i])) {
                        $pivo = $r;
                    }
                }

                if (abs($m[$pivo][$i]) < self::EPSILON) {
                    return 0.0;
                }

                if ($pivo !== $i) {
                    [$m[$i], $m[$pivo]] = [$m[$pivo], $m[$i]];
                    $det = -$det;
                }

                $det *= $m[$i][$i];

                for ($r = $i + 1; $r < $n; $r++) {
                    $fator = $m[$r][$i] / $m[$i][$i];
                    for ($c = $i; $c < $n; $c++) {
                        $m[$r][$c] -= $fator * $m[$i][$c];
                    }
                }
            }

            return round($det, 10);
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    /**
     * Resolve A·x = b (Gauss-Jordan com pivoteamento parcial).
     * Retorna a lista [x1, x2, ...].
     */
    public function resolverSistema(array $matriz, array $resultados): array
    {
        try {
            $matriz = $this->normalizarMatriz($matriz);
            $this->exigirQuadrada($matriz);

            $n = count($matriz);
            $resultados = array_values($resultados);

            if (count($resultados) !== $n) {
                throw new Exception(
                    'O vetor de resultados deve ter o mesmo número de linhas da matriz.'
                );
            }

            foreach ($resultados as $valor) {
                if (!is_numeric($valor)) {
                    throw new Exception('O vetor de resultados deve conter apenas valores numéricos.');
                }
            }

            // Matriz aumentada [A | b]
            $aug = $this->paraFloat($matriz);
            foreach ($aug as $i => $linha) {
                $aug[$i][] = (float) $resultados[$i];
            }

            for ($i = 0; $i < $n; $i++) {
                $pivo = $i;
                for ($r = $i + 1; $r < $n; $r++) {
                    if (abs($aug[$r][$i]) > abs($aug[$pivo][$i])) {
                        $pivo = $r;
                    }
                }

                if (abs($aug[$pivo][$i]) < self::EPSILON) {
                    throw new Exception('Sistema impossível ou indeterminado.');
                }

                if ($pivo !== $i) {
                    [$aug[$i], $aug[$pivo]] = [$aug[$pivo], $aug[$i]];
                }

                $divisor = $aug[$i][$i];
                for ($c = $i; $c <= $n; $c++) {
                    $aug[$i][$c] /= $divisor;
                }

                for ($r = 0; $r < $n; $r++) {
                    if ($r === $i) {
                        continue;
                    }
                    $fator = $aug[$r][$i];
                    for ($c = $i; $c <= $n; $c++) {
                        $aug[$r][$c] -= $fator * $aug[$i][$c];
                    }
                }
            }

            $solucao = [];
            for ($i = 0; $i < $n; $i++) {
                $solucao[] = round($aug[$i][$n], 10);
            }

            return $solucao;
        } catch (Exception $e) {
            return ['erro' => $e->getMessage()];
        }
    }

    /* ------------------------------------------------------------------
     * Persistência e exibição
     * ------------------------------------------------------------------ */

    /**
     * Salva o cálculo no histórico (via Model). Retorna o id gerado.
     */
    public function salvarCalculo(string $operacao, array $entrada, array|int|float $resultado): int
    {
        return $this->calculoModel->create(
            $operacao,
            json_encode($entrada),
            json_encode($resultado)
        );
    }

    /**
     * Converte o resultado de uma operação em texto para exibir na tela.
     */
    public function formatarResultado(array|int|float $resultado): string
    {
        if (is_int($resultado) || is_float($resultado)) {
            return $this->formatarNumero($resultado);
        }

        if (isset($resultado['erro'])) {
            return 'Erro: ' . $resultado['erro'];
        }

        if (empty($resultado)) {
            return '';
        }

        // Matriz (lista de linhas)
        if (is_array(reset($resultado))) {
            $linhas = array_map(
                fn(array $linha) => implode(' ', array_map([$this, 'formatarNumero'], $linha)),
                $resultado
            );
            return implode("\n", $linhas);
        }

        // Solução de sistema linear (lista de incógnitas)
        $partes = [];
        foreach (array_values($resultado) as $i => $valor) {
            $partes[] = 'x' . ($i + 1) . ' = ' . $this->formatarNumero($valor);
        }
        return implode(', ', $partes);
    }

    /* ------------------------------------------------------------------
     * Auxiliares privados (validações)
     * ------------------------------------------------------------------ */

    /**
     * Valida a matriz e devolve uma cópia com índices 0..n.
     * @throws Exception
     */
    private function normalizarMatriz(array $matriz): array
    {
        if (count($matriz) === 0) {
            throw new Exception('A matriz não pode estar vazia.');
        }

        $colunas = null;
        $normalizada = [];

        foreach ($matriz as $linha) {
            if (!is_array($linha) || count($linha) === 0) {
                throw new Exception('A matriz não pode estar vazia.');
            }

            $colunas ??= count($linha);
            if (count($linha) !== $colunas) {
                throw new Exception('Todas as linhas da matriz devem ter o mesmo número de colunas.');
            }

            foreach ($linha as $valor) {
                if (!is_numeric($valor)) {
                    throw new Exception('A matriz deve conter apenas valores numéricos.');
                }
            }

            $normalizada[] = array_values($linha);
        }

        return $normalizada;
    }

    /** @throws Exception */
    private function exigirMesmasDimensoes(array $a, array $b): void
    {
        if (count($a) !== count($b) || count($a[0]) !== count($b[0])) {
            throw new Exception('As matrizes devem possuir as mesmas dimensões.');
        }
    }

    /** @throws Exception */
    private function exigirQuadrada(array $matriz): void
    {
        if (count($matriz) !== count($matriz[0])) {
            throw new Exception('A matriz deve ser quadrada.');
        }
    }

    private function paraFloat(array $matriz): array
    {
        return array_map(fn(array $linha) => array_map('floatval', $linha), $matriz);
    }

    private function formatarNumero(int|float|string $numero): string
    {
        $texto = rtrim(rtrim(number_format((float) $numero, 4, '.', ''), '0'), '.');

        return ($texto === '' || $texto === '-0') ? '0' : $texto;
    }
}