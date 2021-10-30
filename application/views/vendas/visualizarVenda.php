<?php $totalProdutos = 0;?>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Venda</h5>
                <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){

                        if(!$result->faturado) {
                            echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/vendas/editar/'.$result->id_venda.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                        }
                    } ?>

                    <!--<a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>-->
                    <a href="<?php echo base_url('index.php/relatorios/vendaCliente/' . $result->id_venda);?>" title="Imprimir" class="btn btn-mini btn-inverse" href="">
                        <i class="icon-print icon-white"></i> Imprimir
                    </a>
                </div>
            </div>
            <div class="widget-content" id="printVenda">
                <div class="invoice-content">
                    <div class="invoice-head">
                        <table class="table table-bordered">
                            <tbody>

                                <?php if($emitente == null) {?>

                                    <tr>
                                        <td colspan="3" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?php echo base_url(); ?>index.php/aski/emitente">Configurar</a><<<</td>
                                    </tr>
                                <?php } else {?>

                                    <tr>
                                        <td style="width: 25%"><img src=" <?php echo $emitente[0]->url_logo; ?> "></td>
                                        <td> <span style="font-size: 20px; "> <?php echo $emitente[0]->nome; ?></span> </br><span><?php echo $emitente[0]->cnpj; ?> </br> <?php echo $emitente[0]->rua.', nº:'.$emitente[0]->numero.', '.$emitente[0]->bairro.' - '.$emitente[0]->cidade.' - '.$emitente[0]->uf; ?> </span> </br> <span> E-mail: <?php echo $emitente[0]->email.' - Fone: '.$emitente[0]->telefone; ?></span></td>
                                        <td style="width: 18%; text-align: center">#Venda: <span ><?php echo $result->id_venda?></span></br> </br> <span>Emissão: <?php echo date('d/m/Y');?></span></td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span><h5>Cliente</h5>
                                                    <span><?php echo $result->nomeCliente?></span><br/>
                                                    <span>Email: <?php echo $result->email?></span><br />
                                                    <span><?php echo $result->logradouro?>, <?php echo $result->numero?>, <?php echo $result->bairro?></span><br/>
                                                    <span><?php echo $result->cidade?> - <?php echo $result->estado?></span>
                                                </li>
                                            </ul>
                                        </td>
                                        <td style="width: 50%; padding-left: 0">
                                            <ul>
                                                <li>
                                                    <span><h5>Vendedor</h5></span>
                                                    <span><?php echo $result->nomeUsuario?></span> <br/>
                                                    <span>Telefone: <?php echo $result->telefoneUsuario?></span><br/>
                                                </li>
                                            </ul>
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
                                            <td colspan="3" style="text-align: right; color: green"> <strong>Sub-total da venda:</strong></td>
                                            <td colspan="1" style="text-align: right; color: green"><strong>R$ <?php echo number_format($totalProdutos,2,',','.'); ?></strong></td>
                                        </tr>
                                        <?php
                                        if($result->entrada) {
                                            ?>
                                            <tr>
                                                <td colspan="3" style="text-align: right; color: green"> <strong>Entrada:</strong></td>
                                                <td colspan="1" style="text-align: right; color: green"><strong>R$ <?php echo number_format($result->entrada,2,',','.') ?></strong></td>
                                            </tr>
                                            <?php
                                        }
                                        if($result->valor_desconto) {
                                            ?>
                                            <tr>
                                                <td colspan="3" style="text-align: right; color: red"> <strong>Total Descontos:</strong></td>
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
                                                echo '<td>'.$r->id_lancamento.'</td>';
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
                                                <td colspan="5" style="text-align: right; color: green"> <strong>Total pago:</strong></td>
                                                <td colspan="2" style="text-align: right; color: green"><strong>R$ <?php echo number_format($total_baixado,2,',','.') ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right; color: red"> <strong>Total a pagar:</strong></td>
                                                <td colspan="2" style="text-align: right; color: red"><strong>R$ <?php echo number_format($totalReceita - $total_baixado,2,',','.') ?></strong></td>
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
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#imprimir").click(function() {         
                PrintElem('#printVenda');
            })

            function PrintElem(elem) {
                Popup($(elem).html());
            }

            function Popup(data) {
                var mywindow = window.open('', 'ASKI System', 'height=600,width=800');
                mywindow.document.write('<html><head><title>ASKI System</title>');
                mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' />");
                mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");
                mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/matrix-style.css' />");
                mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/matrix-media.css' />");
                mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/font-awesome/css/font-awesome.css'/>");
                mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/fullcalendar.css' /> ");
                mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/estilo.css' /> ");
                mywindow.document.write("<link rel='stylesheet' type='text/css' href='//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css'>");
                mywindow.document.write("<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800'>");
                mywindow.document.write("<link rel='icon' href='<?php echo base_url();?>assets/img/logo.ico' type='image/x-icon' />");
                mywindow.document.write("<link rel='shortcut icon' href='<?php echo base_url();?>assets/img/logo.ico' type='image/x-icon' />");

                mywindow.document.write('</head><body>');
                mywindow.document.write(data);
                mywindow.document.write("</body><footer>");
                mywindow.document.write("<script src='<?php echo base_url();?>assets/js/bootstrap.min.js'> </ script>");
                mywindow.document.write("<script src='<?php echo base_url();?>assets/js/matrix.js'> </ script>");
                mywindow.document.write("<script src='<?php echo base_url();?>assets/js/script.js'> </ script>");
                mywindow.document.write("<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-1.10.2.min.js'> < /script>");
                mywindow.document.write('<footer></html>');
                mywindow.print();
                mywindow.close();

                return true;
            }

        });
    </script>