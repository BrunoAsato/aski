<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Cadastro de Cliente</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" type="text" name="nome" maxlength="100" title="Nome do cliente" onkeypress="return SomenteLetra(event)" value="<?php echo set_value('nome'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="tipo_pessoa" class="control-label">Tipo de pessoa<span class="required">*</span></label>
                        <div class="control-group btn-group" data-toggle="buttons">
                            <label for="tipo_pessoa1">
                                <input type="radio" value="F" name="tipo_pessoa" id="tipo_pessoa1" autocomplete="off" <?php echo (set_value('tipo_pessoa') == 'F')?" checked ":""; echo (!set_value('tipo_pessoa'))?" checked ":""; ?>> Pessoa Física
                            </label>
                            <label for="tipo_pessoa2">
                                <input type="radio" value="J" name="tipo_pessoa" id="tipo_pessoa2" autocomplete="off"<?php echo (set_value('tipo_pessoa') == 'J')?" checked ":""; ?>> Pessoa Jurídica
                            </label>

                        </div>
                    </div>

                    <div class="control-group" id="div_data_nascimento">
                        <label for="data_nascimento" class="control-label">Data nascimento<span class="required">*</span></label>
                        <div class="controls">
                            <input id="data_nascimento" type="date" name="data_nascimento" title="Digite a data de nascimento" value="<?php echo set_value('data_nascimento'); ?>"  />
                        </div>
                    </div>

                <div class="control-group" id="div_sexo">
                    <label for="sexo" class="control-label">Sexo<span class="required">*</span></label>
                    <div class="control-group btn-group" data-toggle="buttons">
                        <label for="sexo1">
                            <input type="radio" value="F" name="sexo" id="sexo1" autocomplete="off" <?php echo (set_value('sexo') == 'F')?" checked ":""; echo (!set_value('sexo'))?" checked ":""; ?>> Feminino
                        </label>
                        <label for="sexo2">
                            <input type="radio" value="M" name="sexo" id="sexo2" autocomplete="off" <?php echo (set_value('sexo') == 'M')?" checked ":""; ?>> Masculino
                        </label>

                    </div>
                </div>

                <div class="control-group" id="div_nome_fantasia">
                    <label for="nome_fantasia" class="control-label">Nome Fantasia<span class="required">*</span></label>
                    <div class="controls">
                        <input id="nome_fantasia" type="text" name="nome_fantasia" maxlength="255" title="Digite o nome fantasia" value="<?php echo set_value('nome_fantasia'); ?>"  />
                    </div>
                </div>

                <div class="control-group" id="div_razao_social">
                    <label for="razao_social" class="control-label">Razao Social<span class="required">*</span></label>
                    <div class="controls">
                        <input id="razao_social" type="text" name="razao_social" maxlength="255" title="Digite a razão Social" value="<?php echo set_value('razao_social'); ?>"  />
                    </div>
                </div>

                 

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <div class="input_fields_wrap">
                    <div class="control-group">
                        <label for="telefone" class="control-label">Telefone<span class="required">*</span></label>
                        <div class="controls">
                            <input id="telefone" type="text" name="telefone" maxlength="20" title="Telefone para contato" onkeypress="return NumeroTelefone(event)" value="<?php echo set_value('telefone'); ?>"  />
                            <!--<i class="btn btn-success add_field_button icon icon-plus" id="add_campo"></i>-->
                        </div>
                    </div>  
                </div> 

                <div class="control-group">
                    <label for="email" class="control-label">E-mail<span class="required">*</span></label>
                    <div class="controls">
                        <input id="email" type="text" name="email" maxlength="100" title="Email do cliente" value="<?php echo set_value('email'); ?>"  />
                    </div>
                </div>

                <div class="control-group">
                    <label for="documento" id="label_documento" class="control-label">CPF/CNPJ<span class="required">*</span></label>
                    <div class="controls">
                        <input id="documento" type="text" name="documento" maxlength="14" onkeypress="return SomenteNumero(event)" value="<?php echo set_value('documento'); ?>"  />
                    </div>
                </div>                

                <div class="control-group" class="control-label">
                    <label for="cep" class="control-label">CEP<span class="required">*</span></label>
                    <div class="controls">
                        <input id="cep" type="text" name="cep" maxlength="8" title="Digite o CEP do endereço do cliente" onkeypress="return MaskCep(event)" value="<?php echo set_value('cep'); ?>"  />
                    </div>
                </div>

                <div class="control-group">
                    <label for="logradouro" class="control-label">Logradouro<span class="required">*</span></label>
                    <div class="controls">
                        <input id="logradouro" type="text" name="logradouro" value="<?php echo set_value('logradouro'); ?>"  />
                    </div>
                </div>

                <div class="control-group">
                    <label for="numero" class="control-label">Número<span class="required">*</span></label>
                    <div class="controls">
                        <input id="numero" type="text" name="numero" maxlength="10" title="Número da casa" value="<?php echo set_value('numero'); ?>"  />
                    </div>
                </div>

                <div class="control-group" class="control-label">
                    <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                    <div class="controls">
                        <input id="bairro" type="text" name="bairro" value="<?php echo set_value('bairro'); ?>"  />
                    </div>
                </div>

                <div class="control-group" class="control-label">
                    <label for="cidade" class="control-label">Cidade<span class="required">*</span></label>
                    <div class="controls">
                        <input id="cidade" type="text" name="cidade" value="<?php echo set_value('cidade'); ?>"  />
                    </div>
                </div>

                <div class="control-group" class="control-label">
                    <label for="estado" class="control-label">Estado<span class="required">*</span></label>
                    <div class="controls">
                        <input id="estado" type="text" name="estado" value="<?php echo set_value('estado'); ?>"  />
                    </div>
                </div>



                <div class="form-actions">
                    <div class="span12">
                        <div class="span6">
                            <button type="submit" class="btn btn-success" title="Finalizar cadastro de cliente"><i class="icon-plus icon-white"></i> Adicionar</button>
                            <a href="<?php echo base_url() ?>index.php/clientes" id="" title="Voltar para a listagem de clientes" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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


  $("#div_nome_fantasia, #div_razao_social").hide();
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
    $("#cep").blur(function(e) {
        if($.trim($("#cep").val()) != "") {
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
        if($(this).val() == "F")
        {
            $("#div_nome_fantasia, #div_razao_social, #div_data_nascimento, #div_sexo").toggle("slow");
            document.getElementById("label_documento").innerHTML = "CPF*";
            document.getElementById("documento").setAttribute('maxlength', '11');
        }
        else if($(this).val() == "J") {
            $("#div_nome_fantasia, #div_razao_social, #div_data_nascimento, #div_sexo").toggle("slow"); 
            document.getElementById("label_documento").innerHTML = "CNPJ*";
            document.getElementById("documento").setAttribute('maxlength', '14');
        }
    });
    var tipo = "<?=set_value('tipo_pessoa')?>";
    if(!tipo) {
        tipo = $("input:radio[name=tipo_pessoa]").val();
    }
    if(tipo == 'F') {
        $("#div_data_nascimento, #div_sexo").show(); 
        $("#div_nome_fantasia, #div_razao_social").hide();
        document.getElementById("label_documento").innerHTML = "CPF*";
        document.getElementById("documento").setAttribute('maxlength', '11');
    } else {
        $("#div_nome_fantasia, #div_razao_social").show();
        $("#div_data_nascimento, #div_sexo").hide(); 
        document.getElementById("label_documento").innerHTML = "CNPJ*";
        document.getElementById("documento").setAttribute('maxlength', '14');
    }
});
</script>




