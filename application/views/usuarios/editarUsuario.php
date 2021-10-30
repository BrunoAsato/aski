<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Usuário</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formUsuario" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <?php echo form_hidden('id_usuario',$result->id_usuario) ?>
                        <label  class="control-label">Funcionario<span class="required">*</span></label>
                        <div class="controls">
                            <select name="id_funcionario" id="id_funcionario">
                                <?php foreach ($funcionarios as $f) {
                                    echo '<option value="'.$f->id_funcionario.'"';
                                    if($result->id_funcionario == $f->id_funcionario) {
                                        echo " selected ";
                                    }
                                    echo '>'.$f->nome.' - '.$f->email.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>    

                    <div class="control-group">
                        <label for="senha" class="control-label">Senha<span class="required">*</span></label>
                        <div class="controls">
                            <input id="senha" type="password" name="senha" maxlength="255" title="Digite a nova senha" />
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label  class="control-label">Situação*</label>
                        <div class="controls">
                            <select name="id_situacao" id="situacao">
                                <?php if($result->status == 1){$ativo = ' selected '; $inativo = '';} else{$ativo = ''; $inativo = ' selected ';} ?>
                                <option value="1" <?php echo $ativo; ?>>Ativo</option>
                                <option value="0" <?php echo $inativo; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary" title="Finalizar edição de usuário"><i class="icon-ok icon-white"></i> Alterar</button>
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
                  situacao:{ required: true}
            },
            messages: {
                  id_funcionario :{ required: 'Campo Requerido.'},
                  login:{ required: 'Campo Requerido.'},
                  situacao:{ required: 'Campo Requerido.'}

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


