<?php
    require_once '../conexao.php';

    if (!isset($_POST['nome-completo']) || !isset($_POST['email']) || !isset($_POST['senha'])) {
        exit('Não é permitido acessar.');
    }

    $nome = trim($_POST['nome-completo']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($email) || empty($senha)) {
        exit("Por favor, preencha todos os campos");
    }

    try {
        $consulta_verificacao = $conexao->prepare("SELECT * FROM usuarios WHERE email = :email");
        $consulta_verificacao->bindValue(":email", $email);
        $consulta_verificacao->execute();

        if ($consulta_verificacao->rowCount() > 0) {
            header("Location: pagina-cadastro.php?erro=2");
            exit;
        } else {
            $consulta_insercao = $conexao->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
            $consulta_insercao->bindValue(":nome", $nome);
            $consulta_insercao->bindValue(":email", $email);
            $consulta_insercao->bindValue(":senha", md5($senha));
            $consulta_insercao->execute();
                header("Location: ../login/pagina-login.php");
        }
    } catch (PDOException $erro) { 
        echo "Erro ao tentar se cadastrar: " . $erro->getMessage(); 
    }
?>