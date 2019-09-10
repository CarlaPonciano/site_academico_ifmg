<!DOCTYPE html>

<html lang="pt-br">

    <?PHP

    require 'conexao.php';
    require 'testaAdmin.php';

    session_start();

    $tipo = $_SESSION['tipo'];

    $senha = $_SESSION['senha'];

    $idUserLogin = $_SESSION['login'];

//Caso o usuário não esteja autenticado, limpa os dados e redireciona

    if (!isset($_SESSION['login']) and ! isset($_SESSION['senha'])) {

        //Destrói

        session_destroy();



        //Limpa

        unset($_SESSION['login']);

        unset($_SESSION['senha']);



        //Redireciona para a página de autenticação

        echo"<script language='javascript' type='text/javascript'>alert('Para acessar esta página é preciso logar.');window.location.href='index.php';</script>";

        die();

    }

    ?>

    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta http-equiv="cache-control" content="no-cache" />

        <meta name="description" content="">

        <meta name="author" content="">



        <link href='https://fonts.googleapis.com/css?family=Lora|Raleway' rel='stylesheet'>



        <script src="vendor/components/jquery/jquery.min.js" type="text/javascript"></script>

        <script src="vendor/twitter/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

        <script src="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.js" type="text/javascript"></script>



        <script src="vendor/wenzhixin/bootstrap-table/src/extensions/filter-control/bootstrap-table-filter-control.js" type="text/javascript"></script>

        <script src="vendor/wenzhixin/bootstrap-table/src/extensions/filter/bootstrap-table-filter.js" type="text/javascript"></script>

        <script src="vendor/wenzhixin/bootstrap-table/src/extensions/export/bootstrap-table-export.js" type="text/javascript"></script>



        <script src="vendor/intelogie/table-export/tableExport.js" type="text/javascript"></script>

        <script src="vendor/intelogie/table-export/jspdf/jspdf.js" type="text/javascript"></script>

        <script src="vendor/intelogie/table-export/jspdf/libs/base64.js" type="text/javascript"></script>

        <script src="vendor/intelogie/table-export/jspdf/libs/sprintf.js" type="text/javascript"></script>

        <script src="vendor/intelogie/table-export/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js" type="text/javascript"></script>

        <script src="vendor/intelogie/table-export/libs/FileSaver/FileSaver.min.js" type="text/javascript"></script>

        <script src="vendor/wenzhixin/bootstrap-table/src/extensions/auto-refresh/bootstrap-table-auto-refresh.js" type="text/javascript"></script>

        <script src="vendor/wenzhixin/bootstrap-table/src/extensions/multiple-sort/bootstrap-table-multiple-sort.js" type="text/javascript"></script>

        <script src="vendor/wenzhixin/bootstrap-table/src/extensions/multiple-selection-row/bootstrap-table-multiple-selection-row.js" type="text/javascript"></script>

        <script src="vendor/wenzhixin/bootstrap-table/src/extensions/multiple-search/bootstrap-table-multiple-search.js" type="text/javascript"></script>

        <script src="vendor/wenzhixin/bootstrap-table/src/extensions/natural-sorting/bootstrap-table-natural-sorting.js" type="text/javascript"></script>

        <script src="vendor/wenzhixin/bootstrap-table/src/extensions/reorder-rows/bootstrap-table-reorder-rows.js" type="text/javascript"></script>





        <link href="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.css" rel="stylesheet" type="text/css"/>

        <link href="vendor/wenzhixin/bootstrap-table/src/extensions/filter-control/bootstrap-table-filter-control.css" rel="stylesheet" type="text/css"/>

        <link href="vendor/twitter/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <link href="css/home.css" rel="stylesheet" type="text/css"/>



        <title>AAPOB - Associação dos Aposentados e Pensionistas de Ouro Branco</title>

    </head>



    <nav class="navbar navbar-toggleble-right navbar-light navbar-border" position="fixed">

        <div class="container-fluid">

            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarNavAltMarkup">

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>                        

                </button>

                <a class="navbar-brand d-inline-block align-top" href="index.php"><img alt="Brand" src="img/aaalogo.png" width="80" height="40"></a>

                <a class="navbar-brand logo" href="index.php">

                    <h5>Associação dos</br>

                        Aposentados e Pensionistas de</br>

                        Ouro Branco

                    </h5></a>

            </div>

            <ul class="nav navbar-nav navbar-right" id="menu">

                <li><a href="logout.php">Sair<span class="glyphicon glyphicon-log-in"></span></a></li>

            </ul>



        </div><!-- /.container-fluid -->

    </nav>

    <div class="container-fluid">

        <div class="row">



            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

                <nav class="navbar-dark span-3 col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar ">

                    <ul class="nav nav-pills nav-stacked flex-column">

                        <?php

                        /* 	

                          1	secretaria

                          2	financeiro

                          3	diretoria

                          4	diretoria-presi

                          5	consulta

                          6	diretoria-finan

                         * 

                         */



                        // Área de cadastros

                        // Verifica acesso para tipo de perfil == secretaria ou diretoria-presi

                        if (($tipo == 1) || ($tipo == 4)) {

                            ?> 

                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Usuário">

                                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" aria-expanded="true" href="#collapseUsuario" data-parent="#Accordion">

                                    <i class="fa fa-fw fa-wrench"></i>

                                    <span class="nav-link-text">Cadastrar<span class="glyphicon glyphicon-plus icon"></span></span>

                                </a>

                                <ul class="nav nav-pills nav-stacked flex-column collapse in" id="collapseUsuario">

                                    <li class="nav-child">

                                        <a class="nav-link" href="cadastrarSocio.php">Associado</a>

                                    </li>

                                    <li class="nav-child">

                                        <a class="nav-link" href="cadastrarDependente.php">Dependente</a>

                                    </li>

                                </ul>   

                            </li>

                            <?php

                        }

                        // Área de consultas de perfil

                        // Verifica acesso para tipo de perfil == secretaria ou financeiro ou diretoria ou diretoria-presi ou consulta ou diretoria-finan

                        if (($tipo == 1) || ($tipo == 2) || ($tipo == 5) || (isAdmin($tipo))) {

                            ?>  

                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Consultar">

                                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseConsultar" data-parent="#Accordion">

                                    <i class="fa fa-fw fa-wrench"></i>

                                    <span class="nav-link-text">Consultar<span class="glyphicon glyphicon-plus icon"></span></span>

                                </a>

                                <ul class="nav nav-pills nav-stacked flex-column collapse in" id="collapseConsultar">

                                    <li class="nav-child">

                                        <a class="nav-link" href="consultarUsuario.php">Usuários</a>

                                    </li>

                                    <li class="nav-child">

                                        <a class="nav-link" href="consultarSocio.php">Associados</a>

                                    </li>

                                    <li class="nav-child">

                                        <a class="nav-link" href="consultarDependente.php">Dependentes</a>

                                    </li>

                                </ul>   

                            </li>



                            <?php

                        }

                        // Área de finanças

                        // Verifica acesso para tipo de perfil == financeiro ou diretoria-presi ou diretoria-finan

                        if (($tipo == 2) || ($tipo == 4) || ($tipo == 6)) {

                            ?>  

                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Mensalidade">

                                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMensalidade" data-parent="#Accordion">

                                    <i class="fa fa-fw fa-wrench"></i>

                                    <span class="nav-link-text"><span class="glyphicon glyphicon-plus icon"></span>Mensalidade</span>

                                </a>

                                <ul class="nav nav-pills nav-stacked flex-column collapse in" id="collapseMensalidade">

                                    <?php

                                    // Área de registro de finanças

                                    // Verifica acesso para tipo de perfil == financeiro

                                    if (($tipo == 2)) {

                                        ?>  

                                        <li class="nav-child">

                                            <a class="nav-link" href="cadastrarMensalidade.php">Pagamento</a>

                                        </li>

                                        <li class="nav-child">

                                            <a class="nav-link" href="cadastrarQuitacao.php">Quitar Dívida</a>

                                        </li>

                                        <li class="nav-child">

                                            <a class="nav-link" href="cadastrarDesligamento.php">Editar Vínculo</a>

                                        </li>

                                        <?php

                                    }

                                    ?>

                                    <li class = "nav-child">

                                        <a class = "nav-link" href = "consultarMensalidade.php">Histórico</a>

                                    </li>                                  



                                    <li class="nav-child">

                                        <a class="nav-link" href="consultarQuitacao.php">Quitações</a>

                                    </li>



                                </ul>   

                            </li>



                        <?php

                        }

                        if (($tipo == 1) || ($tipo == 2) || ($tipo == 5) || (isAdmin($tipo))) {

                        ?>  

                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Relatorios">

                                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMensalidade" data-parent="#Accordion">

                                    <i class="fa fa-fw fa-wrench"></i>

                                    <span class="nav-link-text"><span class="glyphicon glyphicon-plus icon"></span>Relatórios</span>

                                </a>

                                <ul class="nav nav-pills nav-stacked flex-column collapse in" id="collapseMensalidade">

                                    <li class="nav-child">

                                        <a class="nav-link" href="relatorioSocios.php">Associados</a>

                                        <?php
                                        if (($tipo == 2) || ($tipo == 4) || ($tipo == 6)) {
                                        ?> 
                                            <a class="nav-link" href="selecRelatorioMensalidades.php">Mensalidades</a>
                                        <?php
                                        }
                                        ?>

                                        <a class="nav-link" href="selecionarEnderecos.php">Endereços</a>

                                        <a class="nav-link" target="_blank" href="gerarListaAniversario.php">Aniversariantes da Semana</a>

                                        <!--<a class="nav-link" target="_blank" href="gerarEnderecoCarta.php">Endereços - Carta</a>-->

                                    </li>

                                    <!--<li class="nav-child">

                                        <a class="nav-link" href="selecRelatorioQuitacoes.php">Quitações</a>

                                    </li> 

                                    <li class="nav-child">

                                        <a class="nav-link" href="selecRelatorioMensEQuit.php">Mensalidades e Quitações</a>

                                    </li> -->

                                </ul>   

                            </li>



                        <?php

                        }

                        // Área de gerenciamento

                        // Verifica acesso para tipo de perfil == diretoria ou diretoria-presi ou diretoria-finan

                        if ($tipo == 4) {

                        ?>  

                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Configuracao">

                                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseConfiguracao" data-parent="#Accordion">

                                    <i class="fa fa-fw fa-wrench"></i>

                                    <span class="nav-link-text"><span class="glyphicon glyphicon-plus icon"></span>Configuração</span>

                                </a>

                                <ul class="nav nav-pills nav-stacked flex-column collapse in" id="collapseMensalidade">

									<li class="nav-child">

										<a class="nav-link" href="configurarSistema.php">Configurações</a>

									</li>

									<li class="nav-child">

										<a class="nav-link" href="cadastrarPerfil.php">Cadastrar um Novo Perfil</a>

									</li>

									<li class="nav-child">

										<a class="nav-link" href="exibirPerfil.php">Exibir Perfis Administrativos</a>

									</li>

                                </ul>   

                            </li>

                        <?php

                        }

                        // Área de consulta do sócio

                        // Verifica acesso para tipo de login foi de usuário sócio.

                        if (($tipo == "socio") || ($tipo == "dependente")) {

                        ?>
                            <li class="nav-item">

                                <a class="nav-link" href="exibirSocio.php?matricula=<?php echo $senha;?>" >Meus dados</a>

                            </li>

                        <?php

                        }

                        ?>

                        <li class="nav-item">

                            <a class="nav-link" href="perfil.php">Perfil<span class="sr-only">(current)</span></a>

                        </li>

                    </ul>

                </nav>

            </div>

            <script src="js/validator.min.js"></script>

        </div>

    </div>

</html>