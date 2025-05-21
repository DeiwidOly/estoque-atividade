<?php
require 'conexao.php';

$filtro = $_GET['filtro'] ?? 'nome_asc';

switch ($filtro) {
    case 'nome_desc': $orderBy = 'p.nome DESC'; break;
    case 'quantidade_asc': $orderBy = 'p.quantidade ASC'; break;
    case 'quantidade_desc': $orderBy = 'p.quantidade DESC'; break;
    case 'id': $orderBy = 'p.id_produto ASC'; break;
    default: $orderBy = 'p.nome ASC';
}

$sql = "SELECT p.*, c.nome AS categoria FROM produtos p
        JOIN categorias c ON p.id_categoria = c.id_categoria
        ORDER BY $orderBy";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estoque de Materiais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilo.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h1>🧱 Estoque de Materiais</h1>
    <a href="adicionar.php" class="btn btn-success mb-3">+ Adicionar Material</a>

    <form method="get" class="mb-3">
        <label for="filtro">Ordenar por:</label>
        <select name="filtro" id="filtro" onchange="this.form.submit()">
            <option value="nome_asc">Nome (A-Z)</option>
            <option value="nome_desc">Nome (Z-A)</option>
            <option value="quantidade_asc">Quantidade (↑)</option>
            <option value="quantidade_desc">Quantidade (↓)</option>
            <option value="id">ID</option>
        </select>
    </form>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th><th>Nome</th><th>Qtd</th><th>Preço</th><th>Categoria</th><th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($produtos as $p): ?>
            <tr class="<?= $p['quantidade'] <= 5 ? 'bg-warning' : '' ?>">
                <td><?= $p['id_produto'] ?></td>
                <td><?= htmlspecialchars($p['nome']) ?></td>
                <td><?= $p['quantidade'] ?></td>
                <td>R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>
                <td><?= $p['categoria'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $p['id_produto'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="excluir.php?id=<?= $p['id_produto'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmar exclusão?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
