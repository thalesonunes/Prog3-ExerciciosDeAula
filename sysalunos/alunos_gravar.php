<?php
    session_start();
    require_once("variaveis.php");
    require_once("conexao.php");

    $IdAlunos      = $_POST["txtIdAlunos"];
    $NomeAlunos    = $_POST["txtNome"];
    $Matricula     = $_POST["txtMatricula"];
    $Dt_Nascimento = $_POST["txtDtNascimento"];
    $Dt_Cadastro   = $_POST["txtDtCadastro"];
                        
    if(strlen($IdAlunos) > 0){
        if($IdAlunos == 0){
            //novo Aluno
            $sql = "INSERT INTO alunos(nome, matricula, dt_nascimento, dt_cadastro) 
                    VALUES('$NomeAlunos', '$Matricula', '$Dt_Nascimento', '$Dt_Cadastro')";
        }else{
            //editar aluno
            $sql = "UPDATE alunos SET 
                        nome          = '$NomeAlunos',
                        matricula     = '$Matricula', 
                        dt_nascimento = '$Dt_Nascimento',
                        dt_cadastro   = '$Dt_Cadastro'
                    WHERE idalunos    = $IdAlunos";
        }
        mysqli_query($conexao_bd, $sql);
    }
    mysqli_close($conexao_bd);
    header("location:alunos_list.php");
?>