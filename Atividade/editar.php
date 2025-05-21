<?php
require 'conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID inválido!");

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id_produto = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) die("Produto não encontrado!");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];

    if ($nome && $quantidade && $valor && $categoria) {
        $stmt = $pdo->prepare("UPDATE produtos SET nome=?, quantidade=?, valor=?, id_categoria=? WHERE id_produto=?");
        $stmt->execute([$nome, $quantidade, $valor, $categoria, $id]);
        header("Location: index.php");
        exit;
    } else {
        $erro = "Todos os campos são obrigatórios.";
    }
}

$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h1>Editar Produto</h1>
    <?php if (!empty($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
    <form method="post">
        <input class="form-control mb-2" name="nome" value="<?= $produto['nome'] ?>">
        <input class="form-control mb-2" name="quantidade" type="number" value="<?= $produto['quantidade'] ?>">
        <input class="form-control mb-2" name="valor" type="number" step="0.01" value="<?= $produto['valor'] ?>">
        <select class="form-control mb-2" name="categoria">
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id_categoria'] ?>" <?= $cat['id_categoria'] == $produto['id_categoria'] ? 'selected' : '' ?>>
                    <?= $cat['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-primary">Atualizar</button>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </form>
</body>
</html>
