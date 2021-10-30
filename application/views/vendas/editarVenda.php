<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Editar Venda</h5>
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da Venda</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divEditarVenda">                                
                                <form action="<?php echo current_url(); ?>" method="post" id="formVendas">
                                    <?php echo form_hidden('id_venda',$result->id_venda) ?>
                                    
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <h3>#Venda: <?php echo $result->id_venda ?></h3>
                                        <div class="span2" style="margin-left: 0">
                                            <label for="dataFinal">Data Final</label>
                                            <input id="data_venda" class="span12 datepicker" type="text" name="data_venda" value="<?php echo date('d/m/Y', strtotime($result->data_venda)); ?>"  />
                                        </div>
                                        <div class="span5" >
                                            <label for="cliente">Cliente<span class="required">*</span></label>
                                            <input id="cliente" class="span12" type="text" name="cliente" value="<?php echo $result->nome ?>"  />
                                            <input id="id_cliente" class="span12" type="hidden" name="id_cliente" value="<?php echo $result->id_cliente ?>"  />
                                            <input id="valorTotal" type="hidden" name="valorTotal" value=""  />
                                        </div>
                                        <div class="span5">
                                            <label for="tecnico">Vendedor<span class="required">*</span></label>
                                            <input id="tecnico" class="span12" type="text" name="tecnico" value="<?php echo $result->nomeUsuario ?>"  />
                                            <input id="id_usuario" class="span12" type="hidden" name="id_usuario" value="<?php echo $result->id_usuario ?>"  />
                                        </div>
                                        
                                    </div>
                                    
                                    
                                   
                                   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
            
                                        <div class="span8 offset2" style="text-align: center">
                                            <?php if($result->faturado == 0){ ?>
                                            <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> Faturar</a>
                                            <?php } ?>
                                            <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>
                                            <a href="<?php echo base_url() ?>index.php/vendas/visualizar/<?php echo $result->id_venda; ?>" class="btn btn-inverse"><i class="icon-eye-open"></i> Visualizar Venda</a>
                                            <a href="<?php echo base_url() ?>index.php/vendas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>

                                    </div>

                                </form>
                                
                                <div class="span12 well" style="padding: 1%; margin-left: 0">
                                        <?php
                                            if(!$result->faturado) {
                                        ?>
                                        <form id="formProdutos" action="<?php echo base_url(); ?>index.php/vendas/adicionarProduto" method="post">
                                            <div class="span8">
                                                <input type="hidden" name="id_produto" id="id_produto" />
                                                <input type="hidden" name="id_venda" id="id_venda" value="<?php echo $result->id_venda?>" />
                                                <input type="hidden" name="estoque" id="estoque" value=""/>
                                                <input type="hidden" name="preco" id="preco" value=""/>
                                                <label for="">Produto</label>
                                                <input type="text" class="span12" name="produto" id="produto" placeholder="Digite o nome do produto" />
                                            </div>
                                            <div class="span2">
                                                <label for="">Quantidade</label>
                                                <input type="text" placeholder="Quantidade" id="quantidade" name="quantidade" onkeypress="return SomenteNumero(event)" class="span12" />
                                            </div>
                                            <div class="span2">
                                                <label for="">&nbsp</label>
                                                <button class="btn btn-success span12" id="btnAdicionarProduto"><i class="icon-white icon-plus"></i> Adicionar</button>
                                            </div>
                                        </form>
                                        <?php
                                            }
                                        ?>

                                    </div>
                                    <div class="span12" id="divProdutos" style="margin-left: 0">
                                        <table class="table table-bordered" id="tblProdutos">
                                            <thead>
                                                <tr>
                                                    <th>Produto</th>
                                                    <th>Quantidade</th>
                                                    <?php
                                                        if(!$result->faturado) {
                                                    ?>
                                                    <th>Ações</th>
                                                    <?php
                                                        }
                                                    ?>
                                                    <th>Sub-total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total = 0;
                                                foreach ($produtos as $p) {
                                                  //die(print_r($p));
                                                    
                                                    $total = $total + $p->subtotal;
                                                    echo '<tr>';
                                                    echo '<td>'.$p->nome. ' ' . $p->material . ' - ' . $p->cor . ' ' . $p->tamanho . '</td>';
                                                    echo '<td>'.$p->quantidade.'</td>';
                                                    if(!$result->faturado) {
                                                        echo '<td><a href="" idAcao="'.$p->id_venda_produto.'" prodAcao="'.$p->id_produto.'" quantAcao="'.$p->quantidade.'" title="Excluir Produto" class="btn btn-danger"><i class="icon-remove icon-white"></i></a></td>';
                                                    }
                                                    echo '<td>R$ '.number_format($p->subtotal,2,',','.').'</td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                               
                                                <tr>
                                                    <?php
                                                        if(!$result->faturado) {
                                                    ?>
                                                    <td colspan="3" style="text-align: right"><strong>Total:</strong></td>
                                                    <?php
                                                        } else {
                                                    ?>
                                                    <td colspan="2" style="text-align: right"><strong>Total:</strong></td>
                                                    <?php
                                                        }
                                                    ?>
                                                    <td>
                                                        <strong>R$ <?php echo number_format($total,2,',','.');?></strong> 
                                                        <input type="hidden" id="total-venda" value="<?php echo number_format($total,2); ?>">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>


                                        


                                    </div>

                            </div>

                        </div>

                    </div>

                </div>


.

        </div>

    </div>
</div>
</div>


<!-- Modal Faturar-->
<div id="modal-faturar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form id="formFaturar" action="<?php echo current_url() ?>" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Faturar Venda</h3>
  </div>
  <div class="modal-body">
      
      <div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>
      <div class="span12" style="margin-left: 0"> 
        <label for="descricao">Descrição</label>
        <input class="span12" id="descricao" type="text" name="descricao" value="Fatura de Venda - #<?php echo $result->id_venda; ?> "  />
        
      </div>  
      <div class="span12" style="margin-left: 0"> 
        <div class="span12" style="margin-left: 0"> 
          <label for="cliente">Cliente*</label>
          <input class="span12" id="cliente" type="text" name="cliente" value="<?php echo $result->nome ?>" />
          <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $result->id_cliente ?>">
          <input type="hidden" name="id_venda" id="id_venda" value="<?php echo $result->id_venda; ?>">
        </div>
        
        
      </div>
      <div class="span12" style="margin-left: 0"> 
        <div class="span4" style="margin-left: 0">  
          <label for="mostra_valor">Valor*</label>
          <input type="hidden" id="tipo" name="tipo" value="receita" /> 
          <input class="span12 money" id="mostra_valor" disabled="" type="text" name="mostra_valor" value="<?php echo number_format($total,2); ?> "  />
          <input class="span12 money" id="valor" type="hidden" name="valor" value="<?php echo number_format($total,2); ?> "  />
        </div>
        <div class="span4">  
          <label for="desconto">Desconto</label>
          <input class="span12 money" id="desconto" type="text" name="desconto" />
          <!-- onblur=" return valida_desconto_valor(<?php echo number_format($total,2); ?>);" -->
        </div>
        <div class="span4">  
          <label for="qtd_parcelas">Parcelas*</label>
          <input class="span12" maxlength="2" id="qtd_parcelas" type="text" name="qtd_parcelas" value="01" onkeypress="return SomenteNumero(event)" />
        </div>
        <div class="span4" style="margin-left: 0">
          <label for="vencimento">Data Vencimento*</label>
          <input class="span12 datepicker" id="vencimento" type="text" name="vencimento" />
        </div>  
          <div class="span4">
              <label for="formaPgto">Forma Pgto</label>
              <select name="formaPgto" id="formaPgto" class="span12">
                  <option value="Dinheiro">Dinheiro</option>
                  <option value="Cartão de Crédito">Cartão de Crédito</option>
                  <option value="Cheque">Cheque</option>
                  <option value="Boleto">Boleto</option>
                  <option value="Depósito">Depósito</option>
                  <option value="Débito">Débito</option>        
              </select>
          </div>  

      </div>
      
      <div class="span12" style="margin-left: 0"> 
        <div class="span4" style="margin-left: 0">
          <label for="recebido">Recebido?</label>
          &nbsp &nbsp &nbsp &nbsp<input  id="recebido" type="checkbox" name="recebido" value="1" /> 
        </div>
        <div id="divRecebimento" class="span8" style=" display: none">
          <div class="span6">  
            <label for="entrada">Entrada</label>
            <input class="span12 money" id="entrada" type="text" name="entrada" />
          </div>
          <div class="span6">
            <label for="recebimento">Data Recebimento</label>
            <input class="span12 datepicker" id="recebimento" type="text" name="recebimento" /> 
          </div>
        </div>
        
      </div>     
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btn-cancelar-faturar">Cancelar</button>
    <button class="btn btn-primary" id="faturar-final">Faturar</button>
  </div>
</form>
</div>
 

<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){

     $(".money").maskMoney(); 

     $('#recebido').click(function(event) {
        var flag = $(this).is(':checked');
        if(flag == true){
          $('#divRecebimento').show();
        }
        else{
          $('#divRecebimento').hide();
        }
     });

     $(document).on('click', '#btn-faturar', function(event) {
       event.preventDefault();
         valor = $('#total-venda').val();
         valor = valor.replace(',', '' );
         $('#mostra_valor').val(valor);
         $('#valor').val(valor);
     });

    $(document).on('click', '#faturar-final', function(event) {
        //event.preventDefault();
        valor = $('#mostra_valor').val();
        entrada = $('#entrada').val();
        desconto = $('#desconto').val();
        qtd_parcelas = $('#qtd_parcelas').val();
        valor = valor.replace(',', '' );
            entrada = parseInt(entrada);
            desconto = parseInt(desconto);
            valor = parseInt(valor);
            qtd_parcelas = parseInt(qtd_parcelas);


        if((desconto != '' && desconto != 0 && desconto != null) && desconto > (valor*0.3)) {
            alert("O desconto dado é maior que 30% do valor da venda.");
        }

        if ((desconto != '' && desconto != 0 && desconto != null) && (entrada != '' && entrada != 0 && entrada != null)) {
            if ((desconto + entrada) > valor) {
                alert("O valor da entrada + desconto não pode ser maior que o valor da venda");
                $('#desconto').select();
                return false;
            }
        }
        if((entrada != '' && entrada != 0 && entrada != null) && entrada > valor) {
            alert("O valor da entrada não pode ser maior que o valor da venda");
            $('#entrada').select();
            return false;
        }
        if((desconto != '' && desconto != 0 && desconto != null) && desconto > valor) {
            alert("O valor do desconto não pode ser maior que o valor da venda");
            $('#desconto').select();
            return false;
        }
        if((((desconto != '' && desconto != 0 && desconto != null) && desconto == valor) || 
                ((entrada != '' && entrada != 0 && entrada != null) && entrada == valor) || 
                (entrada+desconto) == valor) && (qtd_parcelas > 1)) {
            alert('Não é possível parcelar esse valor, reveja a condição de pagamento.');
            return false;
        }
        if((desconto != '' && desconto != 0 && desconto != null) && desconto == valor) {
            if(confirm("Voce deu um desconto de 100%. Deseja continuar o faturamento desta venda?")) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    });

     
    $("#formFaturar").validate({
        rules:{
         descricao: {required:true},
         cliente: {required:true},
         valor: {required:true},
         vencimento: {required:true}

        },
        messages:{
         descricao: {required: 'Campo Requerido.'},
         cliente: {required: 'Campo Requerido.'},
         valor: {required: 'Campo Requerido.'},
         vencimento: {required: 'Campo Requerido.'}
        },
        submitHandler: function( form ) {    
            var dados = $( form ).serialize();
            $('#btn-cancelar-faturar').trigger('click');
            $.ajax({
              type: "POST",
              url: "<?php echo base_url();?>index.php/vendas/faturar",
              data: dados,
              dataType: 'json',
              success: function(data)
              {
                if(data.result == true) {
                    window.location.reload(true);
                }
                else{
                    alert('Ocorreu um erro ao tentar faturar venda.');
                    $('#progress-fatura').hide();
                }
              }
              });
              return false;
          }
    });

     $("#produto").autocomplete({
            source: "<?php echo base_url(); ?>index.php/produtos/autoCompleteProduto",
            minLength: 2,
            select: function( event, ui ) {

                 $("#id_produto").val(ui.item.id);
                 $("#estoque").val(ui.item.estoque);
                 $("#preco").val(ui.item.preco);
                 $("#quantidade").focus();
                 

            }
      });



      $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/clientes/autoCompleteCliente",
            minLength: 2,
            select: function( event, ui ) {

                 $("#id_cliente").val(ui.item.id);


            }
      });

      $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/usuarios/autoCompleteUsuario",
            minLength: 2,
            select: function( event, ui ) {
                 $("#id_usuario").val(ui.item.id);
            }
      });



      $("#formVendas").validate({
          rules:{
             cliente: {required:true},
             tecnico: {required:true},
             data_venda: {required:true}
          },
          messages:{
             cliente: {required: 'Campo Requerido.'},
             tecnico: {required: 'Campo Requerido.'},
             data_venda: {required: 'Campo Requerido.'}
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




      $("#formProdutos").validate({
          rules:{
             quantidade: {required:true}
          },
          messages:{
             quantidade: {required: 'Insira a quantidade'}
          },
          submitHandler: function( form ){
             var quantidade = parseInt($("#quantidade").val());
             var estoque = parseInt($("#estoque").val());
             if(estoque < quantidade){
                alert('Você não possui estoque suficiente.');
                $('#quantidade').select();
             }
             else{
                 var dados = $( form ).serialize();
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/adicionarProduto",
                  data: dados,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divProdutos" ).load("<?php echo current_url();?> #divProdutos" );
                        $("#quantidade").val('');
                        $("#produto").val('').focus();
                    }
                    else{
                        alert('Ocorreu um erro ao tentar adicionar produto.');
                    }
                  }
                  });

                  return false;
                }

             }
             
       });

     

       $(document).on('click', 'a', function(event) {
            var id_produto = $(this).attr('idAcao');
            var quantidade = $(this).attr('quantAcao');
            var produto = $(this).attr('prodAcao');
            if((id_produto % 1) == 0){
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/excluirProduto",
                  data: "id_produto="+id_produto+"&quantidade="+quantidade+"&produto="+produto,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $( "#divProdutos" ).load("<?php echo current_url();?> #divProdutos" );
                        
                    }
                    else{
                        alert('Ocorreu um erro ao tentar excluir produto.');
                    }
                  }
                  });
                  return false;
            }
            
       });

       //$(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
       $("#vencimento").datepicker({
            dateFormat: "dd/mm/yy",
            onSelect: function (selectedDate) {
                var hoje = dataAtualFormatada();
                if (selectedDate < hoje)
                    alert("A data de vencimento não pode ser menor que a data atual.");
                    $("#vencimento").value = "";
                    $("#vencimento").focus();
            }
        });
       $("#recebimento").datepicker({
            dateFormat: "dd/mm/yy",
            onSelect: function (selectedDate) {
                var hoje = dataAtualFormatada();
                if (selectedDate > hoje)
                    alert("A data de recebimento não pode ser maior que a data atual.");
                    $("#recebimento").value = "";
                    $("#recebimento").focus();
            }
        });

       function dataAtualFormatada(){
            var data = new Date();
            var dia = data.getDate();
            if (dia.toString().length == 1)
              dia = "0"+dia;
            var mes = data.getMonth()+1;
            if (mes.toString().length == 1)
              mes = "0"+mes;
            var ano = data.getFullYear();  
            return dia+"/"+mes+"/"+ano;
        }
/*
       $("#vencimento").blur(function(){
            alert(new Date());
            var vencimento = document.getElementbyId("vencimento");
            //alert(vencimento.value);
            if(vencimento.value < hoje) {
                alert("A data de vencimento não pode ser menor que a data atual");
            }
       });
       $("#recebimento").blur(function(){
            var recebimento = document.getElementbyId("recebimento");
            if(recebimento.value > new Date()) {
                alert("A data de recebimento não pode ser maior que a data atual.");
            }
       });



    var max_fields = 10; //maximum input boxes allowed
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID

  var x = 1; //initlal text box count
  $(add_button).click(function(e) { //on add input button click
    alert('teste');
    e.preventDefault();
    var length = wrapper.find("input:text").length;

    if (x < max_fields) { //max input box allowed
      x++; //text box increment
      $(wrapper).append('<div><input type="text" name="Texto' + (length+1) + '" /><a href="#" class="remove_field">Remove</a></div>'); //add input box
    }
    //Fazendo com que cada uma escreva seu name
    wrapper.find("input:text").each(function() {
      $(this).val($(this).attr('name'))
    });
  });

  $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
    e.preventDefault();
    $(this).parent('div').remove();
    x--;
  })*/


});

</script>

