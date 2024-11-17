<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body>
    <h1>Cadastrar Produto</h1>

    @if(session('success'))
        <p>{{ session('success') }} - ID: {{ session('product_id') }}</p>
    @endif

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Nome:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Descrição:</label><br>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="price">Preço:</label><br>
        <input type="number" id="price" name="price" step="0.01" required><br><br>

        <label for="stock">Quantidade em Estoque:</label><br>
        <input type="number" id="stock" name="stock" required><br><br>

        <label for="category_id">Categoria:</label><br>
        <input type="text" id="category_id" name="category_id" required><br><br>

        <label for="image">Imagem:</label><br>
        <input type="file" id="image" name="image" required><br><br>

        <button type="submit">Cadastrar Produto</button>
    </form>
</body>
</html>