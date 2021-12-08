<?php

function valido(){
  
    // Define o nome do arquivo que deve ser lido na forma de uma constante
    define('NOME_ARQUIVO_LOGIN', 'senhas.txt'); 
    
    $loginData = []; // É nessa variável que vão estar os valores lidos no arquivo TXT
    try {
        $fpointer = @fopen(NOME_ARQUIVO_LOGIN, 'r') or die('Não foi possível abrir o arquivo.'); // Abre o arquivo em modo leitura (reading) - 'r'
        $line = trim(fgets($fpointer)); // Lê uma linha do arquivo: USER=orlando|PASS=123mudar
        $values = explode('|', $line); // Separa os valores em um array: [0 => 'USER=orlando', 1 => 'PASS=123mudar']
        
        // Cria um array com as informações lidas do arquivo TXT. ['USER' => 'orlando', 'PASS' => '123mudar']
        foreach($values as $value) {
            $data = explode('=', $value);
            $loginData[$data[0]] = $data[1];
        }
    } finally {
        fclose($fpointer); // Libera o arquivo, indicando que operação de leitura terminou.
    }
    $user = $loginData['USER'];
    $pass = $loginData['PASS'];
    if($_POST['username'] == $user and $_POST['password'] == $pass){
        return TRUE;
    }
    return FALSE;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();
    if(valido()){
        $_SESSION['loggedin'] = TRUE;
        $_SESSION["username"] = 'Orlando Saraiva';
         header("location: welcome.php");
    } else {
        $_SESSION['loggedin'] = FALSE;
    }
}

?>
 
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <title>Acessar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Acessar</h2>
        <p>Favor inserir login e senha.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="orlando">
                <span class="help-block"></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="123mudar">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Acessar">
            </div>
        </form>
    </div>    
</body>
</html>