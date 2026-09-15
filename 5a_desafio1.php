<!DOCTYPE html>
<?php
// 1. LÓGICA E PROCESSAMENTO DOS DADOS (PHP)
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Captura os dados do formulário
    $nome = trim($_POST['nome']);
    $ano_nascimento = (int)$_POST['ano_nascimento'];
    
    // Calcula a idade
    $idade = date('Y') - $ano_nascimento;
    
    // Protege o nome contra ataques (XSS) ao exibir
    $nome_seguro = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
    
    // Verifica a maioridade
    if ($idade >= 18) {
        $mensagem = "Acesso permitido, $nome_seguro!";
        // Salva no arquivo de log
        $linha_log = "$nome - $idade anos\n";
        file_put_contents('log_acessos.txt', $linha_log, FILE_APPEND);
    } else {
        $mensagem = "Acesso negado, $nome_seguro!";
    }
}
?>
<!-- 2. PARTE VISUAL E INTERFACE (HTML) -->
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio 1 - Organizado</title>
</head>
<body>

    <h2>Verificação de Acesso</h2>

    <!-- Formulário -->
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="ano_nascimento">Ano de Nascimento:</label>
        <input type="number" id="ano_nascimento" name="ano_nascimento" min="1900" max="<?php echo date('Y'); ?>" required><br><br>

        <button type="submit">Verificar</button>
    </form>

    <!-- Exibição do Resultado -->
    <?php if ($mensagem !== ""): ?>
        <h3><?php echo $mensagem; ?></h3>
    <?php endif; ?>

</body>
</html>
