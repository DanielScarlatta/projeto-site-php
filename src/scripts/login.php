<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
    <div class="page">
        <form method="POST" class="formLogin" id="conteinerForm">
            <h1>Login</h1>
            <p>Digite os seus dados para o acesso nos campos abaixo.</p>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Digite seu e-mail" autofocus="true" id="emailLogin" name="emailLogin"/>

            <label for="password">Senha</label>
            <input type="password" placeholder="Digite sua senha" id="passwordLogin" name="passwordLogin"/>

            <a href="./forgotPass.php">Esqueci minha senha</a>

            <span class="span">Não uma conta? </span>
            <a href="./register.php">Cadastrar-se</a>
            <input type="submit" value="Acessar" class="btn" id="btnAccessLogin" name="btnAccessLogin"/>
        </form>
    </div>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['emailLogin'];
    $password = $_POST['passwordLogin'];

    $url = "http://18.228.226.227:4000/v1/auth/login";
    $data = array('email' => $email, 'password' => $password);

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo "Erro ao fazer a requisição HTTP";
    } else {
        $response = json_decode($result);

        if (isset($response->token)) {
            session_start();
            $_SESSION['token'] = $response->token;
            echo '<script>window.location.href = "./index.php";</script>';
            exit();
        } else {
            echo "Erro ao autenticar usuário";
        }
    }
}
?>

