<?php

use Model\CalculoModel;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Controller\CalculoController;
use Model\Calculo;

class CalculoTest extends TestCase
{
    private CalculoModel $calculo;
    private CalculoController $calculoController;

    protected function setUp(): void
    {
        $this->calculo = new Calculo();

        $this->calculoController = new CalculoController(
            $this->calculo
        );
    }

    #[Test]
    public function it_should_register_matrices()
    {
        $result = $this->calculoController->somar(
            [[1, 2]],
            [[3, 4]]
        );

        $this->assertEquals(
            [[4, 6]],
            $result
        );
    }

    #[Test]
    public function it_should_accept_valid_matrices()
    {
        $result = $this->calculoController->somar(
            [[1, 2]],
            [[3, 4]]
        );

        $this->assertNotEmpty($result);
    }

    #[Test]
    public function it_should_add_matrices()
    {
        $result = $this->calculoController->somar(
            [[1, 2]],
            [[3, 4]]
        );

        $this->assertEquals(
            [[4, 6]],
            $result
        );
    }

    #[Test]
    public function it_should_subtract_matrices()
    {
        $result = $this->calculoController->subtrair(
            [[5, 6]],
            [[2, 3]]
        );

        $this->assertEquals(
            [[3, 3]],
            $result
        );
    }

    #[Test]
    public function it_should_multiply_matrices()
    {
        $result = $this->calculoController->multiplicar(
            [[1, 2]],
            [[3], [4]]
        );

        $this->assertEquals(
            [[11]],
            $result
        );
    }

    #[Test]
    public function it_should_transpose_matrix()
    {
        $result = $this->calculoController->transpor(
            [[1, 2], [3, 4]]
        );

        $this->assertEquals(
            [[1, 3], [2, 4]],
            $result
        );
    }

    #[Test]
    public function it_should_calculate_determinant()
    {
        $result = $this->calculoController->determinante(
            [[1, 2], [3, 4]]
        );

        $this->assertEqualsWithDelta(
            -2,
            $result,
            0.0001
        );
    }

    #[Test]
    public function it_should_solve_linear_system()
    {
        $result = $this->calculoController->resolverSistema(
            [[2, 1], [1, -1]],
            [5, 1]
        );

        $this->assertEqualsWithDelta(
            [2, 1],
            $result,
            0.0001
        );
    }

    #[Test]
    public function it_should_reject_invalid_data()
    {
        $result = $this->calculoController->somar(
            [[1, 2]],
            [[1, 2], [3, 4]]
        );

        $this->assertEquals(
            'As matrizes devem possuir as mesmas dimensões.',
            $result['erro']
        );
    }

    #[Test]
    public function it_should_calculate_decimal_values()
    {
        $result = $this->calculoController->somar(
            [[1.5]],
            [[2.5]]
        );

        $this->assertEqualsWithDelta(
            [[4.0]],
            $result,
            0.0001
        );
    }

    #[Test]
    public function it_should_process_1x1_matrix()
    {
        $result = $this->calculoController->determinante(
            [[5]]
        );

        $this->assertEqualsWithDelta(
            5,
            $result,
            0.0001
        );
    }

    #[Test]
    public function it_should_process_zero_matrix()
    {
        $result = $this->calculoController->somar(
            [[0, 0]],
            [[0, 0]]
        );

        $this->assertEquals(
            [[0, 0]],
            $result
        );
    }

    #[Test]
    public function it_should_process_identity_matrix()
    {
        $result = $this->calculoController->multiplicar(
            [[1, 2], [3, 4]],
            [[1, 0], [0, 1]]
        );

        $this->assertEquals(
            [[1, 2], [3, 4]],
            $result
        );
    }

    #[Test]
    public function it_should_handle_division_by_zero()
    {
        $result = $this->calculoController->resolverSistema(
            [[0, 0], [0, 0]],
            [1, 2]
        );

        $this->assertEquals(
            'Sistema impossível ou indeterminado.',
            $result['erro']
        );
    }
}