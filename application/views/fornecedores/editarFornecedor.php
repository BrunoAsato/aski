<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Fornecedor</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formFornecedor" method="post" class="form-horizontal" >
                        <?php 
                        echo form_hidden('id_fornecedor',set_value('id_fornecedor', $result->id_fornecedor));
                        echo form_hidden('id_pessoa', set_value('id_pessoa', $result->id_pessoa));
                        echo form_hidden('id_pessoa_juridica', set_value('id_pessoa_juridica', $result->id_pessoa_juridica));
                        echo form_hidden('id_telefone', set_value('id_telefone', $result->id_telefone)); 
                        ?>
                        <div class="control-group">
                            <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                            <div class="controls">
                                <input id="nome" type="text" name="nome" maxlength="100" title="Nome Fornecedor" onkeypress="return SomenteLetra(event)" value="<?php echo $result->nome; ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="telefone" class="control-label">Telefone<span class="required">*</span></label>
                            <div class="controls">
                                <input id="telefone" type="text" name="telefone" maxlength="20" title="Telefone Fornecedor" onkeypress="return SomenteNumero(event)" value="<?php echo set_value('ddd', $result->ddd) . set_value('telefone', $result->telefone); ?>"  />
                            </div>
                        </div>    

                        <div class="control-group">
                            <label for="email" class="control-label">E-mail<span class="required">*</span></label>
                            <div class="controls">
                                <input id="email" type="text" name="email" maxlength="100" title="Email Fornecedor" value="<?php echo set_value('email', $result->email); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="cnpj" class="control-label">CNPJ<span class="required">*</span></label>
                            <div class="controls">
                                <input id="cnpj" type="text" name="cnpj" maxlength="14" title="CNPJ Fornecedor" onkeypress="return SomenteNumero(event)" value="<?php echo set_value('cnpj', $result->cnpj); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="descricao" class="control-label">Descricao<span class="required">*</span></label>
                            <div class="controls">
                                <input id="descricao" type="text" name="descricao" maxlength="255" title="Informações sobre o Fornecedor" value="<?php echo set_value('descricao', $result->descricao); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="cep" class="control-label">CEP<span class="required">*</span></label>
                            <div class="controls">
                                <input id="cep" type="text" name="cep" maxlength="8" onkeypress="return MaskCep(event)" value="<?php echo set_value('cep', $result->cep); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="logradouro" class="control-label">Logradouro<span class="required">*</span></label>
                            <div class="controls">
                                <input id="logradouro" type="text" name="logradouro" value="<?php echo set_value('logradouro', $result->logradouro); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="numero" class="control-label">Número<span class="required">*</span></label>
                            <div class="controls">
                                <input id="numero" type="text" name="numero" title="Número do estabelecimento" value="<?php echo set_value('numero', $result->numero); ?>"  />
                            </div>
                        </div>

                        <div class="control-group" class="control-label">
                            <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                            <div class="controls">
                                <input id="bairro" type="text" name="bairro" value="<?php echo set_value('bairro', $result->bairro); ?>"  />
                            </div>
                        </div>

                        <div class="control-group" class="control-label">
                            <label for="cidade" class="control-label">Cidade<span class="required">*</span></label>
                            <div class="controls">
                                <input id="cidade" type="text" name="cidade" value="<?php echo set_value('cidade', $result->cidade); ?>"  />
                            </div>
                        </div>

                        <div class="control-group" class="control-label">
                            <label for="estado" class="control-label">Estado<span class="required">*</span></label>
                            <div class="controls">
                                <input id="estado" type="text" name="estado" value="<?php echo set_value('estado', $result->estado); ?>"  />
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="span12">
                                <div class="span6">
                                    <button type="submit" class="btn btn-primary" title="Finalizar a alteração"><i class="icon-ok icon-white"></i> Alterar</button>
                                    <a href="<?php echo base_url() ?>index.php/fornecedores" id="" title="Voltar a listagem de fornecedores" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="<?php echo base_url()?>js/jquery.validate.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
         $('#formFornecedor').validate({
            rules :{
      nome:{ required: true},
      cnpj:{ required: true},
      descricao:{ required: true},
      cep:{ required: true},
      telefone:{ required: true},
      email:{ required: true},
      cnpj:{ required: true},
      logradouro:{ required: true},
      numero:{ required: true},
      bairro:{ required: true},
      cidade:{ required: true},
      estado:{ required: true}
  },
  messages:{
      nome :{ required: 'Campo Requerido.'},
      cnpj :{ required: 'Campo Requerido.'},
      descricao :{ required: 'Campo Requerido.'},
      cep :{ required: 'Campo Requerido.'},
      telefone:{ required: 'Campo Requerido.'},
      email:{ required: 'Campo Requerido.'},
      cnpj:{ required: 'Campo Requerido.'},
      logradouro:{ required: 'Campo Requerido.'},
      numero:{ required: 'Campo Requerido.'},
      bairro:{ required: 'Campo Requerido.'},
      cidade:{ required: 'Campo Requerido.'},
      estado:{ required: 'Campo Requerido.'}

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
         $("#cep").blur(function(e){
        if($.trim($("#cep").val()) != ""){
            $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
                if(resultadoCEP["resultado"]){
                    $("#logradouro").val(unescape(resultadoCEP["tipo_logradouro"])+": "+unescape(resultadoCEP["logradouro"]));
                    $("#bairro").val(unescape(resultadoCEP["bairro"]));
                    $("#cidade").val(unescape(resultadoCEP["cidade"]));
                    $("#estado").val(unescape(resultadoCEP["uf"]));
                }else{
                    alert("Não foi possivel encontrar o endereço");
                }
            });             
        }
    });
     });
 </script>

