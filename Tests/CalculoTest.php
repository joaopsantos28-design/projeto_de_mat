<?php

use Controller\CalculoController;
use Model\CalculoModel;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CalculoTest extends TestCase
{
    // NUNCA USE O BANCO DE DADOS REAL: o mock é um Model "fake" só para testes
    private $mockCalculoModel;
    private CalculoController $calculoController;

    // Executa ANTES de CADA teste
    protected function setUp(): void
    {
        $this->mockCalculoModel = $this->createMock(CalculoModel::class);

        $this->calculoController = new CalculoController($this->mockCalculoModel);
    }

    /* ---------------- ID 1 / ID 2 — Cadastro e validação ---------------- */

    #[Test]
    public function it_should_be_able_to_save_calculation()
    {
        $entrada = [[[1, 2]], [[3, 4]]];
        $resultado = $this->calculoController->somar([[1, 2]], [[3, 4]]);

        $this->mockCalculoModel
            ->expects($this->once())
            ->method('create')
            ->with('soma', json_encode($entrada), json_encode($resultado))
            ->willReturn(1);

        $id = $this->calculoController->salvarCalculo('soma', $entrada, $resultado);

        $this->assertSame(1, $id);
    }

    #[Test]
    public function it_should_accept_valid_matrices()
    {
        $result = $this->calculoController->somar([[1, 2]], [[3, 4]]);

        $this->assertNotEmpty($result);
        $this->assertArrayNotHasKey('erro', $result);
    }

    /* ---------------- ID 3 — Soma ---------------- */

    #[Test]
    public function it_should_add_matrices()
    {
        $result = $this->calculoController->somar([[1, 2]], [[3, 4]]);

        $this->assertEquals([[4, 6]], $result);
    }

    #[Test]
    public function it_shouldnt_add_matrices_with_different_dimensions()
    {
        $result = $this->calculoController->somar([[1, 2]], [[1, 2], [3, 4]]);

        $this->assertEquals('As matrizes devem possuir as mesmas dimensões.', $result['erro']);
    }

    /* ---------------- ID 4 — Subtração ---------------- */

    #[Test]
    public function it_should_subtract_matrices()
    {
        $result = $this->calculoController->subtrair([[5, 6]], [[2, 3]]);

        $this->assertEquals([[3, 3]], $result);
    }

    #[Test]
    public function it_shouldnt_subtract_matrices_with_different_dimensions()
    {
        $result = $this->calculoController->subtrair([[1, 2, 3]], [[1, 2]]);

        $this->assertEquals('As matrizes devem possuir as mesmas dimensões.', $result['erro']);
    }

    /* ---------------- ID 5 — Multiplicação ---------------- */

    #[Test]
    public function it_should_multiply_matrices()
    {
        $result = $this->calculoController->multiplicar([[1, 2]], [[3], [4]]);

        $this->assertEquals([[11]], $result);
    }

    #[Test]
    public function it_should_multiply_2x2_matrices()
    {
        $result = $this->calculoController->multiplicar(
            [[1, 2], [3, 4]],
            [[5, 6], [7, 8]]
        );

        $this->assertEquals([[19, 22], [43, 50]], $result);
    }

    #[Test]
    public function it_shouldnt_multiply_incompatible_matrices()
    {
        $result = $this->calculoController->multiplicar([[1, 2]], [[1, 2]]);

        $this->assertEquals(
            'O número de colunas da primeira matriz deve ser igual ao número de linhas da segunda.',
            $result['erro']
        );
    }

    /* ---------------- ID 6 — Transposição ---------------- */

    #[Test]
    public function it_should_transpose_matrix()
    {
        $result = $this->calculoController->transpor([[1, 2], [3, 4]]);

        $this->assertEquals([[1, 3], [2, 4]], $result);
    }

    #[Test]
    public function it_should_transpose_non_square_matrix()
    {
        $result = $this->calculoController->transpor([[1, 2, 3]]);

        $this->assertEquals([[1], [2], [3]], $result);
    }

    /* ---------------- ID 7 — Determinante ---------------- */

    #[Test]
    public function it_should_calculate_determinant()
    {
        $result = $this->calculoController->determinante([[1, 2], [3, 4]]);

        $this->assertEqualsWithDelta(-2, $result, 0.0001);
    }

    #[Test]
    public function it_should_calculate_3x3_determinant()
    {
        $result = $this->calculoController->determinante([
            [6, 1, 1],
            [4, -2, 5],
            [2, 8, 7],
        ]);

        $this->assertEqualsWithDelta(-306, $result, 0.0001);
    }

    #[Test]
    public function it_shouldnt_calculate_determinant_of_non_square_matrix()
    {
        $result = $this->calculoController->determinante([[1, 2, 3], [4, 5, 6]]);

        $this->assertEquals('A matriz deve ser quadrada.', $result['erro']);
    }

    /* ---------------- ID 8 — Sistema linear ---------------- */

    #[Test]
    public function it_should_solve_linear_system()
    {
        $result = $this->calculoController->resolverSistema(
            [[2, 1], [1, -1]],
            [5, 1]
        );

        $this->assertEqualsWithDelta([2, 1], $result, 0.0001);
    }

    #[Test]
    public function it_should_solve_3x3_linear_system()
    {
        $result = $this->calculoController->resolverSistema(
            [[1, 1, 1], [0, 2, 5], [2, 5, -1]],
            [6, -4, 27]
        );

        $this->assertEqualsWithDelta([5, 3, -2], $result, 0.0001);
    }

    #[Test]
    public function it_shouldnt_solve_system_with_wrong_results_size()
    {
        $result = $this->calculoController->resolverSistema([[2, 1], [1, -1]], [5]);

        $this->assertEquals(
            'O vetor de resultados deve ter o mesmo número de linhas da matriz.',
            $result['erro']
        );
    }

    /* ---------------- ID 9 — Dados inválidos ---------------- */

    #[Test]
    public function it_shouldnt_accept_empty_matrix()
    {
        $result = $this->calculoController->somar([], [[1]]);

        $this->assertEquals('A matriz não pode estar vazia.', $result['erro']);
    }

    #[Test]
    public function it_shouldnt_accept_empty_fields()
    {
        $result = $this->calculoController->somar([[1, '']], [[1, 2]]);

        $this->assertEquals('A matriz deve conter apenas valores numéricos.', $result['erro']);
    }

    #[Test]
    public function it_shouldnt_accept_non_numeric_values()
    {
        $result = $this->calculoController->somar([[1, 'abc']], [[1, 2]]);

        $this->assertEquals('A matriz deve conter apenas valores numéricos.', $result['erro']);
    }

    #[Test]
    public function it_shouldnt_accept_matrix_with_uneven_rows()
    {
        $result = $this->calculoController->transpor([[1, 2], [3]]);

        $this->assertEquals(
            'Todas as linhas da matriz devem ter o mesmo número de colunas.',
            $result['erro']
        );
    }

    /* ---------------- ID 10 — Decimais ---------------- */

    #[Test]
    public function it_should_calculate_decimal_values()
    {
        $result = $this->calculoController->somar([[1.5]], [[2.5]]);

        $this->assertEqualsWithDelta([[4.0]], $result, 0.0001);
    }

    #[Test]
    public function it_should_multiply_decimal_values()
    {
        $result = $this->calculoController->multiplicar([[0.5, 1.5]], [[2], [4]]);

        $this->assertEqualsWithDelta([[7.0]], $result, 0.0001);
    }

    #[Test]
    public function it_should_accept_numeric_strings_from_form()
    {
        $result = $this->calculoController->somar([['1.5', '2']], [['2.5', '3']]);

        $this->assertEqualsWithDelta([[4.0, 5.0]], $result, 0.0001);
    }

    /* ---------------- ID 11 — Exibição do resultado ---------------- */

    #[Test]
    public function it_should_format_matrix_result()
    {
        $texto = $this->calculoController->formatarResultado([[1, 2], [3, 4.5]]);

        $this->assertEquals("1 2\n3 4.5", $texto);
    }

    #[Test]
    public function it_should_format_determinant_result()
    {
        $this->assertEquals('-2', $this->calculoController->formatarResultado(-2.0));
    }

    #[Test]
    public function it_should_format_linear_system_result()
    {
        $texto = $this->calculoController->formatarResultado([2.0, 1.0]);

        $this->assertEquals('x1 = 2, x2 = 1', $texto);
    }

    #[Test]
    public function it_should_format_error_result()
    {
        $texto = $this->calculoController->formatarResultado(['erro' => 'A matriz deve ser quadrada.']);

        $this->assertEquals('Erro: A matriz deve ser quadrada.', $texto);
    }

    /* ---------------- ID 12 — Casos especiais ---------------- */

    #[Test]
    public function it_should_process_1x1_matrix()
    {
        $result = $this->calculoController->determinante([[5]]);

        $this->assertEqualsWithDelta(5, $result, 0.0001);
    }

    #[Test]
    public function it_should_process_zero_matrix()
    {
        $result = $this->calculoController->somar([[0, 0]], [[0, 0]]);

        $this->assertEquals([[0, 0]], $result);
    }

    #[Test]
    public function it_should_calculate_determinant_of_zero_matrix()
    {
        $result = $this->calculoController->determinante([[0, 0], [0, 0]]);

        $this->assertEqualsWithDelta(0, $result, 0.0001);
    }

    #[Test]
    public function it_should_process_identity_matrix()
    {
        $result = $this->calculoController->multiplicar(
            [[1, 2], [3, 4]],
            [[1, 0], [0, 1]]
        );

        $this->assertEquals([[1, 2], [3, 4]], $result);
    }

    #[Test]
    public function it_should_calculate_determinant_of_identity_matrix()
    {
        $result = $this->calculoController->determinante([[1, 0], [0, 1]]);

        $this->assertEqualsWithDelta(1, $result, 0.0001);
    }

    /* ---------------- ID 13 — Divisão por zero ---------------- */

    #[Test]
    public function it_should_handle_division_by_zero()
    {
        $result = $this->calculoController->resolverSistema(
            [[0, 0], [0, 0]],
            [1, 2]
        );

        $this->assertEquals('Sistema impossível ou indeterminado.', $result['erro']);
    }

    #[Test]
    public function it_should_handle_singular_system()
    {
        $result = $this->calculoController->resolverSistema(
            [[1, 2], [2, 4]],
            [3, 6]
        );

        $this->assertEquals('Sistema impossível ou indeterminado.', $result['erro']);
    }
}