# Projeto de Álgebra Linear

## DEFINIÇÃO DO ESCOPO

Os testes serão realizados nas funcionalidades responsáveis pelas operações com matrizes e resolução de sistemas lineares. O objetivo é garantir que os dados inseridos pelo usuário sejam devidamente processados, que os algoritmos matemáticos apresentem resultados corretos e que situações de erro sejam identificadas e tratadas corretamente.

O objetivo dos testes é garantir que:

● Os dados de uma matriz sejam recebidos e processados corretamente;

● Os valores informados pelo usuário sejam validados;

● As operações matriciais apresentem os resultados esperados;

● A soma de matrizes seja realizada corretamente quando as dimensões forem compatíveis;

● A subtração de matrizes seja realizada corretamente quando as dimensões forem compatíveis;

● A multiplicação de matrizes seja realizada corretamente quando as dimensões forem compatíveis;

● A transposição de uma matriz seja realizada corretamente;

● O cálculo do determinante apresente o resultado correto;

● A resolução de sistemas lineares apresente os valores corretos;

● Sistemas com solução única sejam identificados corretamente;

● Sistemas impossíveis sejam identificados corretamente;

● Sistemas indeterminados sejam identificados corretamente;

● Matrizes de casos-limite, como matriz `1x1`, matriz identidade e matriz nula, sejam processadas corretamente;

● Valores exatamente nos limites das condições matemáticas sejam tratados corretamente;

● Dimensões incompatíveis sejam rejeitadas;

● Valores inválidos sejam rejeitados;

● Campos obrigatórios ausentes sejam identificados;

● Divisões por zero sejam tratadas corretamente;

● Resultados que envolvam números decimais sejam comparados considerando uma margem de tolerância;

● O resultado da operação seja retornado e apresentado na tela para o usuário.

---

# OBJETIVO DOS TESTES

O objetivo dos testes é verificar a corretude dos algoritmos de álgebra linear implementados na aplicação, garantindo que as operações com matrizes e a resolução de sistemas lineares produzam resultados matematicamente corretos.

Os testes também devem verificar situações de erro, casos-limite e entradas inválidas, garantindo que o sistema não execute operações impossíveis ou apresente resultados incorretos.

---

# ABORDAGEM DOS TESTES

Os testes serão realizados utilizando o PHPUnit, framework de testes unitários para a linguagem PHP, com o objetivo de verificar a corretude dos algoritmos responsáveis pelas operações matriciais e pela resolução de sistemas lineares.

Serão utilizados testes para:

● Casos válidos, nos quais os resultados são conhecidos;

● Casos de borda, como matrizes `1x1`, identidade e nula;

● Casos de erro, como dimensões incompatíveis;

● Matrizes singulares;

● Sistemas impossíveis;

● Sistemas indeterminados;

● Entradas inválidas;

● Campos obrigatórios ausentes;

● Resultados envolvendo números de ponto flutuante.

Para os resultados com números decimais, será utilizado `assertEqualsWithDelta()` para considerar uma margem de tolerância adequada.

A cobertura mínima esperada para o código responsável pelos algoritmos será de **80%**.

---

# OS TESTES SERÃO BEM SUCEDIDOS SE

● Os valores inseridos forem válidos e processados corretamente;

● As operações com matrizes apresentarem os resultados esperados;

● Matrizes com dimensões compatíveis forem processadas corretamente;

● Matrizes com dimensões incompatíveis forem rejeitadas;

● Matrizes `1x1` forem processadas corretamente;

● Matrizes identidade apresentarem os resultados esperados;

● Matrizes nulas apresentarem os resultados esperados;

● O determinante seja calculado corretamente;

● Sistemas lineares com solução única apresentem a solução correta;

● Sistemas impossíveis sejam identificados corretamente;

● Sistemas indeterminados sejam identificados corretamente;

● Valores inválidos sejam rejeitados;

● Campos obrigatórios ausentes apresentem mensagem de campo vazio;

● Divisões por zero sejam identificadas e tratadas;

● Os resultados com números decimais sejam considerados corretos dentro da margem de tolerância definida;

● Os testes de integração retornem os resultados esperados;

● O resultado da operação apareça corretamente na tela.

---

# OS TESTES NÃO SERÃO BEM SUCEDIDOS SE

● Valores válidos produzirem resultados incorretos;

● Operações entre matrizes compatíveis forem rejeitadas incorretamente;

● Matrizes incompatíveis forem processadas como válidas;

● O resultado de uma operação matricial estiver incorreto;

● O determinante for calculado incorretamente;

● Sistemas com solução única apresentarem valores incorretos;

● Sistemas impossíveis forem considerados solucionáveis;

● Sistemas indeterminados forem classificados como sistemas de solução única;

● Matrizes singulares forem processadas incorretamente pelo algoritmo utilizado;

● Valores inválidos forem aceitos;

● Campos obrigatórios vazios forem processados como dados válidos;

● O sistema realizar uma divisão por zero sem tratamento;

● Resultados de ponto flutuante forem comparados sem considerar uma margem de tolerância quando necessário;

● Existirem testes PHPUnit falhando;

● O resultado esperado não aparecer na interface da aplicação.

---

# AMBIENTE DE TESTE

O ambiente de teste será configurado em:

● **Editor:** Visual Studio Code;

● **Ambiente de desenvolvimento:** Laravel Herd;

● **Gerenciador de dependências:** Composer;

● **Framework de testes:** PHPUnit;

● **Interface:** HTML5, CSS3 e Bootstrap;

● **Repositório:** GitHub;

● **Linguagem:** PHP 8.4 ou superior;

● **Sistema de testes:** PHPUnit;

● **Sistema operacional:** Windows.

---

# ALGORITMOS TESTADOS

Os principais algoritmos implementados e testados no projeto serão:

● Soma de matrizes;

● Subtração de matrizes;

● Multiplicação de matrizes;

● Transposição de matrizes;

● Cálculo do determinante;

● Resolução de sistemas lineares;

● Classificação de sistemas lineares quanto à existência de solução.

A lista deverá ser atualizada caso novos algoritmos sejam adicionados ao projeto.

---

# EXECUÇÃO DOS TESTES

Após instalar as dependências do projeto utilizando o Composer, os testes poderão ser executados através do comando:

```bash
vendor/bin/phpunit
```

Para visualizar os testes em um formato mais descritivo:

```bash
vendor/bin/phpunit --testdox
```

Os testes deverão ser executados antes da entrega do projeto, garantindo que não existam testes com falha.

---

# COBERTURA DE TESTES

A cobertura será utilizada para verificar quais partes dos algoritmos foram executadas durante os testes.

A exigência mínima definida para o projeto é de:

**80% de cobertura do código dos algoritmos.**

A interface web não será considerada para o cálculo da cobertura mínima.

O relatório de cobertura deverá ser gerado e anexado ao projeto conforme a configuração utilizada no PHPUnit.

---

# USO DE INTELIGÊNCIA ARTIFICIAL

Durante o desenvolvimento do projeto, ferramentas de Inteligência Artificial poderão ser utilizadas apenas como apoio, respeitando as regras estabelecidas na atividade.

A utilização deverá ser registrada em documento separado, informando:

● Ferramenta utilizada;

● Finalidade da utilização;

● Trechos de código que receberam auxílio;

● Alterações realizadas pelo aluno.

O aluno será responsável por compreender e explicar todo o código apresentado no projeto.

---

# RESULTADOS ESPERADOS

Ao final do desenvolvimento, espera-se que a aplicação:

● Permita inserir os dados necessários para as operações;

● Execute corretamente os algoritmos de álgebra linear;

● Apresente os resultados na interface;

● Identifique entradas inválidas;

● Trate situações de erro;

● Possua testes unitários automatizados;

● Apresente todos os testes PHPUnit passando;

● Possua cobertura mínima de 80% dos algoritmos;

● Possua documentação suficiente para instalação, execução e testes.

---

# VERSIONAMENTO

O projeto será versionado utilizando Git e disponibilizado no GitHub.

O histórico de commits deverá demonstrar o desenvolvimento incremental da aplicação, evitando concentrar todo o desenvolvimento em um único commit.

Exemplos de commits:

