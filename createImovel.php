

<?php
require 'banco.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeErro = null;
    $proprietarioErro = null;
    $enderecoErro = null;
    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;

        if (!empty($_POST['nome'])) {
            $nome = $_POST['nome'];
        } else {
            $nomeErro = 'Por favor digite o seu nome!';
            $validacao = False;
        }
        if (!empty($_POST['proprietario'])) {
            $proprietario = $_POST['proprietario'];
        } else {
            $proprietarioErro = 'Por favor digite o seu proprietario!';
            $validacao = False;
        }
        if (!empty($_POST['endereco'])) {
            $endereco = $_POST['endereco'];
        } else {
            $enderecoErro = 'Por favor digite o seu endereço!';
            $validacao = False;
        }
    }
 
    if ($validacao) {

        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO imovel (nome,proprietario_id,endereco) VALUES(?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $proprietario, $endereco));
        Banco::desconectar();
        header("Location: index.php");
    }
} 
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <title>Adicionar Contato</title>
    </head>

    <body>
        <div class="container">
            <div clas="span10 offset1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="well"> Adicionar Imóvel </h3>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="createImovel.php" method="post">

                            <div class="control-group  <?php echo!empty($proprietarioErro) ? 'error ' : ''; ?>">
                                <div class="form-group">
                                    <label>Proprietário</label>
                                    <select class="form-control" id="proprietario" name="proprietario">
                                        <option value="">Selecione...</option>
                            <?php
                            $pdo = Banco::conectar();
                            $sql = 'SELECT * FROM proprietario ORDER BY id DESC';

                            foreach ($pdo->query($sql) as $categoria) {

                                echo '<option value="' . $categoria['id'] . '">' . $categoria['nome'] . '</option>';
                            }

                            Banco::desconectar();
                            ?>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group  <?php echo!empty($nomeErro) ? 'error ' : ''; ?>">
                                <label class="control-label">Nome</label>
                                <div class="controls">
                                    <input size="50" class="form-control" name="nome" type="text" placeholder="Nome"
                                           value="<?php echo!empty($nome) ? $nome : ''; ?>">
                            <?php if (!empty($nomeErro)): ?>
                                        <span class="text-danger"><?php echo $nomeErro; ?></span>
                            <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group  <?php echo!empty($enderecoErro) ? 'error ' : ''; ?>">
                                <label class="control-label">Endereço</label>
                                <div class="controls">
                                    <input size="50" class="form-control" name="endereco" type="text" placeholder="Endereço"
                                           value="<?php echo!empty($endereco) ? $endereco : ''; ?>">
                            <?php if (!empty($enderecoErro)): ?>
                                        <span class="text-danger"><?php echo $enderecoErro; ?></span>
                            <?php endif; ?>
                                </div>
                            </div>



                            <div class="form-actions">
                                <br/>
                                <button type="submit" class="btn btn-success">Adicionar</button>
                                <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="/assets/js/bootstrap.min.js"></script>
</body>

</html>

