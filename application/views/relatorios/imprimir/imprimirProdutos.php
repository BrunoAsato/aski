<head>
    <title>ASKI - Relatórios</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/blue.css" class="skin-color" />
    <script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.10.2.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

    <body style="background-color: transparent">
        <?php
        require_once('template/header.php');
        ?>


        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <h4 style="text-align: center">Produtos</h4>
                        </div>
                        <div class="widget-content nopadding">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size: 1.2em; padding: 5px;">Nome</th>
                                        <th style="font-size: 1.2em; padding: 5px;">Estoque</th>
                                        <th style="font-size: 1.2em; padding: 5px;">Preço Compra</th>
                                        <th style="font-size: 1.2em; padding: 5px;">Preço Venda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($produtos as $p) {
                                        echo '<tr>';
                                        echo '<td>' . $p->nome. ' ' . $p->cor . ' ' . $p->tamanho . '</td>';
                                        echo '<td>' . $p->estoque. '</td>';
                                        echo '<td align="right">R$ ' . $p->preco_compra . '</td>';
                                        echo '<td align="right">R$ ' . $p->preco_venda . '</td>';
                                        echo '</tr>';
                                        $total_compra += $p->estoque * $p->preco_compra;
                                        $total_venda += $p->estoque * $p->preco_venda;

                                    }

                                    echo '<tr>';
                                    echo '<td colspan="2"> Total </td>';
                                    echo '<td align="right">R$ ' . $total_compra . '</td>';
                                    echo '<td align="right">R$ ' . $total_venda . '</td>';
                                    echo '</tr>';
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Arquivos js-->

        <script src="<?php echo base_url();?>js/excanvas.min.js"></script>
        <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>js/jquery.flot.min.js"></script>
        <script src="<?php echo base_url();?>js/jquery.flot.resize.min.js"></script>
        <script src="<?php echo base_url();?>js/jquery.peity.min.js"></script>
        <script src="<?php echo base_url();?>js/fullcalendar.min.js"></script>
        <script src="<?php echo base_url();?>js/sosmc.js"></script>
        <script src="<?php echo base_url();?>js/dashboard.js"></script>
    </body>
    </html>

