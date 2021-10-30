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
        <div class="row-fluid">
            <div class="invoice-content">
                <div class="invoice-head">
                    <?php
                    require_once('template/header.php');
                    ?>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 50%; padding-left: 0">
                                    <span><h5>Cliente</h5>
                                    <span><?php echo $result->nomeCliente?></span><br/>
                                    <span>Email: <?php echo $result->email?></span><br />
                                    <span><?php echo $result->logradouro?>, <?php echo $result->numero?>, <?php echo $result->bairro?></span><br/>
                                    <span><?php echo $result->cidade?> - <?php echo $result->estado?></span>
                                </td>
                                <td style="width: 50%; padding-left: 0">
                                    <span><h5>Vendedor</h5></span>
                                    <span><?php echo $result->nomeUsuario?></span> <br/>
                                    <span>Telefone: <?php echo $result->telefoneUsuario?></span><br/>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                </div>

                <div style="margin-top: 0; padding-top: 0">
                    <?php 
                    if($produtos != null) { 
                        ?>
                        <table class="table table-bordered table-condensed" id="tblProdutos">
                            <thead>
                                <tr>
                                    <th style="font-size: 15px">Produto</th>
                                    <th style="font-size: 15px">Quantidade</th>
                                    <th style="font-size: 15px">Preço unitário</th>
                                    <th style="font-size: 15px">Sub-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($produtos as $p) {

                                    $totalProdutos = $totalProdutos + $p->subtotal;
                                    echo '<tr>';                                                    
                                    echo '<td>'.$p->nome. ' ' . $p->material . ' - ' . $p->cor . ' ' . $p->tamanho . '</td>';
//echo '<td>'.$p->nome.'</td>';
                                    echo '<td>'.$p->quantidade.'</td>';
                                    echo '<td style="text-align:right;">R$ '.str_replace('.', ',', $p->preco_venda).'</td>';
                                    echo '<td style="text-align:right;">R$ '.number_format($p->subtotal,2,',','.').'</td>';
                                    echo '</tr>';

                                }?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align: right"><strong>Total:</strong></td>
                                    <td colspan="1" style="text-align: right;"><strong>R$ <?php echo number_format($totalProdutos,2,',','.');?></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right;"> <strong>Sub-total da venda:</strong></td>
                                    <td colspan="1" style="text-align: right; color: green"><strong>R$ <?php echo number_format($totalProdutos,2,',','.'); ?></strong></td>
                                </tr>
                                <?php
                                if($result->entrada) {
                                    ?>
                                    <tr>
                                        <td colspan="3" style="text-align: right;"> <strong>Entrada:</strong></td>
                                        <td colspan="1" style="text-align: right; color: green"><strong>R$ <?php echo number_format($result->entrada,2,',','.') ?></strong></td>
                                    </tr>
                                    <?php
                                }
                                if($result->valor_desconto) {
                                    ?>
                                    <tr>
                                        <td colspan="3" style="text-align: right;"> <strong>Total Descontos:</strong></td>
                                        <td colspan="1" style="text-align: right; color: red"><strong>R$ <?php echo number_format($result->valor_desconto,2,',','.') ?></strong></td>
                                    </tr>
                                    <?php
                                }
                                if($result->valor_desconto) {
                                    ?>
                                    <tr>
                                        <td colspan="3" style="text-align: right"> <strong>Total da venda:</strong></td>
                                        <td colspan="1" style="text-align: right;"><strong>R$ <?php echo number_format($totalProdutos - $result->valor_desconto,2,',','.') ?></strong></td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3" style="text-align: right"> <strong>Total da venda:</strong></td>
                                        <td colspan="1" style="text-align: right;"><strong>R$ <?php echo number_format($totalProdutos,2,',','.') ?></strong></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tfoot>
                        </table>
                        <br />
                        <?php 
// Se houver lançamentos para a venda, exibe-os
                        if($lancamentos) {
                            ?>
                            <h2>
                                <span class="icon">
                                    <i class="icon-money"></i>
                                </span>
                                Lançamentos da venda
                            </h2><br />

                            <table class="table table-striped table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <tr style="backgroud-color: #2D335B">
                                        <th>#</th>
                                        <th>Tipo</th>
                                        <th>Cliente / Fornecedor</th>
                                        <th>Vencimento</th>
                                        <th>Status</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $totalReceita = 0;
                                    $totalDespesa = 0;
                                    $saldo = 0;
                                    $total_baixado = 0;
                                    foreach ($lancamentos as $r) {
                                        $vencimento = date(('d/m/Y'),strtotime($r->data_vencimento));
                                        if($r->entrada) {
                                            $tipo_parcela = "Entrada";
                                            $label = 'primary'; 
                                        } else {
                                            $tipo_parcela = "Parcela";
                                            $label = 'success'; 
                                        }
                                        if($r->baixado == 0) {
                                            $status = 'Pendente';
                                            $label = 'important'; 
                                        } else { 
                                            $status = 'Pago';
                                            $total_baixado += $r->valor;
                                        };
                                        $totalReceita += $r->valor;
                                        echo '<tr>'; 
                                        echo '<td>'.$r->parcela.'</td>';
                                        echo '<td><span class="label label-'.$label.'">'.ucfirst($tipo_parcela).'</span></td>';
                                        echo '<td>'.$r->cliente_fornecedor.'</td>';
                                        echo '<td>'.$vencimento.'</td>';   
                                        echo '<td>'.$status.'</td>';
                                        echo '<td style="text-align:right;">R$ '.number_format($r->valor,2,',','.').'</td>';
                                        echo '</tr>';
                                    }?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right;"> <strong>Total pago:</strong></td>
                                        <td style="text-align: right; color: green"><strong>R$ <?php echo number_format($total_baixado,2,',','.') ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;"> <strong>Total a pagar:</strong></td>
                                        <td style="text-align: right; color: red"><strong>R$ <?php echo number_format($totalReceita - $total_baixado,2,',','.') ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php
// Fecha a exibiçã de lançamentos
                        }
                        ?>

                        <hr />
                        <?php
                        if($result->valor_desconto) {
                            ?>
                            <h4 style="text-align: right">Valor Total: R$ <?php echo number_format($totalProdutos - $result->valor_desconto,2,',','.');?></h4>
                            <?php
                        } else {
                            ?>
                            <h4 style="text-align: right">Valor Total: R$ <?php echo number_format($totalProdutos,2,',','.');?></h4>
                            <?php
                        }
                    }?>
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