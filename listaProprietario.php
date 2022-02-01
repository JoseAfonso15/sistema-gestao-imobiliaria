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
                    <h2>Lista de Proprietários</h2>
                </div>
            </div>
            </br>
            <p>
            <div class="rol">
                <a href="index.php" class="btn btn-info">voltar</a>
                <a href="createProprietario.php" class="btn btn-success">Adicionar</a>
            </div>
        </p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Dia repasse</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'banco.php';
                $pdo = Banco::conectar();
                $sql = 'SELECT * FROM proprietario ORDER BY id DESC';

                foreach ($pdo->query($sql)as $row) {
                    echo '<tr>';
                    echo '<th scope="row">' . $row['id'] . '</th>';
                    echo '<td>' . $row['nome'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['telefone'] . '</td>';
                    echo '<td>' . $row['telefone'] . '</td>';
                    echo '<td width=100>';
                    echo '<a class="btn btn-danger" href="deleteProprietario.php?id=' . $row['id'] . '">Excluir</a>';
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
