<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Cadastro de Usuário</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formUsuario" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label  class="control-label">Funcionario<span class="required">*</span></label>
                        <div class="controls">
                            <select name="id_funcionario" id="id_funcionario">
                                <option value="" selected>Selecione um funcionario</option> 
                                  <?php foreach ($funcionarios as $f) {
                                      echo '<option value="'.$f->id_funcionario.'">'.$f->nome.' - '.$f->email.'</option>';
                                  } ?>
                            </select>
                        </div>
                    </div> 

                    <div class="control-group">
                        <label for="senha" class="control-label">Senha<span class="required">*</span></label>
                        <div class="controls">
                            <input id="senha" type="password" name="senha" maxlength="255" title="Digite uma senha" value="<?php echo set_value('senha'); ?>"  />
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label  class="control-label">Situação*</label>
                        <div class="controls">
                            <select name="id_situacao" id="id_situacao">
                                <option value="" selected>Selecione uma situação</option> 
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Esse campo faz com que os usuários sejam sempre cadastrados com permissões de vendedor -->
                    <input type="hidden" name="id_permissao" value="3" />


                    <!--
                    <div class="control-group">
                        <label  class="control-label">Permissões<span class="required">*</span></label>
                        <div class="controls">
                            <select name="permissoes_id" id="permissoes_id">
                                  <?php foreach ($permissoes as $p) {
                                      echo '<option value="'.$p->idPermissao.'">'.$p->nome.'</option>';
                                  } ?>
                            </select>
                        </div>
                    </div>
                    -->

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success" title="Finalizar cadastro de usuário"><i class="icon-plus icon-white"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/usuarios" id="" title="Voltar a listagem de usuário" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>


<script  src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){

           $('#formUsuario').validate({
            rules : {
                  id_funcionario:{ required: true},
                  login:{ required: true},
                  id_situacao:{ required: true},
                  senha:{ required: true}
            },
            messages: {
                  id_funcionario :{ required: 'Campo Requerido.'},
                  login :{ required: 'Campo Requerido.'},
                  id_situacao:{ required: 'Campo Requerido.'},
                  senha:{ required: 'Campo Requerido.'}

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




