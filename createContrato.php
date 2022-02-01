

<?php
require 'banco.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imovelErro = null;
    $proprietarioErro = null;
    $locatarioErro = null;
    $inicioErro = null;
    $fimErro = null;
    $taxaAdmErro = null;
    $valorAluguelErro = null;
    $valorCondominioErro = null;
    $valorIptuErro = null;

    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;

        if (!empty($_POST['imovel'])) {
            $imovel = $_POST['imovel'];
        } else {
            $imovelErro = 'Por favor digite o imovel!';
            $validacao = False;
        }
        if (!empty($_POST['proprietario'])) {
            $proprietario = $_POST['proprietario'];
        } else {
            $proprietarioErro = 'Por favor digite o proprietario!';
            $validacao = False;
        }
        ;
        if (!empty($_POST['locatario'])) {
            $locatario = $_POST['locatario'];
        } else {
            $locatarioErro = 'Por favor digite o locatario!';
            $validacao = False;
        }
        if (!empty($_POST['inicio'])) {
            $inicio = $_POST['inicio'];
        } else {
            $inicioErro = 'Por favor digite a data de inicio!';
            $validacao = False;
        }
        if (!empty($_POST['fim'])) {
            $fim = $_POST['fim'];
        } else {
            $fimErro = 'Por favor digite a data fim';
            $validacao = False;
        }
        if (!empty($_POST['taxaAdm'])) {
            $taxaAdm = $_POST['taxaAdm'];
        } else {
            $taxaAdmErro = 'Por favor digite a taxa de administração';
            $validacao = False;
        }
        if (!empty($_POST['valorAluguel'])) {
            $valorAluguel = $_POST['valorAluguel'];
        } else {
            $valorAluguelErro = 'Por favor digite o valor do aluguel';
            $validacao = False;
        }
        if (!empty($_POST['valorCondominio'])) {
            $valorCondominio = $_POST['valorCondominio'];
        } else {
            $valorCondominioErro = 'Por favor digite o valor do condominio';
            $validacao = False;
        }
        if (!empty($_POST['valorIptu'])) {
            $valorIptu = $_POST['valorIptu'];
        } else {
            $valorIptuErro = 'Por favor digite o valor do iptu';
            $validacao = False;
        }
    }

 
    if ($validacao) {

        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO contrato (imovel_id,proprietario_id,cliente_id,dataInicio,dataFim,valorAdministracao,valorAluguel,valorCondominio,valorIptu) VALUES(?,?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($imovel, $proprietario, $locatario, $inicio, $fim, $taxaAdm, $valorAluguel, $valorCondominio, $valorIptu));

        $sql = 'SELECT * FROM contrato ORDER BY id DESC LIMIT 1';

        foreach ($pdo->query($sql)as $row) {

            $id = $row['id'];
            $valorMensalidade = $row['valorAluguel'] + $row['valorIptu'] + $row['valorCondominio'];
            $valorRepasse = $row['valorAluguel'] + $row['valorIptu'];
            $dataInicio = $row['dataInicio'];
        }

        $status = 0;
        for ($i = 1; $i <= 12; $i++) {

            if ($i == 1) {
                $status = 1;
            } else {
                $status = 0;
            }

            $dataMen = date('Y/m/d', strtotime("+" . $i . "month", strtotime($dataInicio)));

            $sql = "INSERT INTO mensalidade (contrato_id,data,valor,status) VALUES(?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($id, $dataMen, $valorMensalidade, $status));

            $sql = "INSERT INTO repasse (contrato_id,data,valor,status) VALUES(?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($id, $dataMen, $valorRepasse, $status));
        }


        Banco::desconectar();
        header("Location: index.php");
    }
} else {
    
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
                        <h3 class="well"> Adicionar Contrato </h3>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="createContrato.php" method="post">

                            <div class="control-group  <?php echo!empty($imovelErro) ? 'error ' : ''; ?>">
                                <div class="form-group">
                                    <label>Imovel</label>
                                    <select class="form-control" id="imovel" name="imovel">
                                        <option value="">Selecione...</option>
                            <?php
                            $pdo = Banco::conectar();
                            $sql = 'SELECT * FROM imovel ORDER BY id DESC';

                            foreach ($pdo->query($sql) as $categoria) {

                                echo '<option value="' . $categoria['id'] . '">' . $categoria['nome'] . '</option>';
                            }

                            Banco::desconectar();
                            ?>
                                    </select>
                                </div>
                            </div>


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

                            <div class="control-group  <?php echo!empty($locatarioErro) ? 'error ' : ''; ?>">
                                <div class="form-group">
                                    <label>Locatario</label>
                                    <select class="form-control" id="locatario" name="locatario">
                                        <option value="">Selecione...</option>
                                        <?php
                                        $pdo = Banco::conectar();
                                        $sql = 'SELECT * FROM cliente ORDER BY id DESC';

                                        foreach ($pdo->query($sql) as $categoria) {

                                            echo '<option value="' . $categoria['id'] . '">' . $categoria['nome'] . '</option>';
                                        }

                                        Banco::desconectar();
                                        ?>
                                    </select>
                                </div>
                            </div>
 
                            <div class="control-group  <?php echo!empty($inicioErro) ? 'error ' : ''; ?>">
                                <label class="control-label">Inicio</label>
                                <div class="controls">
                                    <input size="50" class="form-control" name="inicio" type="date" placeholder=""
                                           value="<?php echo!empty($inicio) ? $inicio : ''; ?>">
                                        <?php if (!empty($imovelErro)): ?>
                                        <span class="text-danger"><?php echo $inicioErro; ?></span>
                                        <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group  <?php echo!empty($fimErro) ? 'error ' : ''; ?>">
                                <label class="control-label">Fim</label>
                                <div class="controls">
                                    <input size="50" class="form-control" name="fim" type="date" placeholder=""
                                           value="<?php echo!empty($fim) ? $fim : ''; ?>">
                            <?php if (!empty($fimErro)): ?>
                                        <span class="text-danger"><?php echo $fimErro; ?></span>
                            <?php endif; ?>
                                </div>
                            </div>



                            <div class="control-group  <?php echo!empty($taxaErro) ? 'error ' : ''; ?>">
                                <label class="control-label">taxa administração</label>
                                <div class="controls">
                                    <input size="50" class="form-control" name="taxaAdm" type="text" placeholder=""
                                           value="<?php echo!empty($taxaAdm) ? $taxaAdm : ''; ?>">
                            <?php if (!empty($taxaAdmErro)): ?>
                                        <span class="text-danger"><?php echo $taxaAdmErro; ?></span>
                            <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group  <?php echo!empty($valorErro) ? 'error ' : ''; ?>">
                                <label class="control-label">Valor Aluguel</label>
                                <div class="controls">
                                    <input size="50" class="form-control" name="valorAluguel" type="text" placeholder=""
                                           value="<?php echo!empty($valorAluguel) ? $valorAluguel : ''; ?>">
                            <?php if (!empty($valorAluguelErro)): ?>
                                        <span class="text-danger"><?php echo $valorAluguelErro; ?></span>
                            <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group  <?php echo!empty($valorCondominioErro) ? 'error ' : ''; ?>">
                                <label class="control-label">Valor Condominio</label>
                                <div class="controls">
                                    <input size="50" class="form-control" name="valorCondominio" type="text" placeholder=""
                                           value="<?php echo!empty($valorCondominio) ? $valorCondominio : ''; ?>">
                            <?php if (!empty($valorCondominioErro)): ?>
                                        <span class="text-danger"><?php echo $valorCondominioErro; ?></span>
                            <?php endif; ?>
                                </div>
                            </div>


                            <div class="control-group  <?php echo!empty($valorIptuErro) ? 'error ' : ''; ?>">
                                <label class="control-label">Valor IPTU</label>
                                <div class="controls">
                                    <input size="50" class="form-control" name="valorIptu" type="text" placeholder=""
                                           value="<?php echo!empty($valorIptu) ? $valorIptu : ''; ?>">
                            <?php if (!empty($valorIptuErro)): ?>
                                        <span class="text-danger"><?php echo $valorIptuErro; ?></span>
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

