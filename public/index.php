<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Administrativo Lary Pets</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/sweetalert2.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">
  <link rel="icon" href="img/icone.png">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.inputmask.min.js"></script>
  <script src="js/jquery.maskedinput-1.2.1.js"></script>
  <script src="js/parsley.min.js"></script>
  <script src="js/sweetalert2.js"></script>
  <script>
    mostrarSenha = function () {
      const campo = document.getElementById('senha');
      if (campo.type === 'password') {
        campo.type = 'text';
      } else {
        campo.type = 'password';
      }
    }
     function mensagem(titulo, icone, pagina) {
            Swal.fire({
                title: titulo,
                icon: icone, //error, ok, success, question
            }).then((result) => {
                
                if (icone == "error") {
                    history.back();
                } else {
                    location.href = pagina;
                }

            });
        }
  </script>


</head>

<body>
  <?php
  if((!isset($_SESSION["admin"])) && (!$_POST)){
    require "../views/login/index.php";
  }else if((!isset($_SESSION["admin"]))&& ($_POST)){
    $email = trim($_POST["email"] ?? NULL);
    $senha = trim($_POST["senha"] ?? NULL);
    

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<script>mensagem('E-mail inválido!', 'index', 'error');</script>";
    }else if(empty($senha)){
      echo "<script>mensagem('Senha invalida!', 'index', 'error');</script>";
    }else{
      require "../controllers/IndexController.php";
      $acao = new IndexController();
      $acao->verificacao($email, $senha);
    }
  }else{
    require "painel.php";

    
  }
  if (isset($_GET["param"])) {
            $param = explode("/", $_GET["param"]);
        }

        $controller = $param[0] ?? "index";
        $view = $param[1] ?? "index";
        $id = $param[2] ?? NULL;

       
        

       
        if (file_exists("../controllers/{$controller}.php")) {
            require "../controllers/{$controller}.php";

            $control = new $controller();

        } else {
            //require "../views/erro.php";
        }
  ?>

</body>

</html>