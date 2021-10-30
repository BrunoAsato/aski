<!DOCTYPE html>
<html lang="pt">
<head>
<title>ASKI</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css');?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/matrix-style.css');?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/matrix-media.css');?>" />
<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/fullcalendar.css');?>" /> 
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/css/estilo.css');?>" /> 

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
<link rel="icon" href="<?php echo base_url();?>assets/img/logo.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo base_url();?>assets/img/logo.ico" type="image/x-icon" />

</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href=""></a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
   
    <li class=""><a title="" href="<?php echo base_url();?>index.php/aski/sair"><i class="icon icon-share-alt"></i> <span class="text">Sair do Sistema</span></a></li>
  </ul>
</div>

<!--start-top-serch-->
<?php
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  if(!strpos($url, 'pesquisar')) {
?>
    <div id="search">
        <form action="<?php echo base_url()?>index.php/aski/pesquisar">
            <input type="text" name="termo" placeholder="Pesquisar..." title="Pesquisa produtos e clientes no sistema."/>
            <button type="submit"  class="tip-bottom" title="Pesquisar"><i class="icon-search icon-white"></i></button>
        </form>
    </div>
<?php
}
?>
<!--close-top-serch--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
  <ul>


    <li class="<?php if(isset($menuPainel)){echo 'active';};?>"><a href="<?php echo base_url()?>"><i class="icon icon-home"></i> <span>Painel</span></a></li>
    
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){ ?>
        <li class="<?php if(isset($menuServicos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/servicos"><i class="icon icon-wrench"></i> <span>Serviços</span></a></li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){ ?>
        <li class="<?php if(isset($menuOs)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/os"><i class="icon icon-tags"></i> <span>Ordens de Serviço</span></a></li>
    <?php } ?>
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vArquivo')){ ?>
        <li class="<?php if(isset($menuArquivos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/arquivos"><i class="icon icon-hdd"></i> <span>Arquivos</span></a></li>
    <?php } ?>

        <li class="submenu <?php if(isset($menuPessoas)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-list-alt"></i> <span>Estoque</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
                <li class="<?php if(isset($menuCategorias)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/categorias"><i class="icon icon-th-large"></i> <span>Categorias</span></a></li>

                <li class="<?php if(isset($menuMovimentos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/movimentos"><i class="icon icon-resize-full"></i> <span>Movimentos</span></a></li>

                <li class="<?php if(isset($menuNotas)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/notas"><i class="icon icon-resize-full"></i> <span>Notas Fiscais</span></a></li>

                <li class="<?php if(isset($menuProdutos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/produtos"><i class="icon icon-barcode"></i> <span>Produtos</span></a></li>

          </ul>
        </li>    

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){ ?>
        <li class="submenu <?php if(isset($menuFinanceiro)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-money"></i> <span>Financeiro</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
              <li><a href="<?php echo base_url()?>index.php/caixas"><i class="icon-exchange"></i><span> Caixa</a></li>

            <li><a href="<?php echo base_url()?>index.php/financeiro/lancamentos"><i class="icon-exchange"></i><span> Lançamentos</a></li>

            <li class="<?php if(isset($menuVendas)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/vendas"><i class="icon icon-shopping-cart"></i> <span>Vendas</span></a></li>
          </ul>
        </li>
    <?php } ?>

        <li class="submenu <?php if(isset($menuPessoas)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-list-alt"></i> <span>Pessoas</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
                <li><a href="<?php echo base_url()?>index.php/clientes"><i class="icon icon-group"></i> <span>Clientes</span></a></li>
              <li><a href="<?php echo base_url()?>index.php/fornecedores"><i class="icon icon-suitcase"></i> <span>Fornecedores</span></a></li>
                <li><a href="<?php echo base_url()?>index.php/funcionarios"><i class="icon icon-group"></i> <span>Funcionarios</span></a></li>
          </ul>
        </li>
        
        <li class="submenu <?php if(isset($menuRelatorios)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-paste"></i> <span>Relatórios</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
                <li><a href="<?php echo base_url()?>index.php/relatorios/caixas"><i class="icon icon-exchange"></i> Caixas</a></li>

            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/clientes"><i class="icon icon-group"></i> Clientes</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/produtos"><i class="icon icon-barcode"></i> Produtos</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/servicos">Serviços</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){ ?>
                 <li><a href="<?php echo base_url()?>index.php/relatorios/os">Ordens de Serviço</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/vendas"><i class="icon icon-shopping-cart"></i> Vendas</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/financeiro"><i class="icon icon-money"></i> Financeiro</a></li> 
            <?php } ?>
            
          </ul>
        </li>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')  || $this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente') || $this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao') || $this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-cogs"></i> <span>Configurações</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){ ?>
                <li><a href="<?php echo base_url()?>index.php/usuarios"><i class="icon icon-user"></i> Usuários</a></li>
            <?php } ?>

            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){ ?>
                <!-- <li><a href="<?php echo base_url()?>index.php/aski/emitente">Emitente</a></li> -->
            <?php } ?>

            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao')){ ?>
                <li><a href="<?php echo base_url()?>index.php/permissoes">Permissões</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
                <li><a href="<?php echo base_url()?>index.php/aski/backup"><i class="icon icon-download-alt"></i> Backup</a></li>
            <?php } ?>
              <li><a href="https://academiaasato.com.br/phpMyAdmin/" target="_blank"><i class="icon icon-check-empty"></i> Database</a></li>
 
          </ul>
        </li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')  || $this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente') || $this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao') || $this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-cogs"></i> <span>ML</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
        <ul>
          <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
                <li><a href="<?php echo base_url()?>index.php/aski/backup"><i class="icon icon-download-alt"></i> Produtos</a></li>
            <?php } ?>
        </ul>
    <?php } ?>
    
    
  </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?php echo base_url()?>" title="Painel" class="tip-bottom"><i class="icon-home"></i> Painel</a> <?php if($this->uri->segment(1) != null){?><a href="<?php echo base_url().'index.php/'.$this->uri->segment(1)?>" class="tip-bottom" title="<?php echo ucfirst($this->uri->segment(1));?>"><?php echo ucfirst($this->uri->segment(1));?></a> <?php if($this->uri->segment(2) != null){?><a href="<?php echo base_url().'index.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3) ?>" class="current tip-bottom" title="<?php echo ucfirst($this->uri->segment(2)); ?>"><?php echo ucfirst($this->uri->segment(2));} ?></a> <?php }?></div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
          <?php if($this->session->flashdata('error') != null){?>
                            <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('error');?>
                           </div>
                      <?php }?>

                      <?php if($this->session->flashdata('success') != null){?>
                            <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('success');?>
                           </div>
                      <?php }?>
                          
                      <?php
                            $this->load->view($view);
                      ?>


      </div>
    </div>
  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2017 - <?php echo date('Y'); ?> &copy; Bruno Asato</div>
</div>
<!--end-Footer-part-->


<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/matrix.js"></script> 
<script src="<?php echo base_url();?>assets/js/script.js"></script> 


</body>
</html>







