<?php
//require 'banco.php';

$id = 0;

if(!empty($_GET['id']))
{
    $id = $_REQUEST['id'];
    
     
}

 
?>

<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Página Inicial</title>
</head>

<body>
        <div class="container">
          <div class="jumbotron">
            <div class="row">
                <h2>Lista Repasses  </h2>
            </div>
          </div>
            </br>
            <div class="row">
                 
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Contrato</th>
                            <th scope="col">Proprietário</th>
                            <th scope="col">Data</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'banco.php';
                        $pdo = Banco::conectar();
              
                       // exit;
                        $sql = 'select  a.id,contrato_id,data,valor, status,c.nome as cliente from repasse a inner join contrato b on a.contrato_id = b.id inner join proprietario c on b.proprietario_id = c.id '
                                .' where a.contrato_id ='.$id
                                . ' order by a.data asc';

                        foreach($pdo->query($sql)as $row)
                        {
                            echo '<tr>';
			                      echo '<th scope="row">'. $row['contrato_id'] . '</th>';
                            echo '<td>'. $row['cliente'] . '</td>'; 
                            echo '<td>'. $row['data'] . '</td>';
                            echo '<td>'. $row['valor'] . '</td>';
                            
                            if($row['status'] == 1){
                                 echo '<td> PAGO</td>';
                            }else{
                                 echo '<td> A RECEBER</td>';
                            }
                            
                            
                            echo '<td width=250>';
                            echo '<a class="btn btn-primary" href="pagaRepasse.php?id='.$row['id'].'">pagar    </a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="deleteRepasse.php?id='.$row['id'].'">Excluir</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        Banco::desconectar();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
