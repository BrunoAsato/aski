<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Cadastro de Movimento</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formMovimento" method="post" class="form-horizontal" >
                    <div class="control-group">
                    <label for="descricao" class="control-label">Descrição</label>
                    <div class="controls">
                        <input id="descricao" type="text" name="descricao" value="<?php echo set_value('descricao'); ?>"  />
                    </div>
                </div>
                <?php
                    //die(print_r($id_produto));
                ?>
                <div class="control-group">
                    <label for="id_produtos" class="control-label">Produtos</label>
                    <div class="controls">
                           <select name="id_produto" id="id_produto">
                            <option value="" selected>Selecione um produto</option> 
                        <?php
                            foreach ($produtos as $key => $value) {
                                echo "<option value='" . $value->id_produto . "'";
                                if( ($value->id_produto == set_value('id_produto')) || (isset($id_produto) && ($id_produto == $value->id_produto)) ) {
                                    echo " selected ";
                                }
                                echo ">" . $value->nome . " - " . $value->material . " " . $value->cor . " " . $value->tamanho . "</option>";
                            }
                        ?>
                    </select>
                    </div>
                </div>
                <!--
                <?php echo set_value('id_fornecedor'); ?>
                <div class="control-group">
                    <label for="id_fornecedor" class="control-label">Fornecedor<span class="required">*</span></label>
                    <div class="controls">
                        <select id="id_fornecedor" name="id_fornecedor">
                            <option value="" selected>Selecione uma Fornecedor</option>    
                            <?php 
                            foreach ($fornecedores as $key => $value) {
                                echo "<option value='" . $value->id_fornecedor . "'";
                                if ($value->id_fornecedor == set_value('id_fornecedor')) {
                                    echo " selected ";
                                }
                                echo ">" . $value->nome . "</option>";
                            }
                            ?>      
                        </select>
                    </div>
                </div>
                -->


                    <div class="control-group">
                        <label for="tipo_movimentacao" class="control-label">Tipo movimento<span class="required">*</span></label>
                        <div class="control-group btn-group" data-toggle="buttons">
                          <label class="btn btn-success active">
                            <input type="radio" value="E" name="tipo_movimentacao" id="tipo_movimentacao1" autocomplete="off" checked> Entrada
                        </label>
                        <label class="btn btn-danger">
                            <input type="radio" value="S" name="tipo_movimentacao" id="tipo_movimentacao2" autocomplete="off"> Saída
                        </label>

                    </div>
                </div>

                <div class="control-group">
                        <label for="quantidade" class="control-label">Quantidade<span class="required">*</span></label>
                        <div class="controls">
                            <input id="quantidade" type="text" name="quantidade" onkeypress="return SomenteNumero(event)" value="<?php echo set_value('quantidade'); ?>"  />
                        </div>
                    </div>

                <div class="control-group">
                        <label for="valor_unitario" class="control-label">Valor unitário<span class="required">*</span></label>
                        <div class="controls">
                            <input id="valor_unitario" type="text" name="valor_unitario" onkeypress="return SomenteNumero(event)" value="<?php echo set_value('valor_unitario'); ?>" class="money"  />
                        </div>
                    </div>

                <div class="control-group">
                        <label for="valor_total" class="control-label">Valor total<span class="required">*</span></label>
                        <div class="controls">
                            <input id="valor_total" type="text" name="valor_total" onkeypress="return SomenteNumero(event)" disabled="" value="<?php echo set_value('valor_total'); ?>"  />
                        </div>
                    </div>        


                <div class="form-actions">
                    <div class="span12">
                        <div class="span6">
                            <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                            <a href="<?php echo base_url() ?>index.php/movimentos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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

        $("#valor_unitario").blur(function(e) {
            var valor_unitario = $("#valor_unitario").val();
            valor_unitario = valor_unitario.replace(',', '.' );
            valor_unitario = parseFloat(valor_unitario);


            var quantidade = $("#quantidade").val();
            var valor_total = document.getElementById('valor_total');
            if(valor_unitario && quantidade) {
                quantidade = parseInt(quantidade);
                document.getElementById('valor_total').value =  (valor_unitario * quantidade).toFixed(2);
            }    
        });

        $("#quantidade").blur(function(e) {
            var valor_unitario = $("#valor_unitario").val();
            valor_unitario = valor_unitario.replace(',', '.' );
            valor_unitario = parseFloat(valor_unitario);

            var quantidade = $("#quantidade").val();
            var valor_total = document.getElementById('valor_total');
            if(valor_unitario && quantidade) {
                quantidade = parseInt(quantidade);
                document.getElementById('valor_total').value =  (valor_unitario * quantidade).toFixed(2);
            }
        });


        $(".money").maskMoney();
/*
        $('#valor_unitario').blur(function() {
            var valor_unitario = document.getElementById('valor_unitario');
            var valor_total = document.getElementById('valor_total');
            var quantidade = document.getElementById('quantidade');
            if(valor_unitario.value != '' && quantidade.value = '') {
                quantidade.value = valor_unitario.value * quantidade.value;
            }
        });
*/

        $('#formMovimento').validate({
            rules :{
              nome: { required: true},
              id_produto: { required: true},
              quantidade: { required: true},
              valor_unitario: { required: true},
              valor_total: { required: true},
              descricao: { required: true}
          },
          messages:{
              nome: { required: 'Campo Requerido.'},
              id_produto: { required: 'Campo Requerido'},
              quantidade: { required: 'Campo Requerido'},
              valor_unitario: { required: 'Campo Requerido'},
              valor_total: { required: 'Campo Requerido'},
              descricao: { required: 'Campo Requerido.'}
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



