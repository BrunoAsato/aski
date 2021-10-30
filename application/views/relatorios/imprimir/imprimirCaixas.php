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
                            <h4 style="text-align: center">Resumo de caixas diário</h4>
                        </div><br />
                        <div class="widget-content nopadding">
                            <?php
                            foreach ($caixas as $c) {
                                $data_abertura = explode(' ', $c->data_abertura);
                                $data_abertura = implode('/', array_reverse(explode('-', $data_abertura[0])));

                                $hora_abertura = explode(' ', $c->data_abertura);
                                $hora_abertura = $hora_abertura[1];

                                $data_abertura = $data_abertura . " " . $hora_abertura;

                                if(!$c->data_fechamento) {
                                    $data_fechamento = ' - ';
                                    echo "<h5><b>Abertura: " . $data_abertura . " - Valor de abertura: R$ " . $c->valor_abertura . " <br />Fechamento: " . $data_fechamento . "</b></h5><br />";
                                } else {
                                    $data_fechamento = explode(' ', $c->data_fechamento);
                                    $data_fechamento = implode('/', array_reverse(explode('-', $data_fechamento[0])));
                                    $hora_fechamento = explode(' ', $c->data_fechamento);
                                    $hora_fechamento = $hora_fechamento[1];

                                    $data_fechamento = $data_fechamento . " " . $hora_fechamento;
                                    echo "<h5><b>Abertura: " . $data_abertura . " - Valor de abertura: R$ " . $c->valor_abertura . " <br />Fechamento: " . $data_fechamento . " - Valor de fechamento: R$ " . $c->valor_fechamento . "</b></h5><br />";
                                }

                                //echo "<h5><b>Abertura: " . $data_abertura . " - Valor de abertura: R$ " . $c->valor_abertura . " <br />Fechamento: " . $data_fechamento . " - Valor de fechamento: R$ " . $c->valor_fechamento . "</b></h5><br />";
                                ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 1.2em; padding: 5px;">Origem</th>
                                            <th style="font-size: 1.2em; padding: 5px;">Tipo</th>
                                            <th style="font-size: 1.2em; padding: 5px;">Vencimento</th>
                                            <th style="font-size: 1.2em; padding: 5px;">Forma de Pagamento</th>
                                            <th style="font-size: 1.2em; padding: 5px;">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalReceita = 0;
                                        $totalDespesa = 0;
                                        $saldo = 0;
                                        foreach ($lancamentos[$c->id_caixa] as $l) {
                                            if(!$c->data_fechamento) {
                                                $fechamento = date('Y-m-d H:i:s', mktime(23,59,59));
                                            } else {
                                                $fechamento = $c->data_fechamento;
                                            }



                                            if($l->data_pagamento > $c->data_abertura && $l->data_pagamento < $fechamento) {
                                                // $vencimento = date('d/m/Y', strtotime($l->data_vencimento));
                                                $vencimento = implode('/', array_reverse(explode('-', $l->data_vencimento)));
                                                //$pagamento = date('d/m/Y', strtotime($l->data_pagamento));
                                                $pagamento = implode('/', array_reverse(explode('-', $l->data_pagamento)));
                                                if($l->baixado == 1){$situacao = 'Pago';}else{ $situacao = 'Pendente';}
                                                if($l->tipo == 'receita'){ $totalReceita += $l->valor;} else{ $totalDespesa += $l->valor;}
                                                echo '<tr>';
                                                echo '<td>' . $l->cliente_fornecedor . '</td>';
                                                echo '<td>' . $l->tipo . '</td>';
                                                echo '<td>' . $vencimento. '</td>';
                                                echo '<td>' . $l->forma_pgto . '</td>';
                                                echo '<td style="text-align:right;">R$ ' . $l->valor . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" style="text-align: right; color: green"> <strong>Total Receitas:</strong></td>
                                            <td colspan="2" style="text-align: left; color: green"><strong>R$ <?php echo number_format($totalReceita,2,',','.') ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right; color: red"> <strong>Total Despesas:</strong></td>
                                            <td colspan="2" style="text-align: left; color: red"><strong>R$ <?php echo number_format($totalDespesa,2,',','.') ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right"> <strong>Saldo:</strong></td>
                                            <td colspan="2" style="text-align: left;"><strong>R$ <?php echo number_format($totalReceita - $totalDespesa,2,',','.') ?></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Arquivos js-->

        <script src="<?php echo base_url();?>js/excanvas.min.js"></script>
        <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>js/sosmc.js"></script>
        <script src="<?php echo base_url();?>js/dashboard.js"></script>
    </body>
    </html>








