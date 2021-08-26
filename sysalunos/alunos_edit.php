<?php
    session_start();
    require_once("variaveis.php");
    require_once("conexao.php");

    //recuperar os dados da sessão:
    $id_usuario = $_SESSION["id_usuario"];
    $tipoAcesso = $_SESSION["tipo_acesso"];

    //recuperar id de usuário
    $idAlunos = $_GET["idAlunos"];

    //validar se o código do usuário está na sessão:
    if(strlen($id_usuario) == 0){
        //header("location:index.php");
        echo "Usuario nao validado!!!!";
        exit;
    }

    //nome do usuário:
    $nome_usuario = "";
    $sql = "SELECT nome FROM usuarios WHERE idusuarios = $id_usuario";
    $resp = mysqli_query($conexao_bd, $sql);
    if($rows=mysqli_fetch_row($resp)){
        $nome_usuario = $rows[0];
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGA - Sistema de gerenciamento de alunos</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js" ></script>
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
                            
                            if($tipoAcesso == 0){
                                echo $mnuCadastro;
                            }
                            if($tipoAcesso == 0 || $tipoAcesso == 1){
                                echo $mnuConsultas;
                            }
                            if($tipoAcesso == 0 || $tipoAcesso == 2){
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
        <?php     
            //Variáveis
            $NomeAlunos    = "";
            $Matricula     = "";
            $Dt_Nascimento = "";
            $Dt_Cadastro   = "";
            
            if($idAlunos == 0) {
                //novo aluno
                echo "<h1>Novo Aluno:</h1>";
            }else{
            //editar aluno
                echo "<h1>Editar Alunos:</h1>";
                $sql = "SELECT nome, matricula, dt_nascimento, dt_cadastro 
                        FROM alunos WHERE idalunos = $idAlunos";
                $resp = mysqli_query($conexao_bd, $sql);
                if($rows=mysqli_fetch_row($resp)){
                    $NomeAlunos     = $rows[0];
                    $Matricula      = $rows[1];
                    $Dt_Nascimento  = $rows[2];
                    $Dt_Cadastro    = $rows[3];
                }
                mysqli_close($conexao_bd);
            }
        ?>
        <form class="row g-3" method="post" action="alunos_gravar.php">
            <?php
                echo "<input type='hidden' id='txtIdAlunos' name='txtIdAlunos'
                        value='$idAlunos'>";
            ?>
            <div class="col-12">
                <label for="txtNome" class="form-label">Nome do Aluno:</label>
                <input type="text" class="form-control" id="txtNome" name="txtNome" 
                placeholder="Nome do Aluno" value="<?php echo $NomeAlunos; ?>">
            </div>
            <div class="col-md-6">
                <label for="txtMatricula" class="form-label">Matricula:</label>
                <input type="text" class="form-control" id="txtMatricula" name="txtMatricula"
                placeholder="Nº da Matricula" value="<?php echo $Matricula; ?>">
            </div>
            <div class="col-md-6">
                <label for="txtDtNascimento" class="form-label">Data Nascimento:</label>
                <input type="date" class="form-control" id="txtDtNascimento" name="txtDtNascimento"
                placeholder="Data de Nascimento" value="<?php echo $Dt_Nascimento; ?>">
            </div>  
            <div class="col-md-6">
                <label for="txtDtCadastro" class="form-label">Data Cadastro:</label>
                <input type="date" class="form-control" id="txtDtCadastro" name="txtDtCadastro"
                placeholder="Data do Cadastro" value="<?php echo $Dt_Cadastro; ?>">
            </div>                  
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Gravar</button>
                <a class="btn btn-warning" href="alunos_list.php" 
                    role="button">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>