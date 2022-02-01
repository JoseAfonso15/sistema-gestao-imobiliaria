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
                    <h2>Lista de Contratos</h2>
                </div>
            </div>
            </br>
            <p>
            <div class="rol">
                <a href="index.php" class="btn btn-info">voltar</a>
                <a href="createContrato.php" class="btn btn-success">Adicionar</a>
            </div>
        </p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Imóvel</th>
                            <th scope="col">Proprietario</th>
                            <th scope="col">Locador</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'banco.php';
                        $pdo = Banco::conectar();
                        $sql = 'select a.id as id, c.nome as imovel,b.nome as proprietario,d.nome as cliente from contrato a inner join proprietario b on a.proprietario_id = b.id inner join imovel c on a.imovel_id = c.id inner join cliente d on a.cliente_id = d.id';

                        foreach ($pdo->query($sql)as $row) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row['id'] . '</th>';
                            echo '<td>' . $row['imovel'] . '</td>';
                            echo '<td>' . $row['proprietario'] . '</td>';
                            echo '<td>' . $row['cliente'] . '</td>';
                            echo '<td width=350>';
                            echo '<a class="btn btn-primary" href="repasse.php?id=' . $row['id'] . '">Repasses</a>';
                            echo ' ';
                            echo '<a class="btn btn-warning" href="mensalidade.php?id=' . $row['id'] . '">Mensalidades</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="deleteCliente.php?id=' . $row['id'] . '">Excluir</a>';
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
