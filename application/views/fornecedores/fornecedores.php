<a href="<?php echo base_url();?>index.php/fornecedores/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Fornecedor</a>    

<?php
if(!$results){?>

    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Fornecedores</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>CNPJ</th>
                        <th>Descrição</th>
                        <th></th> 
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Fornecedor Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
    

?>
    <div class="widget-box">
         <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
             </span>
            <h5>Fornecedors</h5>

         </div>

        <div class="widget-content nopadding">
            <table class="table table-striped table-hover tbl_js" cellspacing="0" width="100%">
                <thead>
                    <tr>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>CNPJ</th>
                                    <th>Descrição</th>
                                    <th></th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($results as $r) {
                        echo '<tr>';
                        echo '<td>'.$r->nome.'</td>';
                        if(isset($r->ddd) && isset($r->telefone)) {
                            echo '<td>(' . $r->ddd . ') ' . $r->telefone . '</td>';                
                        } else {
                            echo '<td>---</td>';
                        }
                        echo '<td>'.$r->email.'</td>';
                        echo '<td>';
                        echo $r->cnpj;
                        echo '</td>';
                        echo '<td>'.$r->descricao.'</td>';
                        echo '<td>';
                            echo '<a href="'.base_url().'index.php/fornecedores/visualizar/'.$r->id_fornecedor.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                            echo '<a href="'.base_url().'index.php/fornecedores/editar/'.$r->id_fornecedor.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Fornecedor"><i class="icon-pencil icon-white"></i></a>'; 
                            echo '<a href="#modal-excluir" role="button" data-toggle="modal" fornecedor="'.$r->id_fornecedor.'" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Fornecedor"><i class="icon-remove icon-white"></i></a>'; 

                          
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
  <form action="<?php echo base_url() ?>index.php/fornecedores/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Fornecedor</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idFornecedor" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este fornecedor e os dados associados a ele?</h5>
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
        
        var fornecedor = $(this).attr('fornecedor');
        $('#idFornecedor').val(fornecedor);

    });

});

</script>
