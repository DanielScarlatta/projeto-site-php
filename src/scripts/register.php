<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../styles/register.css">
    
</head>
<body>
    <div class="page">
        <form method="POST" class="formLogin" id="conteinerForm">
            <p style="color: #388e3c;" id="responseApi">
                <?php 
                if(isset($responseMessage)) {
                    echo $responseMessage;
                }
                ?>
            </p>

            <h1>Cadastro</h1>
            <p>Digite os seus dados de acesso no campo abaixo.</p>

            <label for="name">Nome Completo</label>
            <input type="text" placeholder="Digite seu nome Completo" autofocus="true" id="nameRegister" name="nameRegister"/>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Digite seu e-mail" autofocus="true" id="emailRegister" name="emailRegister"/>

            <label for="password">Senha</label>
            <input type="password" placeholder="Digite sua senha" id="passwordRegister" name="passwordRegister"/>

            <label for="confirmpasswordRegister">Confirme sua senha</label>
            <input type="password" placeholder="Digite sua senha" id="confirmpasswordRegister" name="confirmpasswordRegister"/>

            <span class="span">Tem uma conta? </span>
            <a href="./login.php">Conecte-se agora</a>
            <input type="submit" value="Cadastrar-se" class="btn" id="btnRegisterUser" name="btnRegisterUser"/>
        </form>
    </div>
    
</body>
</html>

<?php
$url = "http://18.228.226.227:4000";

$nameRegister = $_POST['nameRegister'];
$emailRegister = $_POST['emailRegister'];
$passwordRegister = $_POST['passwordRegister'];
$confirmPasswordRegister = $_POST['confirmpasswordRegister'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataUser = array(
        'name' => $nameRegister,
        'email' => $emailRegister,
        'password' => $passwordRegister,
        'confirmpassword' => $confirmPasswordRegister
    );
    $dataUser = json_encode($dataUser);
    registerUser($dataUser);
}

function registerUser($dataUser) {
    global $url;
    $response = file_get_contents("$url/v1/auth/register", false, stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $dataUser
        )
    )));
    $data = json_decode($response, true);

    if (isset($data['msg']) && $data['msg'] == 'Usuario criado com sucesso!') {
        echo '<script>window.location.href = "login.php";</script>';
        exit;
    } elseif (isset($data['msg'])) {
        echo $data['msg']; 
    } else {
        echo "Erro ao registrar o usuário."; 
    }
}
?>