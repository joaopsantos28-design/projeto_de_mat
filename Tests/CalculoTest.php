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
    public function it_should_be_able_to_process_get_request() {
        
    }
}