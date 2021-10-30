<div class="widget-content" id="printOs">
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
                            <td class="span3">
                                <img class="span3" src=" <?php echo $emitente[0]->url_logo; ?> ">
                            </td>
                            <td> 
                                <div style="font-size: 20px; "> 
                                    <?php echo $emitente[0]->nome; ?>
                                </div> </br>
                                <div>
                                    <?php echo $emitente[0]->cnpj; ?> </br> 
                                    <?php echo $emitente[0]->rua.', Nº '.$emitente[0]->numero.', '.$emitente[0]->bairro.' - '.$emitente[0]->cidade.' - '.$emitente[0]->uf; ?> 
                                </div> </br> 
                                <div> 
                                    E-mail: <?php echo $emitente[0]->email.' - Fone: '.$emitente[0]->telefone; ?>
                                </div>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>