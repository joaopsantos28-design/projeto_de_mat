<?php


require_once 'vendor/autoload.php';
session_start();

use Controller\CalculoController;
use Model\CalculoModel;
use Model\Connection;

$calculoController = new CalculoController(
    new CalculoModel(Connection::getInstance())
);

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cálculo de Matrizes</title>

    <link rel="stylesheet" href="../templates/style.css">
</head>

<body>

    <header class="cabecalho">
        <h1>Cálculo de Matrizes</h1>
        <p>Operações de Álgebra Linear</p>
    </header>

    <main class="container">

        <section class="card">

            <h2>Calculadora</h2>

            <div class="campo">
                <label for="operacao">Escolha a operação</label>

                <select id="operacao">
                    <option value="">Selecione</option>
                    <option value="soma">Soma</option>
                    <option value="subtracao">Subtração</option>
                    <option value="multiplicacao">Multiplicação</option>
                    <option value="transposta">Transposição</option>
                    <option value="determinante">Determinante</option>
                    <option value="sistema">Sistema Linear</option>
                </select>
            </div>

            <div class="matrizes">

                <div class="matriz">
                    <h3>Matriz A</h3>

                    <textarea
                        id="matrizA"
                        placeholder="Exemplo:
1 2
3 4"></textarea>
                </div>

                <div class="matriz">
                    <h3>Matriz B</h3>

                    <textarea
                        id="matrizB"
                        placeholder="Exemplo:
5 6
7 8"></textarea>
                </div>

            </div>

            <button class="btn-calcular">
                Calcular
            </button>

        </section>

        <section class="resultado">

            <h2>Resultado</h2>

            <div class="resultado-box">
                <p id="resultado">
                    O resultado aparecerá aqui.
                </p>
            </div>

        </section>

    </main>

    <footer>
        <p>Projeto de Álgebra Linear</p>
    </footer>

</body>
</html>