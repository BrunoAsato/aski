<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Funcionario</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formFuncionario" method="post" class="form-horizontal" >
                        <?php 
                        echo form_hidden('id_funcionario',set_value('id_funcionario', $result->id_funcionario));
                        echo form_hidden('id_pessoa', set_value('id_pessoa', $result->id_pessoa));
                        echo form_hidden('id_pessoa_fisica', set_value('id_pessoa_fisica', $result->id_pessoa_fisica));
                        echo form_hidden('id_telefone', set_value('id_telefone', $result->id_telefone)); 
                        ?>
                        <div class="control-group">
                            <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                            <div class="controls">
                                <input id="nome" type="text" name="nome" maxlength="100" title="Nome do funcionário" onkeypress="return SomenteLetra(event)" value="<?php echo $result->nome; ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="data_nascimento" class="control-label">Data nascimento<span class="required">*</span></label>
                            <div class="controls">
                                <input id="data_nascimento" type="date" name="data_nascimento" title="Data de nascimento do funcionário" value="<?php echo set_value('data_nascimento', $result->data_nascimento); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="sexo" class="control-label">Sexo<span class="required">*</span></label>
                            <div class="control-group btn-group" data-toggle="buttons">
                                <label for="sexo1">
                                    <input type="radio" value="F" name="sexo" id="sexo1" autocomplete="off" <?php echo set_value('sexo', ($result->sexo == 'F'))?" checked ":""; ?>> Feminino
                                </label>
                                <label for="sexo2">
                                    <input type="radio" value="M" name="sexo" id="sexo2" autocomplete="off" <?php echo (set_value('sexo', $result->sexo) == 'M')?" checked ":""; ?>> Masculino
                                </label>

                            </div>
                        </div>

                        <div class="control-group">
                            <label for="telefone" class="control-label">Telefone<span class="required">*</span></label>
                            <div class="controls">
                                <input id="telefone" type="text" name="telefone" maxlength="20" title="Telefone do funcionário" onkeypress="return NumeroTelefone(event)" value="<?php echo set_value('ddd', $result->ddd) . set_value('telefone', $result->telefone); ?>"  />
                            </div>
                        </div>    

                        <div class="control-group">
                            <label for="email" class="control-label">E-mail<span class="required">*</span></label>
                            <div class="controls">
                                <input id="email" type="text" name="email" maxlength="100" title="Email do funcionário" value="<?php echo set_value('email', $result->email); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="cpf" class="control-label">CPF<span class="required">*</span></label>
                            <div class="controls">
                                <input id="cpf" type="text" name="cpf" maxlength="11" title="CPF do funcionário" onkeypress="return NumeroDocumento(event)" value="<?php echo set_value('cpf', $result->cpf); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="cargo" class="control-label">Cargo<span class="required">*</span></label>
                            <div class="controls">
                                <input id="cargo" type="text" name="cargo" maxlength="50" title="Cargo que o funcionário ocupará" onkeypress="return SomenteLetra(event)" value="<?php echo set_value('cargo', $result->cargo); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="data_contratacao" class="control-label">Data de contratacao<span class="required">*</span></label>
                            <div class="controls">
                                <input id="data_contratacao" type="date" name="data_contratacao" title="Data de contratação do funcionário" value="<?php echo set_value('data_contratacao', $result->data_contratacao); ?>"  />
                            </div>
                        </div>

                        <div class="control-group" class="control-label">
                            <label for="cep" class="control-label">CEP<span class="required">*</span></label>
                            <div class="controls">
                                <input id="cep" type="text" name="cep" maxlength="8" onkeypress="return MaskCep(event)" value="<?php echo set_value('cep', $result->cep); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="logradouro" class="control-label">Logradouro</label>
                            <div class="controls">
                                <input id="logradouro" type="text" name="logradouro" value="<?php echo set_value('logradouro', $result->logradouro); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="numero" class="control-label">Número<span class="required">*</span></label>
                            <div class="controls">
                                <input id="numero" type="text" name="numero" maxlength="10" title="Número da casa" value="<?php echo set_value('numero', $result->numero); ?>"  />
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
                                    <button type="submit" class="btn btn-primary" title="Finalizar a edição"><i class="icon-ok icon-white"></i> Alterar</button>
                                    <a href="<?php echo base_url() ?>index.php/funcionarios" id="" title="Voltar a listagem de funcionários" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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
         $('#formFuncionario').validate({
            rules :{
                nome:{ required: true},
                data_nascimento:{ required: true},
                sexo:{ required: true},
                telefone:{ required: true},
                email:{ required: true},
                cpf:{ required: true},
                data_contratacao:{ required: true},
                logradouro:{ required: true},
                numero:{ required: true},
                bairro:{ required: true},
                cidade:{ required: true},
                estado:{ required: true},
                cep:{ required: true},
                cargo:{ required: true}
            },
            messages:{
                nome :{ required: 'Campo Requerido.'},
                data_nascimento :{ required: 'Campo Requerido.'},
                sexo :{ required: 'Campo Requerido.'},
                telefone:{ required: 'Campo Requerido.'},
                email:{ required: 'Campo Requerido.'},
                cpf:{ required: 'Campo Requerido.'},
                data_contratacao:{ required: 'Campo Requerido.'},
                logradouro:{ required: 'Campo Requerido.'},
                numero:{ required: 'Campo Requerido.'},
                bairro:{ required: 'Campo Requerido.'},
                cidade:{ required: 'Campo Requerido.'},
                estado:{ required: 'Campo Requerido.'},
                cep:{ required: 'Campo Requerido.'},
                cargo:{ required: 'Campo Requerido.'}

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
        })
     });
 </script>

