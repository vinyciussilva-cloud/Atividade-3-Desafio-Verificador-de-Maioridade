<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio 1</title>
</head>
<body>

    <?php
    $mensagem = "";

    // Processamento do formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = htmlspecialchars($_POST['nome']); // Proteção básica contra XSS
        $ano = intval($_POST['ano_nascimento']);
        $idade = date('Y') - $ano;

        if ($idade >= 18) {
            $mensagem = "Acesso permitido, $nome!";
            file_put_contents('log_acessos.txt', "$nome - $idade anos\n", FILE_APPEND);
        } else {
            $mensagem = "Acesso negado, $nome!";
        }
    }
    ?>

    <!-- Formulário de Entrada -->
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="ano_nascimento">Ano de Nascimento:</label>
        <input type="number" id="ano_nascimento" name="ano_nascimento" required><br><br>

        <button type="submit">Verificar</button>
    </form>

    <!-- Exibição do Resultado -->
    <?php if (!empty($mensagem)): ?>
        <h3><?php echo $mensagem; ?></h3>
    <?php endif; ?>

</body>
</html>
