<a href="<?php echo base_url();?>index.php/categorias/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Categoria</a>

<?php
    if(!$results){
?>
	<div class="widget-box">
        <div class="widget-title">
            <span class="icon">
            <i class="icon-barcode"></i>
            </span>
            <h5>Categorias</h5>
    </div>

<div class="widget-content nopadding">


</div>
</div>

<?php } else{?>

<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Categorias</h5>

    </div>

    <div class="widget-content nopadding">
        <table class="table table-striped table-hover tbl_js" cellspacing="0" width="100%">
            <thead>
                <tr style="backgroud-color: #2D335B">
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data cadastro</th>
                    <th>Data alteração</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($results as $r) {
                    $dt_cadastro = explode(' ', $r->dt_cadastro);
                    $dt_cadastro = implode('/', array_reverse(explode('-', $dt_cadastro[0])));
                    $dt_alteracao = explode(' ', $r->dt_alteracao);
                    $dt_alteracao = implode('/', array_reverse(explode('-', $dt_alteracao[0])));
                    echo '<tr>';
                    echo '<td>'.$r->nome.'</td>';
                    echo '<td>'.$r->descricao.'</td>';
                    echo '<td data-order="'.$r->dt_cadastro.'">'.$dt_cadastro.'</td>';
                    echo '<td data-order="'.$r->dt_alteracao.'">'.$dt_alteracao.'</td>';
                    
                    echo '<td>';
                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/categorias/visualizar/'.$r->id_categoria.'" class="btn tip-top" title="Visualizar Categoria"><i class="icon-eye-open"></i></a>  '; 

                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/categorias/editar/'.$r->id_categoria.'" class="btn btn-info tip-top" title="Editar Categoria"><i class="icon-pencil icon-white"></i></a>'; 

                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" categoria="'.$r->id_categoria.'" class="btn btn-danger tip-top" title="Excluir Categoria"><i class="icon-remove icon-white"></i></a>'; 

                             
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
  <form action="<?php echo base_url() ?>index.php/categorias/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Categoria</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCategoria" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta categoria?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>


<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>


<script type="text/javascript">

$(document).ready(function(){
    $('#tbl_categorias').DataTable();
});


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
        "scrollX": true
    });


    $(document).on('click', 'a', function(event) {
        var categoria = $(this).attr('categoria');
        $('#idCategoria').val(categoria);

    });

});

</script>