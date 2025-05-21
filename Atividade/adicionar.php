<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];

    if ($nome && $quantidade && $valor && $categoria) {
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, quantidade, valor, id_categoria) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $quantidade, $valor, $categoria]);
        header("Location: index.php");
        exit;
    } else {
        $erro = "Preencha todos os campos!";
    }
}

$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Adicionar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h1>Adicionar Produto</h1>
    <?php if (!empty($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
    <form method="post">
        <input class="form-control mb-2" name="nome" placeholder="Nome">
        <input class="form-control mb-2" name="quantidade" type="number" placeholder="Quantidade">
        <input class="form-control mb-2" name="valor" type="number" step="0.01" placeholder="Preço">
        <select class="form-control mb-2" name="categoria">
            <option value="">Selecione a categoria</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id_categoria'] ?>"><?= $cat['nome'] ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-success">Salvar</button>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </form>
</body>
</html>
