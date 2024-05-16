<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../styles/register.css">
    
    <script src="../scripts/password.js" defer></script>
</head>
<body>
    <div class="page">
        <form method="POST" class="formLogin" id="conteinerForm">
            <p style="color: #388e3c;" id="responseApi"></p>

            <h1>Recuperar</h1>
            <p>Digite os seus dados de acesso no campo abaixo.</p>

            <label for="code">Codigo</label>
            <input type="text" placeholder="Digite seu codigo de recuperação" autofocus="true" id="codeRedefine" name="codeRedefine"/>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Digite seu e-mail" autofocus="true" id="emailRedefine" name="emailRedefine"/>

            <label for="password">Senha</label>
            <input type="password" placeholder="Digite sua senha" id="passwordRedefine" name="passwordRedefine"/>

            <label for="confirmPasswordRedefine">Confirme sua senha</label>
            <input type="password" placeholder="Digite sua senha" id="confirmPasswordRedefine" name="confirmPasswordRedefine"/>

            <input type="submit" value="Redefinir" class="btn" id="btnRedefinirUser" name="btnRedefinirUser"/>
        </form>
    </div>
    
</body>
</html>

<?php
$url = "http://18.228.226.227:4000";

$codeRedefine = $_POST['codeRedefine'];
$emailRedefine = $_POST['emailRedefine'];
$passwordRedefine = $_POST['passwordRedefine'];
$confirmPasswordRedefine = $_POST['confirmPasswordRedefine'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataUser = array(
        'email' => $emailRedefine,
        'password' => $passwordRedefine,
        'confirmpassword' => $confirmPasswordRedefine,
        'recoveryCode' => $codeRedefine
    );
    $dataUser = json_encode($dataUser);
    redefinePassword($dataUser);
}

function redefinePassword($dataUser) {
    global $url;
    $response = file_get_contents("$url/v1/auth/redefinePassword", false, stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $dataUser
        )
    )));
    $data = json_decode($response, true);

    if (isset($data['msg']) && $data['msg'] == 'Senha redefinida com sucesso') {
        echo '<script>window.location.href = "login.php";</script>';
        exit;
    } elseif (isset($data['msg'])) {
        echo $data['msg']; // Se houver uma mensagem de erro da API, exiba-a
    } else {
        echo "Erro ao redefinir a senha."; // Caso contrário, exiba uma mensagem genérica de erro
    }
}
?>
