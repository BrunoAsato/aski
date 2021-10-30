<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>


<a href="<?php echo base_url();?>index.php/movimentos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Movimento</a>
    


<?php

if(!$results){?>
	<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Movimentos</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Data de movimentação</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Quantidade estoque</th>
            <th>Tipo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="5">Nenhum Movimento Cadastrado</td>
        </tr>
    </tbody>
</table>
</div>
</div>

<?php } else{?>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Movimentos</h5>

     </div>

<div class="widget-content nopadding">


<table class="table nowrap table-striped table-hover tbl_js" cellspacing="0" width="100%">
    <thead>
        <tr style="backgroud-color: #2D335B">
             <th>#</th>
             <th>Descrição</th>
             <th>Data de movimentação</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Quantidade estoque</th>
            <th>Tipo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->id_movimento.'</td>';
            echo '<td>'.$r->descricao.'</td>';
            $datahora = new DateTime($r->datahora);
            echo '<td data-order="'.$r->datahora.'">'.date_format($datahora, 'd/m/Y H:i:s').'</td>';
            echo '<td>'.$r->nm_produto . " - " . $r->material . " " . $r->cor . " " . $r->tamanho . '</td>';
            echo '<td>'.$r->quantidade.'</td>';
            echo '<td>'.$r->quantidade_estoque.'</td>';
            echo '<td>';
            echo (strtolower($r->tipo_movimentacao)=='s')?'Saída':'Entrada';
            echo '</td>';
            
            echo '<td>';
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/movimentos/visualizar/'.$r->id_movimento.'" class="btn tip-top" title="Visualizar Movimento"><i class="icon-eye-open"></i></a>  '; 
                // Se a movimentação não for correspondente a uma venda...
                if(!$r->id_venda_produto) {
                    // Se a maior datahora de uma movimentação (agrupada por produto) for igual a datahora do registro atual
                    if($r->datahora == $r->max_data_hora) {
                        // Imprima o botão de edição
                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/movimentos/editar/'.$r->id_movimento.'" class="btn btn-info tip-top" title="Editar Movimento"><i class="icon-pencil icon-white"></i></a>'; 
                        // Imprima o botão de exclusão
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" movimento="'.$r->id_movimento.'" class="btn btn-danger tip-top" title="Excluir Movimento"><i class="icon-remove icon-white"></i></a>';
                    }
                }                     
            echo '</td>';
            echo '</tr>';
        }?>
    </tbody>
</table>
</div>
</div>
	
<?php //echo $this->pagination->create_links();
}?>



<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/movimentos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Movimento</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idMovimento" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta movimento?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>


<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
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
        "stateSave": true,
        "scrollX":true
    });

    $(document).on('click', 'a', function(event) {
        
        var movimento = $(this).attr('movimento');
        $('#idMovimento').val(movimento);

    });
    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

});

       
</script>
