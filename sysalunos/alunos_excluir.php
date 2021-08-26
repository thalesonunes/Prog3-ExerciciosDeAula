<?php
    session_start();
    require_once("variaveis.php");
    require_once("conexao.php");

    $IdAlunos = $_GET["idAlunos"];
    if(strlen($IdAlunos) > 0){
        $sql = "DELETE FROM alunos WHERE idalunos = $IdAlunos";
        mysqli_query($conexao_bd, $sql);
    }
    mysqli_close($conexao_bd);
    header("location:alunos_list.php");
?>