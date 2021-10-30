<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<div class="row-fluid" style="margin-top:0">
    <?=$status_caixa;?>
</div>
<div class="row-fluid" style="margin-top:0">


    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-money"></i>
                </span>
                <h5>Caixa</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                <?php if ($custom_error != '') {
                                    echo $custom_error;
                                    // 2 - Sistema aguardando conclusão de caixa
                                    // 1 - Caixa aberto
                                    // 0 - Caixa fechado
                                } 
                                    // Se o caixa estiver aberto ou aguardando conclusão, há uma data de abertura
                                    $data_abertura = explode(' ', $caixa->data_abertura);
                                    $data_abertura = implode('/', array_reverse(explode('-', $data_abertura[0]))) . " " . $data_abertura[1];
                                    if($id_status_caixa == 0) {
                                        $data_fechamento = explode(' ', $caixa->data_fechamento);
                                        $data_fechamento = implode('/', array_reverse(explode('-', $data_fechamento[0]))) . " " . $data_fechamento[1];
                                    }
                                ?>
                                <form action="<?php echo current_url(); ?>" method="post" id="formCaixas">

                                    <div class="span12" style="padding: 1%">

                                        <div class="span2">
                                            <label>Data de abertura</label>
                                            <label><?php echo ($id_status_caixa == 1 || $id_status_caixa == 2)?$data_abertura:date('d/m/Y H:i:s'); ?></label>
                                            <input id="data_abertura" class="span12" type="hidden" name="data_abertura" value="<?php echo ($id_status_caixa == 1 || $id_status_caixa == 2)?'':date('Y-m-d H:i:s'); ?>" <?php echo ($id_status_caixa <> 0)?'disabled=""':''; ?>  />
                                        </div>
                                        <div class="span2">
                                            <label for="valor_abertura">Valor abertura<span class="required">*</span></label>
                                            <input id="valor_abertura" class="span12 money" type="text" name="valor_abertura" value="<?php echo ($id_status_caixa == 1 || $id_status_caixa == 2)?$caixa->valor_abertura:''; ?>" <?php echo ($id_status_caixa == 0)?'':' disabled="" '; ?> />
                                        </div>
                                        <div class="span2 offset2">
                                            <label>Data de fechamento</label>
                                            <label><?php echo ($id_status_caixa == 1 || $id_status_caixa == 2)?date('Y-m-d H:i:s'):'---'; ?></label>
                                            <input id="data_fechamento" class="span12" type="hidden" name="data_fechamento" value="<?php echo ($id_status_caixa == 1 || $id_status_caixa == 2)?date('Y-m-d H:i:s'):''; ?>" <?php echo ($id_status_caixa == 0)?'disabled=""':''; ?>  />
                                        </div>
                                        <div class="span2">
                                            <label for="valor_fechamento">Valor fechamento<span class="required">*</span></label>
                                            <input id="valor_fechamento" class="span12 money" type="text" name="valor_fechamento" value="" <?php echo ($id_status_caixa == 1 || $id_status_caixa == 2)?'':' disabled="" '; ?> />
                                        </div>                                        
                                    </div>
                              
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6 offset3" style="text-align: center">
                                            <?php if ($id_status_caixa == 1 || $id_status_caixa == 2) { ?>
                                                <button class="btn btn-success" id="btnContinuar" title="Dar continuidade a venda"><i class="icon-share-alt icon-white"></i> Fechar caixa</button>
                                            <?php
                                                } else {
                                            ?>
                                                <button class="btn btn-success" id="btnContinuar" title="Dar continuidade a venda"><i class="icon-share-alt icon-white"></i> Abrir caixa</button>
                                            <?php
                                                }
                                            ?>
                                            <a href="<?php echo base_url() ?>index.php/caixas" class="btn" title="Voltar a listagem de caixas"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".money").maskMoney();
    });
</script>