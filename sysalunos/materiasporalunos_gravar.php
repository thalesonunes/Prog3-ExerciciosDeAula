<?php
    session_start();
    require_once("variaveis.php");
    require_once("conexao.php");

    $idMateriasporalunos= $_POST["txtIdMateriasporalunos"];
    $nomeAluno = $_POST["chknomeal"];
    $nomeMateria = $_POST["chknomemt"]; 
    $ano = $_POST["txtAno"];
      
    if(strlen($idMateriasporalunos) > 0){
        if($idMateriasporalunos == 0){

            //NOVA MATRÍCULA
            $sql = "INSERT INTO materiasporalunos(idalunos, idmaterias, ano) 
                    VALUES('$nomeAluno','$nomeMateria', '$ano');";
        }else{
            //ATUALIZANDO MATRÍCULA
            $sql = "UPDATE materiasporalunos SET 
                        idalunos = '$nomeAluno',
                        idmaterias = '$nomeMateria', 
                        ano = '$ano'
                    WHERE idmateriasporalunos = $idMateriasporalunos";
        }
        mysqli_query($conexao_bd, $sql);
    }

    // FECHANDO CONEXÃO
    mysqli_close($conexao_bd);

    // CHAMANDO O HEADER DE LISTA DE ALUNOS
    header("location:materiasporalunos_list.php");
?>