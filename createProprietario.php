

<?php
require 'banco.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeErro = null;
    $emailErro = null;
    $telefoneErro = null;
    $diaRepasseErro = null;
    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
        if (!empty($_POST['nome'])) {
            $nome = $_POST['nome'];
        } else {
            $nomeErro = 'Por favor digite o seu nome!';
            $validacao = False;
        }
        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $emailErro = 'Por favor digite um endereço de email válido!';
                $validacao = False;
            }
        } else {
            $emailErro = 'Por favor digite um endereço de email!';
            $validacao = False;
        }
        if (!empty($_POST['telefone'])) {
            $telefone = $_POST['telefone'];
        } else {
            $telefoneErro = 'Por favor digite o número do telefone!';
            $validacao = False;
        }
        if (!empty($_POST['diaRepasse'])) {
            $diaRepasse = $_POST['diaRepasse'];
        } else {
            $diaRepasseErro = 'Por favor digite o dia do repasse';
            $validacao = False;
        }
    }

//Inserindo no Banco:
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO proprietario (nome, email, telefone,diaRepasse) VALUES(?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $email, $telefone, $diaRepasse));
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
        <title>Adicionar Proprietário</title>
    </head>

    <body>
        <div class="container">
            <div clas="span10 offset1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="well"> Adicionar Proprietário</h3>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="createProprietario.php" method="post">

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

                            <div class="control-group <?php !empty($emailErro) ? '$emailErro ' : ''; ?>">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                    <input size="40" class="form-control" name="email" type="text" placeholder="Email"
                                           value="<?php echo!empty($email) ? $email : ''; ?>">
                            <?php if (!empty($emailErro)): ?>
                                        <span class="text-danger"><?php echo $emailErro; ?></span>
                                           <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group <?php echo!empty($telefoneErro) ? 'error ' : ''; ?>">
                                <label class="control-label">Telefone</label>
                                <div class="controls">
                                    <input size="35" class="form-control" name="telefone" type="text" placeholder="Telefone"
                                           value="<?php echo!empty($telefone) ? $telefone : ''; ?>">
                            <?php if (!empty($telefoneErro)): ?>
                                        <span class="text-danger"><?php echo $telefoneErro; ?></span>
                                           <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group <?php echo!empty($telefoneErro) ? 'error ' : ''; ?>">
                                <label class="control-label">Dia do repasse</label>
                                <div class="controls">
                                    <input size="35" class="form-control" name="diaRepasse" type="text" placeholder="Dia Repasse"
                                           value="<?php echo!empty($diaRepasse) ? $diaRepasse : ''; ?>">
                            <?php if (!empty($diaRepasseErro)): ?>
                                        <span class="text-danger"><?php echo $diaRepasseErro; ?></span>
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

