<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Editar Produto</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formProduto" method="post" class="form-horizontal" >
                     <div class="control-group">
                        <?php echo form_hidden('id_produto',$result->id_produto) ?>
                        <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" type="text" name="nome" maxlength="100" title="Nome do produto" value="<?php echo $result->nome; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="id_categoria" class="control-label">Categoria<span class="required">*</span></label>
                        <div class="controls">
                            <select id="id_categoria" name="id_categoria">
                                <option value="" selected>Selecione uma categoria</option> 
                                <?php 
                                foreach ($categorias as $key => $value) {
                                    echo "<option value='" . $value->id_categoria . "'";
                                    if ($value->id_categoria == $result->id_categoria) {
                                        echo " selected ";
                                    }
                                    echo ">" . $value->nome . "</option>";
                                }
                                ?>            
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="codigo_barras" class="control-label">Código de Barras</label>
                        <div class="controls">
                            <input id="codigo_barras" type="text" name="codigo_barras" maxlength="20" title="Código de barras do produto" onkeypress="return SomenteNumero(event)" value="<?php echo $result->codigo_barras; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="preco_compra" class="control-label">Preço de Compra<span class="required">*</span></label>
                        <div class="controls">
                            <input id="preco_compra" type="text" class="money" title="Preço de compra do produto" onkeypress="return SomenteNumero(event)" name="preco_compra" value="<?php echo $result->preco_compra; ?>"  />
                        </div>
                    </div
>
                    <div class="control-group">
                        <label for="preco_venda" class="control-label">Preço de Venda<span class="required">*</span></label>
                        <div class="controls">
                            <input id="preco_venda" type="text" class="money" title="Preço que o produto será vendido" onkeypress="return SomenteNumero(event)" name="preco_venda" value="<?php echo $result->preco_venda; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="estoque_minimo" class="control-label">Estoque Mínimo</label>
                        <div class="controls">
                            <input id="estoque_minimo" type="text" name="estoque_minimo" maxlength="11" title="Quantidade mínima para o produto" onkeypress="return SomenteNumero(event)" value="<?php echo $result->estoque_minimo; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="cor" class="control-label">Cor</label>
                        <div class="controls">
                            <input id="cor" type="text" name="cor" maxlength="30" title="Cor do produto" onkeypress="return SomenteLetra(event)" value="<?php echo $result->cor; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="tamanho" class="control-label">Medidas</label>
                        <div class="controls">
                            <input id="tamanho" type="text" name="tamanho" maxlength="3" title="Medida do produto" value="<?php echo $result->tamanho; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="material" class="control-label">Material</label>
                        <div class="controls">
                            <input id="material" type="text" name="material" maxlength="50" title="Tipo do material" value="<?php echo $result->material; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descricao" class="control-label">Descrição</label>
                        <div class="controls">
                            <input id="descricao" type="text" name="descricao" maxlength="255" title="Informações sobre o produto" value="<?php echo $result->descricao; ?>"  />
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6">
                                <button type="submit" class="btn btn-primary" title="Finalizar alteração"><i class="icon-ok icon-white"></i> Alterar</button>
                                <a href="<?php echo base_url() ?>index.php/produtos" id="" title="Voltar a listagem de produtos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>


                </form>
            </div>

         </div>
     </div>
</div>


<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".money").maskMoney();
        $('#formProduto').validate({
            rules :{
                  nome: { required: true},
                  id_categoria: { required: true},
                  unidade: { required: true},
                  preco_compra: { required: true},
                  preco_venda: { required: true},
                  id_categoria: { required: true}
            },
            messages:{
                  nome: {required: 'Campo Requerido.'},
                  id_categoria: {required: 'Campo Requerido.'},
                  unidade: {required: 'Campo Requerido.'},
                  preco_compra: { required: 'Campo Requerido.'},
                  preco_venda: { required: 'Campo Requerido.'},
                  id_categoria: { required: 'Campo Requerido.'}
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
           });
    });
</script>




