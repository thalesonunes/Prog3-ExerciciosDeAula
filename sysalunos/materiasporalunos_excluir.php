<?php
    session_start();
    require_once("variaveis.php");
    require_once("conexao.php");

    $idMateriasPorAlunos = $_GET["idMateriasPorAlunos"];
    if(strlen($idMateriasPorAlunos) > 0){
        
        //DELETANDO "MATRICULA"
        $sql = "DELETE FROM materiasporalunos WHERE idmateriasporalunos = $idMateriasPorAlunos";
        mysqli_query($conexao_bd, $sql);
    }

    // FECHANDO CONEXÃO
    mysqli_close($conexao_bd);

    /// CHAMANDO O HEADER DE MATERIAS POR ALUNOS
    header("location:materiasporalunos_list.php");
?>