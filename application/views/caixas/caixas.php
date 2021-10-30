<a href="<?php echo base_url();?>index.php/caixas/adicionar" class="btn btn-success"> Gerenciar Caixa</a>

<?php
    if(!$results){
?>
	<div class="widget-box">
        <div class="widget-title">
            <span class="icon">
            <i class="icon-barcode"></i>
            </span>
            <h5>Caixas</h5>
        </div>

        <div class="widget-content nopadding">

        </div>
    </div>

<?php } else{ ?>

<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Caixas</h5>

    </div>

    <div class="widget-content nopadding">
        <table class="tbl_js" cellspacing="0" width="100%">
            <thead>
                <tr style="backgroud-color: #2D335B">
                    <th>Data abertura</th>
                    <th>Hora abertura</th>
                    <th>Valor abertura</th>
                    <th>Data fechamento</th>
                    <th>Hora fechamento</th>
                    <th>Valor fechamento</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($results as $r) {
                    $data = explode(' ', $r->data_abertura);
                    $hora = $data[1];
                    $data = implode('/', array_reverse(explode('-', $data[0])));
                    echo '<tr>';
                    echo '<td data-order="'.$r->data_abertura . $hora.'">' . $data . '</td>';
                    echo '<td data-order="'.$hora.'">'.$hora.'</td>';
                    echo '<td style="text-align:right;" >R$ '.$r->valor_abertura.'</td>';
                    if($r->data_fechamento) {
                        $data = explode(' ', $r->data_fechamento);
                        $hora = $data[1];
                        $data = implode('/', array_reverse(explode('-', $data[0])));
                    } else {
                        $data = '---';
                        $hora = '---';
                    }
                    echo '<td data-order="'.$r->data_fechamento.$hora.'">'.$data.'</td>';
                    echo '<td data-order="'.$hora.'">'.$hora.'</td>';
                    echo '<td style="text-align:right;">R$ ';
                    echo ($r->valor_fechamento)?$r->valor_fechamento:'---';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
	
<?php //echo $this->pagination->create_links();
}?>



<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/caixas/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Caixa</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCaixa" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta caixa?</h5>
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


    $(document).on('click', 'a', function(event) {        
        var cliente = $(this).attr('cliente');
        $('#idCaixa').val(caixa);
    });
});



</script>