<?php
$host = '127.0.0.1';
$db   = 'llsecurity2';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . htmlspecialchars($e->getMessage());
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dataNascimento = $_POST['data_nascimento'] ?? '';
    $endereco = trim($_POST['endereco'] ?? '');

    if ($nome === '' || $cpf === '' || $email === '' || $dataNascimento === '' || $endereco === '') {
        echo 'Por favor, preencha todos os campos.';
        exit;
    }

    $sql = 'INSERT INTO candidato (nome, cpf, email, data_nascimento, endereco) VALUES (:nome, :cpf, :email, :data_nascimento, :endereco)';
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            ':nome'            => $nome,
            ':cpf'             => $cpf,
            ':email'           => $email,
            ':data_nascimento' => $dataNascimento,
            ':endereco'        => $endereco,
        ]);
    } catch (PDOException $e) {
        echo 'Erro ao salvar: ' . htmlspecialchars($e->getMessage());
        exit;
    }

    echo "<div style='text-align: center; margin-top: 50px; font-family: Arial;'>";
    echo "<h1 style='color: green;'>🎉 Cadastro enviado com sucesso!</h1>";
    echo "<p>Obrigado por se candidatar. Os dados foram guardados.</p>";
    echo "<br><a href='trabalheconosco2.php' style='text-decoration: none; background: #007bff; color: white; padding: 10px 20px; border-radius: 5px;'>Voltar ao Formulário</a>";
    echo "</div>";
    exit;
}

echo '<p>Nenhum formulário enviado.</p>';
?>