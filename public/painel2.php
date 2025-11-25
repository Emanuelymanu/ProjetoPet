<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="css/style.css" rel="stylesheet">
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
   
    <link href="css/painel.css" rel="stylesheet">
    <link href="css/theme.css" rel="stylesheet">

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.inputmask.min.js"></script>
    <script src="js/jquery.maskedinput-1.2.1.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/sweetalert2.js"></script>

    <script>

        function mensagem(titulo, icone, pagina) {
            Swal.fire({
                title: titulo,
                icon: icone,
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


<body class="d-flex flex-column min-vh-100">
    <script>
        
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.body.setAttribute('data-theme', savedTheme);
        } else {
            
            document.body.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
        }
    </script>

    
    <?php include 'includes/topbar.php'; ?>

    <div class="container-fluid flex-grow-1">
        <div class="row">
           
            <?php include 'includes/sidebar.php'; ?>

            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Bem-Vindo, <?php echo $_SESSION["admin"]["nome"]; ?>!</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                    </div>
                </div>

                
                <div class="container-fluid">
                    <?php
                    $routes = require '../routes/routes.php';
                    $page = $_GET['page'] ?? 'dashboard';

                    if (isset($routes[$page]) && file_exists($routes[$page])) {
                        include $routes[$page];
                    } else {
                        include '../views/erro.php';
                    }

                    ?>
                </div>

            </main>
        </div>
    </div>

    
    <?php include 'includes/footer.php'; ?>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
  
    <script src="js/theme.js"></script>
</body>

</html>