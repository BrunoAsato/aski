<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aVenda')){ ?>
    <a href="<?php echo base_url();?>index.php/vendas/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Venda</a>
<?php } ?>

<?php

if(!$results){?>
	<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5>Vendas</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>Data da Venda</th>
            <th>Cliente</th>
            <th>Faturado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6">Nenhuma venda Cadastrada</td>
        </tr>
    </tbody>
</table>
</div>
</div>
<?php } else{?>


<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5>Vendas</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-striped table-hover tbl_js" cellspacing="0" width="100%">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>Data da Venda</th>
            <th>Cliente</th>
            <th>Faturado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            $dataVenda = date(('d/m/Y'),strtotime($r->data_venda));
            if($r->faturado == 1) {
                $faturado = 'Faturado';
            } else { 
                if(isset($r->qtd_produtos) && $r->qtd_produtos < 1) {
                    $faturado = "<i style='color: red'>Vendas sem produtos</i>";
                } else {
                    $faturado = 'Não';
                }
            }    
            //$faturado = $r->qtd_produtos;       
            echo '<tr>';
            echo '<td data-order="'.$r->data_venda.'">'.$dataVenda.'</td>';
            echo '<td><a href="'.base_url().'index.php/clientes/visualizar/'.$r->id_cliente.'">'.$r->nomeCliente.'</a></td>';
            echo '<td>'.$faturado.'</td>';
            
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/visualizar/'.$r->id_venda.'" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if(!$r->faturado) {
                if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                    echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/editar/'.$r->id_venda.'" class="btn btn-info tip-top" title="Editar venda"><i class="icon-pencil icon-white"></i></a>'; 
                }
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dVenda')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" venda="'.$r->id_venda.'" class="btn btn-danger tip-top" title="Excluir Venda"><i class="icon-remove icon-white"></i></a>'; 
            }

            echo '</td>';
            echo '</tr>';
            }
        ?>
    </tbody>
</table>
</div>
</div>
	
<?php //echo $this->pagination->create_links();
}
?>


<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/vendas/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Venda</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idVenda" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta Venda?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('.tbl_js').DataTable( {
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "Não encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Sem registros disponíveis",
            "infoFiltered": "(Filtrado de _MAX_ registros)",
            "oPaginate": {
                "sFirst":       "Prmeiro",
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

    $(document).on('click', 'a', function(event) {        
        var venda = $(this).attr('venda');
        $('#idVenda').val(venda);
    });

});

</script>