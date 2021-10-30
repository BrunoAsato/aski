<div class="accordion" id="collapse-group">
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Dados do Produto</h5>
                </a>
                <div class="buttons">
                    <?php
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/produtos/editar/'.$result->id_produto.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    ?>
            </div>
            </div>
        </div>
        <div class="collapse in accordion-body">
            <div class="widget-content">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Nome</strong></td>
                            <td><?php echo $result->nome ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Categoria</strong></td>
                            <td><?php echo $result->categoria ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Código de Barras</strong></td>
                            <td><?php echo $result->codigo_barras ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Preço de Compra</strong></td>
                            <td><?php echo $result->preco_compra ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Preço de Venda</strong></td>
                            <td><?php echo $result->preco_venda ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Estoque</strong></td>
                            <td><?php echo $result->estoque ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Estoque Mínimo</strong></td>
                            <td><?php echo $result->estoque_minimo ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Cor</strong></td>
                            <td><?php echo $result->cor ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Medidas</strong></td>
                            <td><?php echo $result->tamanho ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Material</strong></td>
                            <td><?php echo $result->material ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 25%"><strong>Descrição</strong></td>
                            <td><?php echo $result->descricao ?></td>
                        </tr>                  
                    </tbody>
                </table>
                <div class="form-actions">
                    <div class="span12">
                        <a href="<?php echo base_url() ?>index.php/produtos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

