<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Cliente</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
                        <?php 
                        echo form_hidden('id_cliente',set_value('id_cliente', $result->id_cliente));
                        echo form_hidden('id_pessoa', set_value('id_pessoa', $result->id_pessoa));
                        echo form_hidden('id_pessoa_fisica', set_value('id_pessoa_fisica', $result->id_pessoa_fisica));
                        echo form_hidden('id_pessoa_juridica', set_value('id_pessoa_juridica', $result->id_pessoa_juridica));
                        echo form_hidden('id_telefone', set_value('id_telefone', $result->id_telefone)); 
                        ?>
                        <input type="hidden" name="tipo_documento" id="tipo_documento" value="<?php echo set_value('tipo_pessoa', ($result->tipo_pessoa == 'F')?'F':'J'); ?>">
                        <div class="control-group">
                            <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                            <div class="controls">
                                <input id="nome" type="text" name="nome" maxlength="100" title="Nome do cliente" value="<?php echo $result->nome; ?>"  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="tipo_pessoa" class="control-label">Tipo de pessoa<span class="required">*</span></label>
                            <div class="control-group btn-group" data-toggle="buttons">
                                <label for="tipo_pessoa1">
                                    <input type="radio" value="F" name="tipo_pessoa" id="tipo_pessoa1" autocomplete="off" <?php echo set_value('tipo_pessoa', ($result->tipo_pessoa == 'F'))?" checked ":""; ?>> Pessoa Física
                                </label>
                                <label for="tipo_pessoa2">
                                    <input type="radio" value="J" name="tipo_pessoa" id="tipo_pessoa2" autocomplete="off" <?php echo set_value('tipo_pessoa', ($result->tipo_pessoa == 'J'))?" checked ":""; ?>> Pessoa Jurídica
                                </label>

                            </div>
                        </div>

                        <div class="control-group" id="div_data_nascimento">
                            <label for="data_nascimento" class="control-label">Data nascimento<span class="required">*</span></label>
                            <div class="controls">
                                <input id="data_nascimento" type="date" name="data_nascimento" title="Data de nascimento do cliente" value="<?php echo set_value('data_nascimento', $result->data_nascimento); ?>"  />
                            </div>
                        </div>

                        <div class="control-group" id="div_sexo">
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

                        <div class="control-group" id="div_nome_fantasia">
                            <label for="nome_fantasia" class="control-label">Nome Fantasia<span class="required">*</span></label>
                            <div class="controls">
                                <input id="nome_fantasia" type="text" name="nome_fantasia" maxlength="255" title="Nome Fantasia da empresa" value="<?php echo set_value('nome_fantasia', $result->nome_fantasia); ?>"  />
                            </div>
                        </div>

                        <div class="control-group" id="div_razao_social">
                            <label for="razao_social" class="control-label">Razao Social<span class="required">*</span></label>
                            <div class="controls">
                                <input id="razao_social" type="text" name="razao_social" maxlength="255" title="Digite a Razão Social" value="<?php echo set_value('razao_social', $result->razao_social); ?>"  />
                            </div>
                        </div>


                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                        <div class="input_fields_wrap">
                            <div class="control-group">
                                <label for="telefone" class="control-label">Telefone<span class="required">*</span></label>
                                <div class="controls">
                                <?php
                                    if($result->ddd && $result->telefone) {
                                        $telefone = $result->ddd . $result->telefone;
                                    } else {
                                        $telefone = set_value('telefone');
                                    }                                
                                ?>
                                    <input id="telefone" type="text" name="telefone" maxlength="20" title="Telefone cliente" value="<?php echo $telefone; ?>"  />
                                    <!--<i class="btn btn-success add_field_button icon icon-plus" id="add_campo"></i>-->
                                </div>
                            </div>    
                        </div>

                        <div class="control-group">
                            <label for="email" class="control-label">E-mail<span class="required">*</span></label>
                            <div class="controls">
                                <input id="email" type="text" name="email" maxlength="100" title="Email cliente" value="<?php echo set_value('email', $result->email); ?>"  />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="documento" id="label_documento" class="control-label">CPF/CNPJ<span class="required">*</span></label>
                            <div class="controls">
                                <input id="documento" type="text" name="documento" maxlength="14" onkeypress="return SomenteNumero(event)" value="<?php echo (set_value('cpf', $result->cpf))?set_value('cpf', $result->cpf):set_value('cnpj', $result->cnpj); ?>"  />
                            </div>
                        </div>

                        <div class="control-group" class="control-label">
                            <label for="cep" class="control-label">CEP<span class="required">*</span></label>
                            <div class="controls">
                                <input id="cep" type="text" name="cep" maxlength="8" title="CEP da rua" onkeypress="return MaskCep(event)" value="<?php echo set_value('cep', $result->cep); ?>"  />
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
                                    <button type="submit" class="btn btn-primary" title="Finalizar a alteração"><i class="icon-ok icon-white"></i> Alterar</button>
                                    <a href="<?php echo base_url() ?>index.php/clientes" id="" title="Voltar a listagem de clientes" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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

        var max_fields = 10; //maximum input boxes allowed
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID

      var x = 1; //initlal text box count
      $(add_button).click(function(e) { //on add input button click
        //alert('teste');
        e.preventDefault();
        var length = wrapper.find("input:text").length;

        if (x < max_fields) { //max input box allowed
          x++; //text box increment
          //$(wrapper).append('<div class="control-group"><label for="telefone" class="control-label">Telefone' + (length+1) + '<span class="required">*</span></label><span class="controls"><input id="telefone' + (length+1) + '" type="text" name="telefone' + (length+1) + '" onkeypress="return NumeroTelefone(event)" value="<?php echo set_value('telefone'); ?>"  /></span><a href="#" class="remove_field">Remove</a></div>'); //add input box

          $(wrapper).append('<div class="control-group"><div><label for="telefone" class="control-label">Telefone<span class="required">*</span></label><div class="controls"><input id="telefone' + (length+1) + '" type="text" name="telefone[]" maxlength="20" title="Telefone para contato" onkeypress="return NumeroTelefone(event)" value="<?php echo set_value('telefone[]'); ?>" /></div></div><i class="btn btn-danger icon icon-remove remove_field"></i></div>');
        }
        //Fazendo com que cada uma escreva seu name
        wrapper.find("input:text").each(function() {
          //$(this).val($(this).attr('name'))
        });
      });

      $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
      });


      $(document).ready(function(){
         $('#formCliente').validate({
            rules :{
                nome:{ required: true},
                data_nascimento:{ required: true},
                sexo:{ required: true},
                telefone:{ required: true},
                email:{ required: true},
                documento:{ required: true},
                logradouro:{ required: true},
                numero:{ required: true},
                bairro:{ required: true},
                cidade:{ required: true},
                estado:{ required: true},
                cep:{ required: true}
            },
            messages:{
                nome :{ required: 'Campo Requerido.'},
                data_nascimento :{ required: 'Campo Requerido.'},
                sexo :{ required: 'Campo Requerido.'},
                telefone:{ required: 'Campo Requerido.'},
                email:{ required: 'Campo Requerido.'},
                documento:{ required: 'Campo Requerido.'},
                logradouro:{ required: 'Campo Requerido.'},
                numero:{ required: 'Campo Requerido.'},
                bairro:{ required: 'Campo Requerido.'},
                cidade:{ required: 'Campo Requerido.'},
                estado:{ required: 'Campo Requerido.'},
                cep:{ required: 'Campo Requerido.'}
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
        $("input:radio[name=tipo_pessoa]").on("change", function () { 
            if($(this).val() == "F") {
                $("#div_data_nascimento, #div_sexo").show(); 
                $("#div_nome_fantasia, #div_razao_social").hide();
                document.getElementById("label_documento").innerHTML = "CPF*";
                document.getElementById("tipo_documento").value = 'F';
                document.getElementById("documento").setAttribute('maxlength', '11');
            } else if($(this).val() == "J") {
                $("#div_nome_fantasia, #div_razao_social").show();
                $("#div_data_nascimento, #div_sexo").hide(); 
                document.getElementById("label_documento").innerHTML = "CNPJ*"; 
                document.getElementById("tipo_documento").value = 'J';
                document.getElementById("documento").setAttribute('maxlength', '14');
            }
        });
        
        var tipo = "<?=$result->tipo_pessoa?>";
        if(tipo == 'F') {
                $("#div_data_nascimento, #div_sexo").show(); 
                $("#div_nome_fantasia, #div_razao_social").hide();
                document.getElementById("label_documento").innerHTML = "CPF*";
                document.getElementById("tipo_documento").value = 'F';
                document.getElementById("documento").setAttribute('maxlength', '11');
        } else {
                $("#div_nome_fantasia, #div_razao_social").show();
                $("#div_data_nascimento, #div_sexo").hide(); 
                document.getElementById("label_documento").innerHTML = "CNPJ*";
                document.getElementById("tipo_documento").value = 'J';
                document.getElementById("documento").setAttribute('maxlength', '14');
        }
     });
 </script>

