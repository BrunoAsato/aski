<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Cadastro de Produto</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formProduto" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" type="text" name="nome" maxlength="100" title="Digite o nome do produto" value="<?php echo set_value('nome'); ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="id_categoria" class="control-label">Categoria<span class="required">*</span></label>
                        <div class="controls">
                            <select id="id_categoria" name="id_categoria" title="Selecone a categoria">
                                <option value="" selected>Selecione uma categoria</option>    
                                <?php 
                                foreach ($categorias as $key => $value) {
                                    echo "<option value='" . $value->id_categoria . "'";
                                    if ($value->id_categoria == set_value('id_categoria')) {
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
                            <input id="codigo_barras" type="text" name="codigo_barras" maxlength="20" title="Digite o código de barras do produto" onkeypress="return SomenteNumero(event)" value="<?php echo set_value('codigo_barras'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="preco_compra" class="control-label">Preço de Compra<span class="required">*</span></label>
                        <div class="controls">
                            <input id="preco_compra" class="money" type="text" name="preco_compra"  title="Digite o preço de compra do produto" value="<?php echo set_value('preco_compra'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="preco_venda" class="control-label">Preço de Venda<span class="required">*</span></label>
                        <div class="controls">
                            <input id="preco_venda" class="money" type="text" name="preco_venda"  title="Digite o preço de venda do produto" value="<?php echo set_value('preco_venda'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="estoque_minimo" class="control-label">Estoque Mínimo</label>
                        <div class="controls">
                            <input id="estoque_minimo" type="text" name="estoque_minimo" maxlength="11" onkeypress="return SomenteNumero(event)"  title="Digite o estoque mínimo do produto" value="<?php echo set_value('estoque_minimo'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="cor" class="control-label">Cor</label>
                        <div class="controls">
                            <input id="cor" type="text" name="cor" maxlength="30" title="Digite a cor do produto" onkeypress="return SomenteLetra(event)" value="<?php echo set_value('cor'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="tamanho" class="control-label">Medidas</label>
                        <div class="controls">
                            <input id="tamanho" type="text" name="tamanho" maxlength="3" title="Digite a medida do produto" value="<?php echo set_value('tamanho'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="material" class="control-label">Material</label>
                        <div class="controls">
                            <input id="material" type="text" name="material" maxlength="50" title="Digite o tipo de material do produto" value="<?php echo set_value('material'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descricao" class="control-label">Descrição</label>
                        <div class="controls">
                            <input id="descricao" type="text" name="descricao" maxlength="255" title="Insira uma descrição para o produto" value="<?php echo set_value('descricao'); ?>"  />
                        </div>
                    </div>


                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6">
                                <button type="submit" class="btn btn-success" title="Finalizar o casdastro do produto"><i class="icon-plus icon-white"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/produtos" id=""  title="Voltar para a listagem de produtos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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
                  preco_compra: { required: true},
                  preco_venda: { required: true},
                  id_categoria: { required: true}
            },
            messages:{
                  nome: { required: 'Campo Requerido.'},
                  preco_compra: {required: 'Campo Requerido.'},
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



