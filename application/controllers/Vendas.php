<?php

class Vendas extends CI_Controller {
    
    
    function __construct() {
        parent::__construct();
        
        if((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))) {
            redirect('aski/login');
        }
		
		$this->load->helper(array('form','codegen_helper'));
        $this->load->model('vendas_model','',TRUE);
		$this->load->model('financeiro_model','',TRUE);
		$this->data['menuVendas'] = 'Vendas';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar vendas.');
           redirect(base_url());
        }

        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/vendas/gerenciar/';
        $config['total_rows'] = $this->vendas_model->count('venda');
        $config['per_page'] = 10;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        	
        //$this->pagination->initialize($config); 	

        //$this->data['results'] = $this->vendas_model->get('venda','*','',$config['per_page'],$this->uri->segment(3));
		$this->data['results'] = $this->vendas_model->get('venda','*');
       
	    $this->data['view'] = 'vendas/vendas';
       	$this->load->view('tema/topo',$this->data);
      
		
    }
	
    function adicionar(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar Vendas.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->form_validation->set_message('validar_data_venda', 'A data da venda não pode ser maior que a data atual.');
        
        if ($this->form_validation->run('vendas') == false) {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
            //$this->data['custom_error'] = (validation_errors() ? true : false);

        } else {
            $dataVenda = $this->input->post('data_venda');

            try {
                
                $dataVenda = explode('/', $dataVenda);
                $dataVenda = $dataVenda[2].'-'.$dataVenda[1].'-'.$dataVenda[0];


            } catch (Exception $e) {
               $dataVenda = date('Y/m/d'); 
            }

            $data = array(
                'data_venda' => $dataVenda,
                'id_cliente' => $this->input->post('id_cliente'),
                'id_usuario' => $this->input->post('id_usuario'),
                'faturado' => 0
            );

            if (is_numeric($id = $this->vendas_model->add('venda', $data, true)) ) {
                $this->session->set_flashdata('success','Venda iniciada com sucesso, adicione os produtos.');
                redirect('vendas/editar/'.$id);

            } else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        
        $this->data['id_status_caixa'] = $this->status_caixa();
        $this->data['status_caixa'] = $this->mensagem_status_caixa($this->data['id_status_caixa']);

        $this->data['view'] = 'vendas/adicionarVenda';
        $this->load->view('tema/topo', $this->data);
    }
    

    
    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar vendas');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('vendas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $dataVenda = $this->input->post('data_venda');

            try {                
                $dataVenda = explode('/', $dataVenda);
                $dataVenda = $dataVenda[2].'-'.$dataVenda[1].'-'.$dataVenda[0];
            } catch (Exception $e) {
               $dataVenda = date('Y/m/d'); 
            }
            $data = array(
                'data_venda' => $dataVenda,
                'id_usuario' => $this->input->post('id_usuario'),
                'id_cliente' => $this->input->post('id_cliente'),
                'valor_venda' => $this->input->post('valor'),
                'qtd_parcelas' => $this->input->post('qtd_parcelas')

            );

            if ($this->vendas_model->edit('venda', $data, 'id_venda', $this->input->post('id_venda')) == TRUE) {
                $this->session->set_flashdata('success','Venda editada com sucesso!');
                redirect(base_url() . 'index.php/vendas/editar/'.$this->input->post('id_venda'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['view'] = 'vendas/editarVenda';
        $this->load->view('tema/topo', $this->data);
   
    }

    public function visualizar(){

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar vendas.');
          redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('aski_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['lancamentos'] = $this->financeiro_model->getLancByVenda($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->aski_model->getEmitente();
        
        $this->data['view'] = 'vendas/visualizarVenda';
        $this->load->view('tema/topo', $this->data);
    }
	
    function excluir() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para excluir vendas');
          redirect(base_url());
        }
        
        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir venda.');            
            redirect(base_url().'index.php/vendas/gerenciar/');
        }

        $this->db->where('id_venda', $id);
        $this->db->delete('venda_produto');

        $this->db->where('id_venda', $id);
        $this->db->delete('venda');           

        $this->session->set_flashdata('success','Venda excluída com sucesso!');            
        redirect(base_url().'index.php/vendas/gerenciar/');

    }


    public function adicionarProduto(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar vendas.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_produto', 'Produto', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_venda', 'Vendas', 'trim|required|xss_clean');
        
        if($this->form_validation->run() == false){
           echo json_encode(array('result'=> false)); 
        }
        else{

            $preco = $this->input->post('preco');
            $quantidade = $this->input->post('quantidade');
            $subtotal = $preco * $quantidade;
            $produto = $this->input->post('id_produto');
            $data = array(
                'quantidade'=> $quantidade,
                'preco_unitario'=> $preco,
                'subtotal' => $subtotal,
                'id_produto'=> $produto,
                'id_venda'=> $this->input->post('id_venda'),
            );

            if($this->vendas_model->add('venda_produto', $data) == true){                
                echo json_encode(array('result'=> true));
            }else{
                echo json_encode(array('result'=> false));
            }

        }
        
      
    }

    function excluirProduto() {

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Vendas');
              redirect(base_url());
            }

            $ID = $this->input->post('id_produto');
            if($this->vendas_model->delete('venda_produto','id_venda_produto',$ID) == true){
                
                $quantidade = $this->input->post('quantidade');
                $produto = $this->input->post('produto');
                
                echo json_encode(array('result'=> true));
            }
            else{
                echo json_encode(array('result'=> false));
            }           
    }



    public function faturar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')) {
            $this->session->set_flashdata('error','Você não tem permissão para editar Vendas');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        $venda_produtos = $this->vendas_model->getProdutos($this->input->post('id_venda'));
        //die(print_r(count($venda_produtos) ));
        if(count($venda_produtos) > 0) {
            if ($this->form_validation->run('receita') == false) {
                $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
                echo "<br /> erro de validação <br />";
            } else {
                $qtd_parcelas = $this->input->post('qtd_parcelas');
                $vencimento = $this->input->post('vencimento');
                $recebimento = $this->input->post('recebimento');
                $valor_entrada = $this->input->post('entrada');

                // Se o valor de desconto > 0, verifica se é percentual e calcula o valor de desconto.
                if(!is_null($this->input->post('desconto')) && ($this->input->post('desconto') > 0)) {
                    $desconto = $this->input->post('desconto');
                    if(strpos($desconto, '%')) {
                        $desconto = (substr($desconto, 0, strlen($desconto)-1)) / 100;
                        $desconto = $valor * $desconto;
                    } else {
                        $desconto = $this->input->post('desconto');
                    }
                }
                $valor = $this->input->post('valor');

                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2] . '-' . $vencimento[1] . '-' . $vencimento[0];
                // Se houver uma data de recebimento, gera a mesma no formato do DB.
                if($recebimento != null) {
                    $recebimento = explode('/', $recebimento);
                    $recebimento = $recebimento[2] . '-' . $recebimento[1] . '-' . $recebimento[0];
                    if($recebimento == date('Y-m-d')) {
                        $recebimento = date('Y-m-d H:i:s');
                    }
                    if(!is_null($this->input->post('entrada'))) {
                        $entrada = $this->input->post('entrada');
                    }
                }
                // Dados para inserção em lançamentos
                $data = array(
                        'descricao' => set_value('descricao'),
                        'valor' => $this->input->post('valor'),
                        'id_cliente' => $this->input->post('id_cliente'),
                        'baixado' => $this->input->post('recebido'),
                        'cliente_fornecedor' => set_value('cliente'),
                        'forma_pgto' => $this->input->post('formaPgto'),
                        'tipo' => $this->input->post('tipo'),
                        'id_venda' => $this->input->post('id_venda'),
                        'data_vencimento' => $vencimento,
                        'data_pagamento' => $recebimento
                    );
                // Se houver um valor de entrada, sobrescreve o valor setado no array acima e seta $i como 0 para que o lancamento seja gravado como entrada e nã parcela.
                if($entrada != null) {
                    if($valor_entrada <> 0) {
                        $data['valor'] = $valor_entrada;
                    }
                    $data['entrada'] = 1;
                    $i = 0;
                } else {
                    $i = 1;
                }
                // Para cada parcela...
                for($i; $i <= $qtd_parcelas; $i++) {
                    $data['parcela'] = $i;

                    // Altera o formato das datas para Y-m-d e incrementa 30 dias para novos vencimentos
                    try {
                        if (((isset($data['entrada']) && $data['entrada'] == 1) && $i == 1) || ($i > 1)) {
                            $vencimento = date('Y-m-d', strtotime("30 days",strtotime($vencimento)));
                            $recebimento = null;
                            $data['data_vencimento'] = $vencimento;
                            $data['data_pagamento'] = $recebimento;
                            $data['entrada'] = null;
                            $data['baixado'] = null;

                            // Se houver entrada ou desconto...
                            if((isset($desconto) && $desconto <> 0) || (isset($valor_entrada) && $valor_entrada <> 0)) {
                                // Se houver entrada e desconto, deduz entrada e desconto e divide o resultado pela quantidade de parcelas
                                if ((isset($desconto) && $desconto <> 0) && (isset($valor_entrada) && $valor_entrada <> 0)) {
                                    $data['valor'] = ($valor - $desconto - $valor_entrada) / $qtd_parcelas;
                                // Se houver somente entrada, deduz a entrada e divide o resultado pela quantidade de parcelas
                                } elseif (isset($valor_entrada) && $valor_entrada <> 0){
                                    $data['valor'] = ($valor - $valor_entrada) / $qtd_parcelas;
                                // Se houver somente desconto, deduz o desconto e divide o resultado pela quantidade de parcelas
                                } elseif (isset($desconto) && $desconto <> 0) {
                                    $data['valor'] = ($valor - $desconto) / $qtd_parcelas;
                                }
                            } else {
                                if($qtd_parcelas > 1 && $data['valor'] == $valor) {
                                    $data['valor'] = $valor / $qtd_parcelas;
                                }
                            }
                        } else {
                            if($qtd_parcelas > 1 && $data['valor'] == $valor) {
                                $data['valor'] = $valor / $qtd_parcelas;
                            } 
                        }    
                        //echo $vencimento . "<br />";                                               
                    } catch (Exception $e) {
                        $vencimento = date('Y-m-d'); 
                    }
                    if($data['valor'] == 0) {
                        $venda = $this->input->post('id_venda');
                        if($recebimento != null) {
                            if($valor_entrada) {
                                $this->db->set('entrada', $valor_entrada);
                            }
                        }
                        // Marca a venda como faturada e adiciona o valor de desconto
                        $this->db->set('faturado',1);
                        $this->db->set('valor_venda',$this->input->post('valor'));
                        $this->db->set('qtd_parcelas',$this->input->post('qtd_parcelas'));
                        if (isset($desconto)) {
                            $this->db->set('valor_desconto',$desconto);
                        }
                        $this->db->where('id_venda', $venda);
                        $this->db->update('venda');
                        break;
                    }
                    // Tenta cadastrar um lançamento e verifica o valor de retorno
                    if($this->vendas_model->add('lancamentos',$data) == TRUE) {
                        // Se for a última parcela  
                        if ($i == $qtd_parcelas){
                            $venda = $this->input->post('id_venda');
                            if($recebimento != null) {
                                if($valor_entrada) {
                                    $this->db->set('entrada', $valor_entrada);
                                }
                            }
                            // Marca a venda como faturada e adiciona o valor de desconto
                            $this->db->set('faturado',1);
                            $this->db->set('valor_venda',$this->input->post('valor'));
                            $this->db->set('qtd_parcelas',$this->input->post('qtd_parcelas'));
                            if (isset($desconto)) {
                                $this->db->set('valor_desconto',$desconto);
                            }
                            $this->db->where('id_venda', $venda);
                            $this->db->update('venda');
                        
                            $this->session->set_flashdata('success','Venda faturada com sucesso!');
                            $json = array('result'=>  true);
                            echo json_encode($json);
                            die();
                        }
                    // Se houver um erro no cadastro do lancamento...
                    } else {        
                        // Se for a última parcela            
                        if ($i == $qtd_parcelas) {
                            $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
                            $json = array('result'=>  false);
                            echo json_encode($json);
                            die();   
                        }
                    }
                }

                        $this->session->set_flashdata('success','Venda faturada com sucesso!');
                        $json = array('result'=>  true);
                        echo json_encode($json);
                        die();
            }
        // Caso não tenha produtos na venda...            
        } else {
            $this->session->set_flashdata('error','Não é possível faturar uma venda sem produtos.');
            $json = array('result'=>  false);
            echo json_encode($json);
            die();
            redirect(base_url() . 'index.php/vendas/editar/'.$this->input->post('id_venda'));
            
        }
        $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda. Reveja os produtos.');
        $json = array('result'=>  false);
        echo json_encode($json);
        //echo "<br />Fim<br />";

    }

    function validar_data_venda($data) {
        $data = implode('-', array_reverse(explode('/', $data)));
        //die(print_r($data));
        if($data > date("Y-m-d")) {
            return true;
        } else {
            return true;
        }
    }

    function status_caixa() {
        $this->load->model('caixa_model', '', TRUE);
        // Busca os dados do ultimo caixa cadastrado e verifica se ele está aberto
        $caixa = $this->caixa_model->lastCaixa();
        $caixa = $this->caixa_model->getById($caixa->id_caixa);
        if(!$caixa->data_fechamento) {
            if(date('Y-m-d') > $caixa->data_abertura){
                return 2;
            } else {
                return 1;
            }   
        } else {
            return 0;
        }
    }

    function mensagem_status_caixa($id) {
        switch ($id) {
            case 2:
                return "<div class='alert alert-warning span12'>
                            <center>
                                <h3> 
                                    Sistema aguardando conclusão de caixa. <a href=" . base_url('index.php/caixas/adicionar') . ">Clique aqui para fechar caixa.</a>
                                </h3>
                            </center>
                        </div>";
                break;
            case 1:
                return "<div class='alert alert-success span12'>
                            <center>
                                <h3> 
                                    Vendas liberadas
                                </h3>
                            </center>
                        </div>";
                break;
            case 0:
                return "<div class='alert alert-danger span12'>
                            <center>
                                <h3> 
                                    É necessário abrir o caixa para efetuar uma venda. <a href=" . base_url('index.php/caixas/adicionar') . ">Clique aqui para abrir caixa.</a>
                                </h3>
                            </center>
                        </div>";
                break;
            default:
                return "<div class='alert alert-warning span12'>
                            <center>
                                <h3> 
                                    Erro desconhecido, contete o suporte técnico
                                </h3>
                            </center>
                        </div>";
                break;
        }
    }


}

