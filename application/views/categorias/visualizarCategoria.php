<div class="accordion" id="collapse-group">
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Dados</h5>
                </a>
                <div class="buttons">
                    <?php
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/categorias/editar/'.$result->id_categoria.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    ?>
                </div>
            </div>
        </div>
        <div class="collapse in accordion-body">
            <div class="widget-content">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="text-align: left; width: 25%;"><strong>Nome</strong></td>
                            <td><?php echo $result->nome ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%;"><strong>Descricao</strong></td>
                            <td><?php echo $result->descricao ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%;"><strong>Data de cadastro</strong></td>
                            <td><?php 
                                    $dt_cadastro = explode(' ', $result->dt_cadastro);
                                    $dt_cadastro = implode('/', array_reverse(explode('-', $dt_cadastro[0])));
                                    echo $dt_cadastro ?>
                            </td>
                        </tr>                 
                    </tbody>
                </table>
                <div class="form-actions">
                    <div class="span12">
                        <a href="<?php echo base_url() ?>index.php/categorias" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

