<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Editar Movimento</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formMovimento" method="post" class="form-horizontal" >
                    <input type="hidden" value="<?php echo $result->id_produto; ?>" name="id_produto"/>
                <div class="control-group">
                <?php echo form_hidden('id_movimento',$result->id_movimento) ?>
                    <label for="descricao" class="control-label">Descrição</label>
                    <div class="controls">
                        <input id="descricao" type="text" name="descricao" maxlength="100" title="Informações sobre o movimento" value="<?php echo $result->descricao; ?>"  />
                    </div>
                </div>

                <div class="control-group">
                    <label for="produto" class="control-label">Produto<span class="required">*</span></label>
                    <div class="controls">
                        <input id="produto" type="text" disabled="" value="<?php echo $result->nome; ?>"  />
                    </div>
                </div>


                <div class="control-group">
                        <label for="tipo_movimentacao" class="control-label">Tipo movimento<span class="required">*</span></label>
                        <div class="control-group btn-group" data-toggle="buttons">
                          <label class="btn btn-success active">
                            <input type="radio" value="E" name="tipo_movimentacao" id="tipo_movimentacao1" autocomplete="off" <?php echo (strtoupper($result->tipo_movimentacao)=='E')?' checked':'';?> > Entrada
                        </label>
                        <label class="btn btn-danger">
                            <input type="radio" value="S" name="tipo_movimentacao" id="tipo_movimentacao2" autocomplete="off" <?php echo (strtoupper($result->tipo_movimentacao)=='S')?' checked':'';?>> Saída
                        </label>

                    </div>
                </div>

                <div class="control-group">
                    <label for="quantidade" class="control-label">Quantidade<span class="required">*</span></label>
                    <div class="controls">
                        <input id="quantidade" type="text" name="quantidade" maxlength="11" title="Quantidade de produtos" onkeypress="return SomenteNumero(event)" value="<?php echo $result->quantidade; ?>"  />
                    </div>
                </div>

                <div class="control-group">
                        <label for="valor_unitario" class="control-label">Valor unitário<span class="required">*</span></label>
                        <div class="controls">
                            <input id="valor_unitario" type="text" name="valor_unitario" title="Valor de cada unidade" onkeypress="return SomenteNumero(event)" value="<?php echo $result->valor_unitario; ?>"  />
                        </div>
                    </div>

                <div class="control-group">
                        <label for="valor_total" class="control-label">Valor total<span class="required">*</span></label>
                        <div class="controls">
                            <input id="valor_total" type="text" name="valor_total" onkeypress="return SomenteNumero(event)" value="<?php echo $result->valor_total; ?>"  />
                        </div>
                    </div> 


                <div class="form-actions">
                    <div class="span12">
                        <div class="span6">
                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white" title="Finalizar edição"></i> Alterar</button>
                            <a href="<?php echo base_url() ?>index.php/movimentos" id="" title="Voltar a listagem de movimentos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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

        $('#formMovimento').validate({
            rules :{
                  quantidade: { required: true},
                  descricao: { required: true}
            },
            messages:{
                  quantidade: {required: 'Campo Requerido.'},
                  descricao: {required: 'Campo Requerido.'}
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




