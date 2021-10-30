<a href="<?php echo base_url();?>index.php/funcionarios/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Funcionario</a>    

<?php

if(!$results) {?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Funcionarios</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>CPF</th>
                        <th>Cargo</th>
                        <th></th> 
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Funcionario Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
    function mask($val, $mask) {
       $maskared = '';
       $k = 0;
       for($i = 0; $i<=strlen($mask)-1; $i++) {
           if($mask[$i] == '#') {
               if(isset($val[$k])) {
                   $maskared .= $val[$k++];
               }
           } else {
               if(isset($mask[$i])) {
                   $maskared .= $mask[$i];
               }
           }
       }
       return $maskared;
    }
?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Funcionarios</h5>

     </div>

    <div class="widget-content nopadding">
        <table class="table table-striped table-hover tbl_js" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Cargo</th>
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
                    echo mask($r->cpf,'###.###.###-##');
                    echo '</td>';
                    echo '<td>'.$r->cargo.'</td>';
                    echo '<td>';
                        echo '<a href="'.base_url().'index.php/funcionarios/visualizar/'.$r->id_funcionario.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                        echo '<a href="'.base_url().'index.php/funcionarios/editar/'.$r->id_funcionario.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Funcionario"><i class="icon-pencil icon-white"></i></a>'; 
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" funcionario="'.$r->id_funcionario.'" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Funcionario"><i class="icon-remove icon-white"></i></a>'; 

                      
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
  <form action="<?php echo base_url() ?>index.php/funcionarios/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Funcionario</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idFuncionario" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este funcionario e os dados associados a ele?</h5>
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
        
        var funcionario = $(this).attr('funcionario');
        $('#idFuncionario').val(funcionario);

    });

});

</script>
