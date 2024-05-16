<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci minha senha</title>
    <link rel="stylesheet" href="../styles/password.css">
    <script src="../scripts/forgotPass.js" defer></script>
</head>
<body>
    <div class="page">
        <form method="POST" class="formLogin" id="conteinerForm">
            <h1>Recuperar</h1>
            <p>Digite o seu email abaixo para realizar a recuperação da sua conta</p>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Digite seu e-mail" autofocus="true" id="emailForgot" name="emailForgot"/>

            <input type="submit" value="Enviar" class="btn" id="forgotBtn"/>
        </form>
    </div>
    
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['emailForgot'];

    $url = "http://18.228.226.227:4000/v1/auth/forgot";
    $data = array('email' => $email);

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

        if (isset($response->msg)) {
            echo '<script>window.location.href = "./password.php";</script>';
            exit();
        } else {
            echo "Erro ao autenticar usuário";
        }
    }
}
?>
