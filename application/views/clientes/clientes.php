<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){ ?>
    <a href="<?php echo base_url();?>index.php/clientes/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Cliente</a>    
<?php } ?>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Clientes</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>CPF/CNPJ</th>
                        <th></th> 
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Cliente Cadastrado</td>
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
        <h5>Clientes</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-striped table-hover tbl_js" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>CPF/CNPJ</th>
            <th></th> 
        </tr>
    </thead>
    <tbody>
        <?php 
        //echo "<pre>";
        //die(print_r($results));
        foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->nome.'</td>';
            if(isset($r->ddd) && isset($r->telefone)) {
                echo '<td>(' . $r->ddd . ') ';
                $telefone = '';
                // Last part
                $lp = substr($r->telefone, -4);                   
                // First part
                $fp = substr($r->telefone, 0, -4);
                echo $fp . ' ' . $lp . '</td>';                
            } else {
                echo '<td>---</td>';
            }
            echo '<td>'.$r->email.'</td>';
            echo '<td>';
            if(isset($r->cpf)) {
                $cpf = $r->cpf;
                $cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9,2);
                $r->cpf = null;
            } else {
                $cnpj = $r->cnpj;
                $cnpj = substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8,4) . '-' . substr($cnpj, 12,2);
                $r->cnpj = null;
            }
            echo isset($cpf)?$cpf:$cnpj;
            echo '</td>';
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
                echo '<a href="'.base_url().'index.php/clientes/visualizar/'.$r->id_cliente.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
                echo '<a href="'.base_url().'index.php/clientes/editar/'.$r->id_cliente.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Cliente"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" cliente="'.$r->id_cliente.'" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Cliente"><i class="icon-remove icon-white"></i></a>'; 
            }

              
            echo '</td>';
            echo '</tr>';
        }?>
    </tbody>
</table>
</div>
</div>
<?php //echo $this->pagination->create_links();
}
?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/clientes/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Cliente</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCliente" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este cliente e os dados associados a ele?</h5>
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
        $('#idCliente').val(cliente);
    });
});



</script>
