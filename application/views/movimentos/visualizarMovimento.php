<div class="accordion" id="collapse-group">
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Dados</h5>
                </a>
                <div class="buttons">
                <?php
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/movimentos/editar/'.$result->id_movimento.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    ?>    
                </div>                
            </div>
        </div>
        <div class="collapse in accordion-body">
            <div class="widget-content">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Descricao</strong></td>
                            <td><?php echo $result->descricao ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Data</strong></td>
                            <td><?php echo $result->datahora ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Tipo</strong></td>
                            <td><?php echo ($result->tipo_movimentacao=='E')?'Entrada':'Saída'; ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Quantidade em estoque</strong></td>
                            <td><?php echo $result->quantidade_estoque ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Quantidade</strong></td>
                            <td><?php echo $result->quantidade ?></td>
                        </tr>

                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Valor unitário</strong></td>
                            <td><?php echo $result->valor_unitario ?></td>
                        </tr>

                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Valor total</strong></td>
                            <td><?php echo $result->valor_total ?></td>
                        </tr>
                 
                    </tbody>
                </table>
                <div class="form-actions">
                    <div class="span12">
                        <a href="<?php echo base_url() ?>index.php/movimentos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

