<?php
session_start();
require_once("variaveis.php");
require_once("conexao.php");

$id_usuario = $_SESSION["id_usuario"];
$tipoAcesso = $_SESSION["tipo_acesso"];

//recuperar id de usuário
$idMateriasporalunos = $_GET["idMateriasporalunos"];

//validar se o código do usuário está na sessão:
if (strlen($id_usuario) == 0) {
    //header("location:index.php");
    echo "Usuario nao validado!!!!";
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de gerenciamento de alunos</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <link href="css/sweetalert2.css" rel="stylesheet">
    <script src="js/sweetalert2.js"></script>
    <link rel="shortcut icon" href="img/studentmeets_4873.ico" />
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="img/studentmeets_4873.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                    SysAlunos
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-left: 50px;">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="admin.php">Home</a>
                        </li>
                        <?php
                        $mnuCadastro = "<li class='nva-item dropdown active'>
                                            <a class='nav-link dropdown-toggle' href='#' id='mnuCadastroDown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                            Cadastros
                                            </a>
                                            <ul class='dropdown-menu aria-labelledby='mnuCadastroDown'>
                                            <li><a class='dropdown-item' href='usuarios_list.php'>Cadastro de usuários</a></li>
                                            <li><a class='dropdown-item' href='alunos_list.php'>Cadastro de alunos</a></li>
                                            <li><a class='dropdown-item' href='materias_list.php'>Cadastro de matérias</a></li>
                                            <li><hr class='dropdown-divider'></li>
                                            <li><a class='dropdown-item' href='materiasporalunos_list.php'>Cadastro de materias por alunos</a></li>
                                            </ul>
                                        </li>";
                        $mnuConsultas  = "<li class='nav-item'><a class='nav-link' href='#'>Consultas</a></li>";
                        $mnuRelatorios = "<li class='nav-item'><a class='nav-link' href='#'>Relatórios</a></li>";

                        if ($tipoAcesso == 0) {
                            echo $mnuCadastro;
                        }
                        if ($tipoAcesso == 0 || $tipoAcesso == 1) {
                            echo $mnuConsultas;
                        }
                        if ($tipoAcesso == 0 || $tipoAcesso == 2) {
                            echo $mnuRelatorios;
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="m-5">



            <?php
            //Variáveis
            $nomeAluno = "";
            $nomeMateria = "";
            $ano = "";
            $idAluno = "";
            $idMateria = "";


            if ($idMateriasporalunos == 0) {

                // NOVA MATRÍCULA
                echo "<h1>Nova matrícula:</h1>";
            } else {

                // EDITANDO MATRÍCULA
                echo "<h1>Editar matrícula:</h1>";

                $sql = "SELECT a.nome, m.nome, a.idalunos, m.idmaterias, mpa.ano FROM materiasporalunos mpa 
                        INNER JOIN alunos a ON a.idalunos = mpa.idalunos
                        INNER JOIN materias m ON m.idmaterias = mpa.idmaterias
                        WHERE mpa.idmateriasporalunos = $idMateriasporalunos;";

                $resp = mysqli_query($conexao_bd, $sql);
                if ($rows = mysqli_fetch_row($resp)) {
                    $nomeAluno = $rows[0];
                    $nomeMateria = $rows[1];
                    $idAluno = $rows[2];
                    $idMateria = $rows[3];
                    $ano = $rows[4];
                }
            }
            ?>


            <form class="row g-3" method="post" action="materiasporalunos_gravar.php">
                <?php
                echo "<input type='hidden' id='txtIdMateriasporalunos' name='txtIdMateriasporalunos'
                    value='$idMateriasporalunos'>";
                ?>

                <div class="col-md-4">
                    <label for="chknomeal" class="form-label">Nome do aluno:</label>
                    <select id="chknomeal" class="form-select" name="chknomeal">
                        <?php
                        if ($idMateriasporalunos == 0) {
                            $sql = "SELECT idalunos, nome FROM alunos;";

                            $resp = mysqli_query($conexao_bd, $sql);
                            echo "<option value='X' selected>Selecione um aluno</option>";
                            while ($rows = mysqli_fetch_row($resp)) {
                                echo "<option value='$rows[0]'>$rows[1]</option>";
                            }
                        } else {
                            $sql2 = "SELECT idalunos, nome FROM alunos WHERE idalunos != $idAluno;";
                            $resp2 = mysqli_query($conexao_bd, $sql2);
                            echo "<option value='$idAluno' selected>$nomeAluno</option>";
                            while ($rows2 = mysqli_fetch_row($resp2)) {
                                echo "<option value='$rows2[0]'>$rows2[1]</option>";
                            }
                        }
                        ?>
                    </select>
                </div>


                <div class="col-md-4">
                    <label for="chknomemt" class="form-label">Nome da matéria:</label>
                    <select id="chknomemt" class="form-select" name="chknomemt">
                        <?php

                        if ($idMateriasporalunos == 0) {
                            $sql = "SELECT idmaterias, nome FROM materias";
                            $resp = mysqli_query($conexao_bd, $sql);
                            echo "<option value='X' selected>Selecione uma matéria</option>";
                            while ($rows = mysqli_fetch_row($resp)) {
                                echo "<option value='$rows[0]'>$rows[1]</option>";
                            }
                        } else {
                            $sql = "SELECT idmaterias, nome FROM materias WHERE idmaterias != $idMateria;";
                            $resp = mysqli_query($conexao_bd, $sql);
                            echo "<option value='$idMateria' selected>$nomeMateria</option>";
                            while ($rows = mysqli_fetch_row($resp)) {
                                echo "<option value='$rows[0]'>$rows[1]</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="txtCargaH" class="form-label">Ano :</label>
                    <input type="number" class="form-control" id="txtAno" name="txtAno" placeholder="Ano" value="<?php echo $ano; ?>">
                </div>

                <?php

                // fechando conexão
                mysqli_close($conexao_bd);

                ?>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Gravar</button>
                    <a class="btn btn-warning" href="materiasporalunos_list.php" role="button">Cancelar</a>
                </div>
            </form>
        </div>

</body>

</html>