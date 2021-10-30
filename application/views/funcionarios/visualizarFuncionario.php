<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Funcionário</a></li>
            <div class="buttons">
                    <?php
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/funcionarios/editar/'.$result->id_funcionario.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    ?>
            </div>
        </ul>
    </div>
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">
            <div class="accordion" id="collapse-group">
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Dados Pessoais</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: left; width: 25%"><strong>Nome</strong></td>
                                                    <td><?php echo $result->nome; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><strong>CPF</strong></td>
                                                    <td><?php echo $result->cpf ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><strong>Cargo</strong></td>
                                                    <td><?php echo $result->cargo ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><strong>Data de contratacao</strong></td>
                                                    <td><?php 
                                                        $data_contratacao = explode(' ', $result->data_contratacao);
                                                        $data_contratacao = implode('/', array_reverse(explode('-', $data_contratacao[0])));
                                                        echo $data_contratacao ?>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Contatos</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGTwo">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: left; width: 25%"><strong>Telefone</strong></td>
                                                    <td><?php echo '(' . $result->ddd . ') ' . $result->telefone ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><strong>Email</strong></td>
                                                    <td><?php echo $result->email ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Endereço</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGThree">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: left; width: 25%"><strong>Logradouro</strong></td>
                                                    <td><?php echo $result->logradouro ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><strong>Número</strong></td>
                                                    <td><?php echo $result->numero ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><strong>Bairro</strong></td>
                                                    <td><?php echo $result->bairro ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><strong>Cidade</strong></td>
                                                    <td><?php echo $result->cidade ?> - <?php echo $result->estado ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><strong>CEP</strong></td>
                                                    <td><?php echo $result->cep ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>



          
        </div>
    </div>
    <div class="form-actions">
        <div class="span12">
            <a href="<?php echo base_url() ?>index.php/funcionarios" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
        </div>
    </div>
</div>
