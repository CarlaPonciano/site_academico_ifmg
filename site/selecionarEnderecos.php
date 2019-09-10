<!DOCTYPE html>

<html lang="pt-br">

    <head>

        <?php

        require __DIR__ . '/vendor/autoload.php';

        include 'conexao.php';

        include 'menu.php';

        ?>

        <style>

            * {

                box-sizing: border-box;

            }



            #myUL {

                list-style-type: none;

                padding: 0;

                margin: 0;

            }



            #myUL li{

                border: 1px solid #ddd;

                margin-top: -1px; /* Prevent double borders */

                background-color: #fff;

                padding-left: 2px;

                text-decoration: none;

                font-size: 18px;

                color: black;

                display: none;

            }



            #myUL li a:hover:not(.header) {

                background-color: #eee;

            }



            div{

                min-height: 34px;

            }

            table {

                border: 1px #c0c0c0 solid;

            }

            table th {

                border: 1px #c0c0c0 solid;

                background-color: #fff;

                color: #000;

            }

            table td {

                border: 1px #c0c0c0 solid;

                background-color: #fff;

                color: #000;

            }

        </style>

    </head>

    <body>

        <div class="container-fluid">

            <div class="row">

                <main class="span-8 col-sm-8 offset-sm-3 col-md-10 offset-md-2 pt-3 dashboard">

                    <form target="_blank" class="form-horizontal" enctype="multipart/form-data" role="form" data-toggle="validator" action="gerarEndereco.php" method="post">

                        <div class="row col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                            <legend><h2>Relatório de Endereços de Associados</h2><br></legend>

                            <br>

                            <p>Selecione a situação dos associados cujos endereços serão exibidos no relatório:</p>

                            <div class="form-group  col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">                                    

                                    <label class="checkbox-inline"><input type="checkbox" name="regular" value="1">Em dia</label>
                                    <label class="checkbox-inline"><input type="checkbox" name="atraso" value="2">Em atraso</label>
                                    <label class="checkbox-inline"><input type="checkbox" name="inadimplente" value="3">Inadimplente</label>

                                </div>

                            </div>

                            <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">        

                                <div>
                                    <br>
                                    <button type="submit" class="btn btn-primary" name="emitirRelatorio">Emitir Relatório de Endereços</button>

                                </div>

                            </div>

                        </div>

                    </form>

                </main>

            </div>

        </div>

        <script

            src="bootstrap-validator-master\dist\validator.js">

        </script>

        <script

            src="js\buscaSocio.js">

        </script>

    </body>

</html>



