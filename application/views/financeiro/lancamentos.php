<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<?php $situacao = $this->input->get('situacao');
	  $periodo = $this->input->get('periodo');	
 ?>

<style type="text/css">
	
	label.error{
		color: #b94a48;
	}

	input.error{
    border-color: #b94a48;
  }
  input.valid{
    border-color: #5bb75b;
  }


</style>


<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aLancamento')){ 
if($id_status_caixa == 0){
?>
<div class="alert alert-warning span12" style="margin-left: 0"><h4>É necessário abrir o caixa para cadastrar um lançamento.</h4></div>
<?php
} else {
?>
  <div class="span5" style="margin-left: 0">
      <a href="#modalReceita" data-toggle="modal" role="button" class="btn btn-success tip-bottom" title="Cadastrar nova receita"><i class="icon-plus icon-white"></i> Nova Receita</a>  
      <a href="#modalDespesa" data-toggle="modal" role="button" class="btn btn-danger tip-bottom" title="Cadastrar nova despesa"><i class="icon-plus icon-white"></i> Nova Despesa</a>
  </div>
<?php } } ?>
<!--	
<div class="span7" style="margin-left: 0">
	<form action="<?php echo current_url(); ?>" method="get" >
		<div class="span4" style="margin-left: 0">
			<label>Período <i class="icon-info-sign tip-top" title="Lançamentos com vencimento no período."></i></label>
			<select name="periodo" class="span12">
				<option value="dia">Dia</option>
				<option value="semana" <?php if($periodo == 'semana'){ echo 'selected';} ?>>Semana</option>
				<option value="mes" <?php if($periodo == 'mes'){ echo 'selected';} ?>>Mês</option>
				<option value="ano" <?php if($periodo == 'ano'){ echo 'selected';} ?>>Ano</option>
        <option value="todos" <?php if($periodo == 'todos'){ echo 'selected';} ?>>Todos</option>
			</select>
		</div>
		<div class="span4">
			<label>Situação <i class="icon-info-sign tip-top" title="Lançamentos com situação específica ou todos."></i></label>
			<select name="situacao" class="span12">
				<option value="todos">Todos</option>
				<option value="previsto" <?php if($situacao == 'previsto'){ echo 'selected';} ?>>Previsto</option>
				<option value="atrasado" <?php if($situacao == 'atrasado'){ echo 'selected';} ?>>Atrasado</option>
				<option value="realizado" <?php if($situacao == 'realizado'){ echo 'selected';} ?>>Pago</option>
        <option value="pendente" <?php if($situacao == 'pendente'){ echo 'selected';} ?>>Pendente</option>
			</select>
		</div>
		<div class="span4" >
			&nbsp
			<button type="submit" class="span12 btn btn-primary">Filtrar</button>
		</div>
		
	</form>
</div>
-->

<div class="span12" style="margin-left: 0;">

<?php

if(!$results){?>
	<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5>Lançamentos Financeiros</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Data Inicial</th>
            <th>Data Final</th>
            <th>Status</th>
            <th>Defeito</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="6">Nenhuma lançamento encontrado</td>
        </tr>
    </tbody>
</table>
</div>
</div>
<?php } else{ ?>


<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5>Lançamentos Financeiros</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-striped table-hover tbl_js" cellspacing="0" width="100%">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Tipo</th>
            <th>Origem</th>
            <th>Vencimento</th>
            <th>Status</th>
            <th>Valor</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $totalReceita = 0;
        $totalDespesa = 0;
        $saldo = 0;
        foreach ($results as $r) {
            $vencimento = date(('d/m/Y'),strtotime($r->data_vencimento));
            if($r->baixado == 0){$status = 'Pendente';}else{ $status = 'Pago';};
            if($r->tipo == 'receita'){ $label = 'success'; $totalReceita += $r->valor;} else{$label = 'important'; $totalDespesa += $r->valor;}
            echo '<tr>'; 
            echo '<td>'.$r->id_lancamento.'</td>';
            echo '<td><span class="label label-'.$label.'">'.ucfirst($r->tipo).'</span></td>';
            echo '<td>'.$r->cliente_fornecedor.'</td>';
            echo '<td data-order="'.$r->data_vencimento.'">'.$vencimento.'</td>';   
            echo '<td>'.$status.'</td>';
            echo '<td style="text-align:right;"> R$ '.number_format($r->valor,2,',','.').'</td>';
            
            echo '<td>';
            if(!$r->id_venda) {

                if(!$r->baixado) {
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eLancamento')) {
                        echo '<a href="#modalEditar" style="margin-right: 1%" data-toggle="modal" role="button" idLancamento="'.$r->id_lancamento.'" descricao="'.$r->descricao.'" valor="'.$r->valor.'" vencimento="'.date('d/m/Y',strtotime($r->data_vencimento)).'" pagamento="'.date('d/m/Y', strtotime(date('Y-m-d'))).'" baixado="'.$r->baixado.'" cliente="'.$r->cliente_fornecedor.'" formaPgto="'.$r->forma_pgto.'" tipo="'.$r->tipo.'" class="btn btn-info tip-top editar" title="Editar Lançamento"><i class="icon-pencil icon-white"></i></a>'; 
                    }
                }
                if($this->permission->checkPermission($this->session->userdata('permissao'),'dLancamento')) {
                    echo '<a href="#modalExcluir" data-toggle="modal" role="button" idLancamento="'.$r->id_lancamento.'" class="btn btn-danger tip-top excluir" title="Excluir Lançamento"><i class="icon-remove icon-white"></i></a>'; 
                }                   
            } 
            if(!$r->baixado) {
                if($this->permission->checkPermission($this->session->userdata('permissao'),'dLancamento')) {
                    echo '<a href="#modalBaixar" data-toggle="modal" role="button" idLancamento="'.$r->id_lancamento.'" class="btn btn-success tip-top baixar" title="Baixar Lançamento"><i class="icon-ok icon-white"></i></a>'; 
                }
            } 
            echo '</td>';
            echo '</tr>';
        }?>
    </tbody>
    <tfoot>
    	<tr>
    		<td colspan="5" style="text-align: right; color: green"> <strong>Total Receitas:</strong></td>
    		<td colspan="2" style="text-align: left; color: green"><strong>R$ <?php echo number_format($totalReceita,2,',','.') ?></strong></td>
    	</tr>
    	<tr>
    		<td colspan="5" style="text-align: right; color: red"> <strong>Total Despesas:</strong></td>
    		<td colspan="2" style="text-align: left; color: red"><strong>R$ <?php echo number_format($totalDespesa,2,',','.') ?></strong></td>
    	</tr>
    	<tr>
    		<td colspan="5" style="text-align: right"> <strong>Saldo:</strong></td>
    		<td colspan="2" style="text-align: left;"><strong>R$ <?php echo number_format($totalReceita - $totalDespesa,2,',','.') ?></strong></td>
    	</tr>
    </tfoot>
</table>
</div>
</div>

</div>
	
<?php //echo $this->pagination->create_links();
}?>



<!-- Modal nova receita -->
<div id="modalReceita" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="formReceita" action="<?php echo base_url() ?>index.php/financeiro/adicionarReceita" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">ASKI System - Adicionar Receita</h3>
  </div>
  <div class="modal-body">
  		
  		<div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>
    	<div class="span12" style="margin-left: 0"> 
    		<label for="descricao">Descrição</label>
    		<input class="span12" id="descricao" maxlength="255" type="text" name="descricao"  />
    		<input id="urlAtual" type="hidden" name="urlAtual" value="<?php echo current_url() ?>"  />
    	</div>	
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span12" style="margin-left: 0"> 
    			<label for="cliente">Origem*</label>
    			<input class="span12" id="cliente" type="text" name="cliente"  />
    		</div>
    		
    		
    	</div>
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" style="margin-left: 0">  
    			<label for="valor">Valor*</label>
    			<input type="hidden" id="tipo" name="tipo" value="receita" />	
    			<input class="span12 money" id="valor" type="text" name="valor"  />
    		</div>
	    	<div class="span4" >
	    		<label for="vencimento">Data Vencimento*</label>
	    		<input class="span12 datepicker" id="vencimento" type="text" name="vencimento"  />
	    	</div>
	    	
    	</div>
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" style="margin-left: 0">
    			<label for="recebido">Recebido?</label>
	    		&nbsp &nbsp &nbsp &nbsp<input  id="recebido" type="checkbox" name="recebido" value="1" />	
    		</div>
    		<div id="divRecebimento" class="span8" style=" display: none">
	    		<div class="span6">
	    			<label for="recebimento">Data Recebimento</label>
		    		<input class="span12 datepicker" id="recebimento" type="text" name="recebimento" />	
	    		</div>
	    		<div class="span6">
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
    		
    	</div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-success">Adicionar Receita</button>
  </div>
  </form>
</div>




<!-- Modal nova despesa -->
<div id="modalDespesa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="formDespesa" action="<?php echo base_url() ?>index.php/financeiro/adicionarDespesa" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">ASKI System - Adicionar Despesa</h3>
  </div>
  <div class="modal-body">
  		<div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>
    	<div class="span12" style="margin-left: 0"> 
    		<label for="descricao">Descrição</label>
    		<input class="span12" id="descricao" maxlength="255" type="text" name="descricao"  />
    		<input id="urlAtual" type="hidden" name="urlAtual" value="<?php echo current_url() ?>"  />
    	</div>	
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span12" style="margin-left: 0"> 
    			<label for="fornecedor">Origem*</label>
    			<input class="span12" id="fornecedor" type="text" name="fornecedor"  />
    		</div>
    		
    		
    	</div>
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" style="margin-left: 0">  
    			<label for="valor">Valor*</label>
    			<input type="hidden"  name="tipo" value="despesa" />	
    			<input class="span12 money"  type="text" name="valor"  />
    		</div>
	    	<div class="span4" >
	    		<label for="vencimento">Data Vencimento*</label>
	    		<input class="span12 datepicker"  type="text" name="vencimento"  />
	    	</div>
	    	
    	</div>
    	<div class="span12" style="margin-left: 0"> 
    		<div class="span4" style="margin-left: 0">
    			<label for="pago">Foi Pago?</label>
	    		&nbsp &nbsp &nbsp &nbsp<input  id="pago" type="checkbox" name="pago" value="1" />	
    		</div>
    		<div id="divPagamento" class="span8" style=" display: none">
	    		<div class="span6">
	    			<label for="pagamento">Data Pagamento</label>
		    		<input class="span12 datepicker" id="pagamento" type="text" name="pagamento" />	
	    		</div>

	    		<div class="span6">
		    		<label for="formaPgto">Forma Pgto</label>
		    		<select name="formaPgto"  class="span12">
		    			<option value="Dinheiro">Dinheiro</option>
		    			<option value="Cartão de Crédito">Cartão de Crédito</option>
		    			<option value="Cheque">Cheque</option>
		    			<option value="Boleto">Boleto</option>
		    			<option value="Depósito">Depósito</option>
		    			<option value="Débito">Débito</option>  			
		    		</select>
		    	</div>
	    	</div>
    		
    	</div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Adicionar Despesa</button>
  </div>
  </form>
</div>



<!-- Modal editar lançamento -->
<div id="modalEditar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="formEditar" action="<?php echo base_url() ?>index.php/financeiro/editar" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">ASKI System - Editar Lançamento</h3>
  </div>
  <div class="modal-body">
      <div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>
      <div class="span12" style="margin-left: 0"> 
        <label for="descricao">Descrição</label>
        <input class="span12" id="descricaoEditar" maxlength="255" type="text" name="descricao"  />
        <input id="urlAtualEditar" type="hidden" name="urlAtual" value=""  />
      </div>  
      <div class="span12" style="margin-left: 0"> 
        <div class="span12" style="margin-left: 0"> 
          <label for="fornecedor">Fornecedor / Empresa*</label>
          <input class="span12" id="fornecedorEditar" type="text" name="fornecedor"  />
        </div>
        
        
      </div>
      <div class="span12" style="margin-left: 0"> 
        <div class="span4" style="margin-left: 0">  
          <label for="valor">Valor*</label>
          <input type="hidden"  name="tipo" value="despesa" />  
          <input type="hidden"  id="idEditar" name="id" value="" /> 
          <input class="span12 money"  type="text" name="valor" id="valorEditar" />
        </div>
        <div class="span4" >
          <label for="vencimento">Data Vencimento*</label>
          <input class="span12 datepicker"  type="text" name="vencimento" id="vencimentoEditar"  />
        </div>
        <div class="span4">
          <label for="vencimento">Tipo*</label>
          <select class="span12" name="tipo" id="tipoEditar">
            <option value="receita">Receita</option>
            <option value="despesa">Despesa</option>
          </select>
        </div>
        
      </div>
      <div class="span12" style="margin-left: 0"> 
        <div class="span4" style="margin-left: 0">
          <label for="pago">Foi Pago?</label>
          &nbsp &nbsp &nbsp &nbsp<input  id="pagoEditar" type="checkbox" name="pago" value="1" /> 
        </div>
        <div id="divPagamentoEditar" class="span8" style=" display: none">
          <div class="span6">
            <label for="pagamento">Data Pagamento</label>
            <input class="span12 datepicker" id="pagamentoEditar" type="text" name="pagamento" />  
          </div>

          <div class="span6">
            <label for="formaPgto">Forma Pgto</label>
            <select name="formaPgto" id="formaPgtoEditar"  class="span12">
              <option value="Dinheiro">Dinheiro</option>
              <option value="Cartão de Crédito">Cartão de Crédito</option>
              <option value="Cheque">Cheque</option>
              <option value="Boleto">Boleto</option>
              <option value="Depósito">Depósito</option>
              <option value="Débito">Débito</option>        
            </select>
          </div>
        </div>
        
      </div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelarEditar">Cancelar</button>
    <button class="btn btn-primary">Salvar Alterações</button>
  </div>
  </form>
</div>






<!-- Modal Excluir lançamento-->
<div id="modalExcluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">ASKI System - Excluir Lançamento</h3>
  </div>
  <div class="modal-body">
    <h5 style="text-align: center">Deseja realmente excluir esse lançamento?</h5>
    <input name="id" id="idExcluir" type="hidden" value="" />
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-danger" id="btnExcluir">Excluir Lançamento</button>
  </div>
</div>

<!-- Modal Baixar lançamento-->
<div id="modalBaixar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">ASKI System - Baixar Lançamento</h3>
  </div>
  <div class="modal-body">
    <h5 style="text-align: center">Deseja realmente Baixar esse lançamento?</h5>
    <input name="id" id="idBaixar" type="hidden" value="" />

      <div class="span4" >
        <label for="dt_baixa">Data da baixa</label>
        <input class="span12 datepicker"  type="text" name="dt_baixa" id="dt_baixa"  />
      </div>
  </div>

  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelBaixar">Cancelar</button>
    <button class="btn btn-success" id="btnBaixar">Baixar Lançamento</button>
  </div>
</div>



<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
    $('.tbl_js').DataTable( {
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "Não encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Sem registros disponíveis",
            "infoFiltered": "(Filtrado de _MAX_ registros)",
            "oPaginate": {
                "sFirst":       "Primeiro",
                "sPrevious":    "Anterior",
                "sNext":        "Próximo",
                "sLast":        "Último"
            },
            "oAria": {
                "sSortAscending":  ": Habilitar a classificação da coluna em ordem crescente",
                "sSortDescending": ": Habilitar a classificação da coluna em ordem decrescente"
            },
            "sLoadingRecords":  "Carregando registros...",
            "sProcessing":      "Processando...",
            "sSearch":          "Pesquisar"
        },
        "stateSave": true
    });

		$(".money").maskMoney();

		$('#pago').click(function(event) {
			var flag = $(this).is(':checked');
			if(flag == true){
				$('#divPagamento').show();
			}
			else{
				$('#divPagamento').hide();
			}
		});


		$('#recebido').click(function(event) {
			var flag = $(this).is(':checked');
			if(flag == true){
				$('#divRecebimento').show();
			}
			else{
				$('#divRecebimento').hide();
			}
		});

    $('#pagoEditar').click(function(event) {
      var flag = $(this).is(':checked');
      if(flag == true){
        $('#divPagamentoEditar').show();
      }
      else{
        $('#divPagamentoEditar').hide();
      }
    });


		$("#formReceita").validate({
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
          }
    });



		$("#formDespesa").validate({
          rules:{
             descricao: {required:true},
             fornecedor: {required:true},
             valor: {required:true},
             vencimento: {required:true}
      
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             fornecedor: {required: 'Campo Requerido.'},
             valor: {required: 'Campo Requerido.'},
             vencimento: {required: 'Campo Requerido.'}
          }
       	});
    

    $(document).on('click', '.excluir', function(event) {
      $("#idExcluir").val($(this).attr('idLancamento'));
    });

    $(document).on('click', '.baixar', function(event) {
      $("#idBaixar").val($(this).attr('idLancamento'));
    });


    $(document).on('click', '.editar', function(event) {
      $("#idEditar").val($(this).attr('idLancamento'));
      $("#descricaoEditar").val($(this).attr('descricao'));
      $("#fornecedorEditar").val($(this).attr('cliente'));
      $("#valorEditar").val($(this).attr('valor'));
      $("#vencimentoEditar").val($(this).attr('vencimento'));
      $("#pagamentoEditar").val($(this).attr('pagamento'));
      $("#formaPgtoEditar").val($(this).attr('formaPgto'));
      $("#tipoEditar").val($(this).attr('tipo'));
      $("#urlAtualEditar").val($(location).attr('href'));
      var baixado = $(this).attr('baixado');
      if(baixado == 1){
        $("#pagoEditar").attr('checked', true);
        $("#divPagamentoEditar").show();
      }
      else{
        $("#pagoEditar").attr('checked', false); 
        $("#divPagamentoEditar").hide();
      }
      

    });

    $(document).on('click', '#btnExcluir', function(event) {
        var id = $("#idExcluir").val();
    
        $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>index.php/financeiro/excluirLancamento",
          data: "id="+id,
          dataType: 'json',
          success: function(data)
          {
            if(data.result == true){
                $("#btnCancelExcluir").trigger('click');
                $("#divLancamentos").html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
                $("#divLancamentos").load( $(location).attr('href')+" #divLancamentos" );
                alert("Lançamento excluído com sucesso.");
                window.location.reload();
                
            }
            else{
                $("#btnCancelExcluir").trigger('click');
                alert('Ocorreu um erro ao tentar excluir produto.');
            }
          }
        });
        return false;
    });

    $(document).on('click', '#btnBaixar', function(event) {
        var id = $("#idBaixar").val();
        var dt_baixa = $("#dt_baixa").val();
        //var dados = $(#)
    
        $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>index.php/financeiro/baixarLancamento",
          data: {"id":id, "dt_baixa":dt_baixa},
          dataType: 'json',
          success: function(data)
          {
            if(data.result == true){
                $("#btnCancelBaixar").trigger('click');
                $("#divLancamentos").html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
                $("#divLancamentos").load( $(location).attr('href')+" #divLancamentos" );
                alert("Lançamento baixado com sucesso.");
                window.location.reload();
                
            }
            else{
                $("#btnCancelBaixar").trigger('click');
                alert('Ocorreu um erro ao tentar baixar o lançamento. A data de pagamento não pode ser menor que a data da venda.');
            }
          }
        });
        return false;
    });
 
    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

	});

</script>


