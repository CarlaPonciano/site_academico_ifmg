



<?php

$json = file_get_contents('data/dependente.json');

$json_data = json_decode($json);

?>



<div id = "dependente" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="padding: 5px;">

    <label class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 collapsed " data-toggle="collapse" href="#collapseDependente" data-parent="#exampleAccordion" for="telefone"> 

        <button type="button" class="btn btn-outline-primary glyphicon glyphicon-plus iconbutton" ></button>    

    </label>



    <div id = "dependente" class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">

        <legend><h3>Dependentes:</h3></legend>

    </div>

</div>



<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 collapse" id="collapseDependente" >

    <table id="tableDependente" 

           data-toolbar="#toolbar" data-toggle="table" data-card-view="true" 

           data-show-toggle="false"  data-classes ="tableDependente table-bordered"  >



        <thead>

            <tr>

                <th data-field="nome" data-sortable="true" data-visible="true">Nome</th>

                <th data-field="cpf" data-sortable="true" data-visible="true">CPF</th>

                <th data-field="dataNascimento" data-sortable="true" data-visible="true">Data de Nascimento</th>

                <th data-field="genero" data-sortable="true" data-visible="true">Gênero</th>

                <th data-field="parentesco" data-sortable="true" data-visible="true">Parentesco</th>

                <th data-field="telefone.TEL" data-visible="true">Telefone</th>

                <th data-field="telefone.TEL 2" data-sortable="true" data-visible="false">Telefone 2</th>

                <th data-field="email" data-sortable="true" data-visible="false">Email</th>

            </tr>



        </thead>

        <tbody>





            <?php

            foreach ($json_data as $dependente) {

                $mat = $dependente->matricula;

                if ($mat == $matricula) {

                    echo '<tr>';

                    echo '<td>' . $dependente->nome . '</td> ';

                    echo '<td>' . $dependente->cpf . '</td> ';

                    echo '<td>' . $dependente->dataNascimento . '</td> ';

                    echo '<td>' . $dependente->genero . '</td> ';

                    echo '<td>' . $dependente->parentesco . '</td> ';

                    echo '<td>' . $dependente->telefone->TEL . '</td> ';

                    echo '<td>' . $dependente->telefone->TEL2 . '</td> ';

                    echo '<td>' . $dependente->email . '</td> ';

                    echo '</tr> ';

                }

            }

            ?>





        </tbody>

    </table>

</div>





