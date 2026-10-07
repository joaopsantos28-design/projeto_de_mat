<?php

use PHPUnit\Framework\TestCase;

use Controller\CalculoController;
use Model\CalculoModel;

class CalculoTest extends TestCase {
    private $mockCalculoModel;
    private $calculoController;

    protected function setUp(): void {
        $this->mockCalculoModel = $this->createMock(CalculoModel::class);
        $this->calculoController = new CalculoController($this->mockCalculoModel);
    }

    #[\PHPUnit\Framework\Attributes\Test]
public function it_should_register_matrices()
{
    $result = $this->calculoController->somar(
        [[1, 2]],
        [[3, 4]]
    );

    $this->assertEquals([[4, 6]], $result);
}

#[\PHPUnit\Framework\Attributes\Test]
public function it_should_accept_valid_matrices()
    {
        $result = $this->calculoController->somar(
            [[1, 2]],
            [[3, 4]]
        );

        $this->assertNotEmpty($result);
    }

#[\PHPUnit\Framework\Attributes\Test]
public function it_should_add_matrices()
    {
        $result = $this->calculoController->somar(
            [[1, 2]],
            [[3, 4]]
        );

        $this->assertEquals([[4, 6]], $result);
    }

#[\PHPUnit\Framework\Attributes\Test]
#[\PHPUnit\Framework\Attributes\Test]
#[\PHPUnit\Framework\Attributes\Test]
#[\PHPUnit\Framework\Attributes\Test]
#[\PHPUnit\Framework\Attributes\Test]
#[\PHPUnit\Framework\Attributes\Test]






}