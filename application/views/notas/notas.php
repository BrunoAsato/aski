<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>


<a href="<?php echo base_url();?>index.php/notas/importar" class="btn btn-success"><i class="icon-plus icon-white"></i> Importar Notas</a>
    


<?php

if(!$results){?>
	<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Notas</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Número</th>
            <th>Série</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="5">Nenhuma Nota Cadastrada</td>
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
        <h5>Notas</h5>

     </div>

<div class="widget-content nopadding">


<table class="table nowrap table-striped table-hover tbl_js" cellspacing="0" width="100%">
    <thead>
        <tr style="backgroud-color: #2D335B">
             <th>Número</th>
             <th>Série</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->numero_nf.'</td>';
            echo '<td>'.$r->serie.'</td>';            
            echo '<td>';
            echo '<a style="margin-right: 1%" href="'.base_url().'index.php/notas/visualizar/'.$r->id_nota.'" class="btn tip-top" title="Visualizar Movimento"><i class="icon-eye-open"></i></a>  '; 
                // Imprima o botão de edição
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/notas/editar/'.$r->id_nota.'" class="btn btn-info tip-top" title="Editar Movimento"><i class="icon-pencil icon-white"></i></a>'; 
                // Imprima o botão de exclusão
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" id_nota="'.$r->id_nota.'" class="btn btn-danger tip-top" title="Excluir Movimento"><i class="icon-remove icon-white"></i></a>';
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
  <form action="<?php echo base_url() ?>index.php/notas/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Movimento</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idNota" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta nota?</h5>
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
        
        var id_nota = $(this).attr('id_nota');
        $('#idMovimento').val(id_nota);

    });
    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

});

       
</script>
