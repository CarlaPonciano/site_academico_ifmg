<?php
include("include/headerAdm.php");
require __DIR__ . '/vendor/autoload.php';
if (isset($_SESSION['login'])){
?>

<style>
  a{
    color: #212529;
  }
</style>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="indexAdmin.php" style="color: #0056C0;">Página Inicial</a>
  </li>
  <li class="breadcrumb-item active">Mensalidade</li>
  <li class="breadcrumb-item active">Registrar Quitação</li>
</ol>

<?php
    $valorMensal = 0;
    $valorAnual = 0;

    $sqlMensalidade = "SELECT valor, descricao 
            FROM valorMensalidade;";

    $resultMensalidade = $con->query($sqlMensalidade);
    if ($resultMensalidade->num_rows > 0) {
        // output data of each row
        while ($rowsMensalidade = $resultMensalidade->fetch_assoc()) {
            if ($rowsMensalidade['descricao'] === 'mensal') {
                $valorMensal = $rowsMensalidade['valor'];
            }

            if ($rowsMensalidade['descricao'] === 'anual') {
                $valorAnual = $rowsMensalidade['valor'];
            }
        }
    }
?>

<script>
    function mascara(o,f){
        v_obj=o
        v_fun=f
        setTimeout("execmascara()",1)
    }

    function execmascara(){
        v_obj.value=v_fun(v_obj.value)
    }

    function ref(v){
        v=v.replace(/\D/g,"")             //Remove tudo o que não é dígito
        v=v.replace(/^(\d{4})(\d)/,"$1-$2") //Esse é tão fácil que não merece explicações
        return v
    }
</script>

<form class="form-horizontal" enctype="multipart/form-data" role="form" data-toggle="validator" action="inserirQuitacao.php" method="post">

    <div class="card mb-3">
      <a href="#dados" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="dados">
        <i class="fas fa-money-check"></i>
        Quitação
      </a>

      <div id="dados">
        <div class="card-body">

          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="myInput">
                Procure pelo nome do sócio <span title="obrigatório">*</span>
              </label>
              <input type="text" maxlength="240" class="form-control" id="myInput" placeholder="Procure pelo nome do sócio" name="myInput" required>
            </div>

            <div class="col-12 col-sm-12 col-md-12  col-lg-12 col-xl-12">  
                <div class="col-12 col-sm-6 col-md-5 col-lg-5 col-xl-5" style="position: absolute;
                     z-index: 3;
                     background-color: #fff;
                     margin-left: 15px;
                     padding-top: 15px;">  
                    <div id="resultado" name="resultado">

                    </div>
                </div>
            </div>
          </div>

          <br>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="nomeAss">
                Sócio <span title="obrigatório">*</span>
              </label>
              <input readonly="readonly" type="text" maxlength="240" class="form-control" id="nomeAss" placeholder="Nome Completo" name="nomeAss" required>
            </div>

            <div class="form-group col-md-6">
              <label for="matricula">
                Matrícula <span title="obrigatório">*</span>
              </label>
              <input readonly="readonly" type="text" maxlength="240" class="form-control" id="matricula" placeholder="Matrícula" name="matricula" required>
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="referenciaInicial">
                Referência <span title="obrigatório">*</span>
              </label>
              <input required lang="pt" type="month" value="aaaa-mm" class="form-control" onkeypress="mascara(this,ref)" minlength=7 maxlength="7" min="7" id="referenciaInicial" name="referenciaInicial">
            </div>

            <div class="form-group col-md-6">
              <label for="referenciaFinal">
                Até <span title="obrigatório">*</span>
              </label>
              <input required lang="pt" type="month"  value="aaaa-mm" class="form-control" onkeypress="mascara(this,ref)" maxlength="7" id="referenciaFinal" name="referenciaFinal">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="dataPagamento">
                Data do Pagamento <span title="obrigatório">*</span>
              </label>
              <input required type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="dataPagamento"  name="dataPagamento">
            </div>

            <div class="form-group col-md-6">
              <label for="valor">
                Valor <span title="obrigatório">*</span>
              </label>
              <input required pattern="^[0-9]{1,4}.[0-9]{2}$" type="text" class="form-control" id="valor" value="<?php echo number_format($valorMensal, 2); ?>" name="valor">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="obs">
                Observação
              </label>
              <textarea rows="4" id="obs" name="obs" maxlength="240" placeholder="Digite alguma observação" class="form-control"></textarea>
            </div>

          </div>

        </div>
      </div>
    </div>

    <div id="contSocioDependente" class="form-group col-12 col-sm-12 col-md-12  col-lg-12 col-xl-12" hidden=true>
        <div class="col-12 col-sm-6 col-md-4  col-lg-4 col-xl-4" style="margin-left: 15px; background-color:#afd9ee; float: right">

            <input class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2" type="text" id="numSocioDependente" readonly="readonly" style=" background-color:#afd9ee; padding-left: 10px; padding-left: 10px;" value="<?PHP ECHO $ano; ?>" name="numSocioDependente" >

            <label class="control-label  col-10 col-sm-10 col-md-10  col-lg-10 col-xl-10" >Dependente(s) - Agregado

            </label>

        </div>

    </div>

    <button type="submit" name="insertMensalidade" onclick="verificar()" class="btn btn-primary">Cadastrar</button>

</form>

<script src="js\buscaSocio.js"></script>

<script>
    var valorMensal = "<?php echo $valorMensal; ?>";
    var valorAnual = "<?php echo $valorAnual; ?>";

    document.getElementById("referenciaInicial").onchange = function () {
        controlDateFinal(this, document.getElementById("referenciaFinal"));
    };
    document.getElementById("referenciaFinal").min = document.getElementById("referenciaFinal");
    function controlDateFinal(m, y) {
        y.value = m.value;
        y.min = m.value;
    }
    ;

    document.getElementById("referenciaFinal").onchange = function () {
        controlValor(document.getElementById("referenciaInicial"), this);
    };

    function controlValor(m, y) {
        yd = y.value.split("-");
        md = m.value.split("-");
        //alert(yd[0] + yd[1] + ";" + md[0] + md[1] + ";" + valorMensal + ";" + valorAnual);
        var d;
        if (yd[0] === md[0]) {
            d = parseFloat(yd[1]) - parseFloat(md[1]) + 1;
        } else {
            f = 12 - parseFloat(md[1]);
            d = parseFloat(yd[1]) + parseFloat(f) + 1;
            //alert(f + ";" + d);
        }
        valor = document.getElementById("valor");
        a = parseInt(d / 12);
        rm = d % 12;
        v = (rm * valorMensal) + (a * valorAnual);
        valor.value = v.toFixed(2);
    };
</script>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>