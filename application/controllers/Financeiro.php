<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Financeiro extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		if((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))){
        	redirect('aski/login');
        }
        $this->load->model('financeiro_model','',TRUE);
        $this->data['menuFinanceiro'] = 'financeiro';
        $this->load->helper(array('codegen_helper'));
	}
	public function index(){
		$this->lancamentos();
	}

	public function lancamentos(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar lançamentos.');
           redirect(base_url());
        }

		$where = '';
		$periodo = $this->input->get('periodo');
		$situacao = $this->input->get('situacao');

        // busca todos os lançamentos
        if($periodo == 'todos'){
            if($situacao == 'previsto'){
                $where = 'data_vencimento > "'.date('Y-m-d').'" AND baixado = "0"'; 
            }
            else{
                if($situacao == 'atrasado'){
                    $where = 'data_vencimento < "'.date('Y-m-d').'" AND baixado = "0"'; 
                }
                else{
                    if($situacao == 'realizado'){
                        $where = 'baixado = "1"';
                    }

                    if($situacao == 'pendente'){
                        $where = 'baixado = "0"';
                    }
                }
            }
        } else {
            // busca lançamentos do dia 
            if($periodo == null || $periodo == 'dia'){
                $where = 'data_vencimento = "' . date('Y-m-d') . '"';
            

            } // fim lançamentos dia


            else{

                // busca lançamentos da semana
                if($periodo == 'semana'){
                    $semana = $this->getThisWeek();

                    if(! isset($situacao) || $situacao == 'todos'){
                    
                        $where = 'data_vencimento BETWEEN "'.$semana[0].'" AND "'.$semana[1].'"'; 

                    }
                    else{
                        if($situacao == 'previsto'){
                            $where = 'data_vencimento BETWEEN "'.date('Y-m-d').'" AND "'.$semana[1].'" AND baixado = "0"'; 
                        }
                        else{
                            if($situacao == 'atrasado'){
                                $where = 'data_vencimento BETWEEN "'.$semana[0].'" AND "'.date('Y-m-d').'" AND baixado = "0"'; 
                            }
                            else{
                                if($situacao == 'realizado'){
                                    $where = 'data_vencimento BETWEEN "'.$semana[0].'" AND "'.$semana[1].'" AND baixado = "1"';
                                }
                                else{
                                    $where = 'data_vencimento BETWEEN "'.$semana[0].'" AND "'.$semana[1].'" AND baixado = "0"';
                                }
                            }
                        }
                    }
                
                } // fim lançamentos dia
                else{

                    // busca lançamento do mês


                    if($periodo == 'mes'){                        
                        $mes = $this->getThisMonth();                        
                        if(! isset($situacao) || $situacao == 'todos') {                    
                            $where = 'data_vencimento BETWEEN "'.$mes[0].'" AND "'.$mes[1].'"'; 
                        } else {
                            if($situacao == 'previsto'){
                                $where = 'data_vencimento BETWEEN "'.date('Y-m-d').'" AND "'.$mes[1].'" AND baixado = "0"'; 
                            } else {
                                if($situacao == 'atrasado'){
                                    $where = 'data_vencimento BETWEEN "'.$mes[0].'" AND "'.date('Y-m-d').'" AND baixado = "0"'; 
                                } else {
                                    if($situacao == 'realizado'){
                                        $where = 'data_vencimento BETWEEN "'.$mes[0].'" AND "'.$mes[1].'" AND baixado = "1"';    
                                    } else {
                                        $where = 'data_vencimento BETWEEN "'.$mes[0].'" AND "'.$mes[1].'" AND baixado = "0"';
                                    }                                    
                                }
                            }
                        }
                    }
                    // busca lançamentos do ano
                    else{
                        $ano = $this->getThisYear();
                        
                        if(! isset($situacao) || $situacao == 'todos'){
                    
                            $where = 'data_vencimento BETWEEN "'.$ano[0].'" AND "'.$ano[1].'"';

                        }
                        else{
                            if($situacao == 'previsto'){
                                $where = 'data_vencimento BETWEEN "'.date('Y-m-d').'" AND "'.$ano[1].'" AND baixado = "0"'; 
                            }
                            else{
                                if($situacao == 'atrasado'){
                                    $where = 'data_vencimento BETWEEN "'.$ano[0].'" AND "'.date('Y-m-d').'" AND baixado = "0"'; 
                                }
                                else{
                                    if($situacao == 'realizado'){
                                        $where = 'data_vencimento BETWEEN "'.$ano[0].'" AND "'.$ano[1].'" AND baixado = "1"';        
                                    }
                                    else{
                                        $where = 'data_vencimento BETWEEN "'.$ano[0].'" AND "'.$ano[1].'" AND baixado = "0"';
                                    }
                                    
                                }
                            }
                        }   
                    }
                }
            }    
        }

        //echo "<pre>";
        //die(print_r($where));
	

		$this->load->library('pagination');
        
        $config['base_url'] = base_url().'financeiro/lancamentos';
        $config['total_rows'] = $this->financeiro_model->count('lancamentos');
        $config['per_page'] = 100;
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
        $this->pagination->initialize($config); 	

		$this->data['results'] = $this->financeiro_model->get('lancamentos','id_lancamento,descricao,valor,data_vencimento,data_pagamento,baixado,cliente_fornecedor,tipo,forma_pgto, id_venda');
        //echo "<pre>";
        //die(print_r($this->data));
        
        // Id do status de caixa, 0 = fechado; 1 = aberto; 2 = aguardando conclusão (quando o caixa foi aberto em uma data anterior a data atul)
        $this->data['id_status_caixa'] = $this->status_caixa();
       
	    $this->data['view'] = 'financeiro/lancamentos';
       	$this->load->view('tema/topo',$this->data);
	}



	function adicionarReceita() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar lançamentos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');
        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


            $vencimento = $this->input->post('vencimento');
            $recebimento = $this->input->post('recebimento');

            if($recebimento != null){
                $recebimento = explode('/', $recebimento);
                $recebimento = $recebimento[2].'-'.$recebimento[1].'-'.$recebimento[0];
            }

            if($vencimento == null){
                $vencimento = date('d/m/Y');
            }
            
            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];   

            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }

            $data = array(
                'descricao' => set_value('descricao'),
				'valor' => set_value('valor'),
				'data_vencimento' => $vencimento,
				'data_pagamento' => $recebimento != null ? $recebimento : date('Y-m-d'),
				'baixado' => $this->input->post('recebido'),
				'cliente_fornecedor' => set_value('cliente'),
				'forma_pgto' => $this->input->post('formaPgto'),
				'tipo' => set_value('tipo')
            );

            if ($this->financeiro_model->add('lancamentos',$data) == TRUE) {
                $this->session->set_flashdata('success','Receita adicionada com sucesso!');
                redirect($urlAtual);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar adicionar receita.');
        redirect($urlAtual);
        
    }


    function adicionarDespesa() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar lançamentos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');
        if ($this->form_validation->run('despesa') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $vencimento = $this->input->post('vencimento');
            $pagamento = $this->input->post('pagamento');

            if($pagamento != null){
                $pagamento = explode('/', $pagamento);
                $pagamento = $pagamento[2].'-'.$pagamento[1].'-'.$pagamento[0];
            }

            if($vencimento == null){
                $vencimento = date('d/m/Y');
            }

            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];

            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }

            $data = array(
                'descricao' => set_value('descricao'),
				'valor' => set_value('valor'),
				'data_vencimento' => $vencimento,
				'data_pagamento' => $pagamento != null ? $pagamento : date('Y-m-d'),
				'baixado' => $this->input->post('pago'),
				'cliente_fornecedor' => set_value('fornecedor'),
				'forma_pgto' => $this->input->post('formaPgto'),
				'tipo' => set_value('tipo')
            );

            if ($this->financeiro_model->add('lancamentos',$data) == TRUE) {
                $this->session->set_flashdata('success','Despesa adicionada com sucesso!');
                redirect($urlAtual);
            } else {
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar adicionar despesa!');
                redirect($urlAtual);
            }
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar adicionar despesa.');
        redirect($urlAtual);
        
        
    }


    public function editar(){   
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para editar lançamentos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');

        $this->form_validation->set_rules('descricao', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('fornecedor', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('valor', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('vencimento', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pagamento', '', 'trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $vencimento = $this->input->post('vencimento');
            $pagamento = $this->input->post('pagamento');

            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];

                $pagamento = explode('/', $pagamento);
                $pagamento = $pagamento[2].'-'.$pagamento[1].'-'.$pagamento[0];

            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }

            $data = array(
                'descricao' => $this->input->post('descricao'),
                'valor' => $this->input->post('valor'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $pagamento,
                'baixado' => $this->input->post('pago'),
                'cliente_fornecedor' => $this->input->post('fornecedor'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );

            if ($this->financeiro_model->edit('lancamentos',$data,'id_lancamento',$this->input->post('id')) == TRUE) {
                $this->session->set_flashdata('success','lançamento editado com sucesso!');
                redirect($urlAtual);
            } else {
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar editar lançamento!');
                redirect($urlAtual);
            }
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar editar lançamento.');
        redirect($urlAtual);

        $data = array(
                'descricao' => $this->input->post('descricao'),
                'valor' => $this->input->post('valor'),
                'data_vencimento' => $this->input->post('vencimento'),
                'data_pagamento' => $this->input->post('pagamento'),
                'baixado' => $this->input->post('pago'),
                'cliente_fornecedor' => set_value('fornecedor'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );
        print_r($data);

    }

    public function excluirLancamento(){   

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dLancamento')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir lançamentos.');
           redirect(base_url());
        }

    	$id = $this->input->post('id');

    	if($id == null || ! is_numeric($id)){
    		$json = array('result'=>  false);
    		echo json_encode($json);
    	}
    	else{

    		$result = $this->financeiro_model->delete('lancamentos','id_lancamento',$id); 
    		if($result){
    			$json = array('result'=>  true);
    			echo json_encode($json);
    		}
    		else{
    			$json = array('result'=>  false);
    			echo json_encode($json);
    		}
    		
    	}
    }

    public function baixarLancamento(){   
        $id = $this->input->post('id');
        if($this->input->post('dt_baixa')) {
            $dt_baixa = $this->input->post('dt_baixa');
            $dt_baixa = implode('-', array_reverse(explode('/', $dt_baixa)));
        } else {
            $dt_baixa = null;
        }
        //die(print_r($dt_baixa));

        if($id == null || ! is_numeric($id)){
            $json = array('result'=>  false);
            echo json_encode($json);
        }
        else{
            $result = $this->financeiro_model->baixarLancamento('lancamentos','id_lancamento',$id, $dt_baixa); 
            if($result){
                $json = array('result'=>  true);
                echo json_encode($json);
            }
            else{
                $json = array('result'=>  false);
                echo json_encode($json);
            }
            
        }
    }




	protected function getThisYear() {

        $dias = date("z");
        $primeiro = date("Y-m-d", strtotime("-".($dias)." day"));
        $ultimo = date("Y-m-d", strtotime("+".( 364 - $dias)." day"));
        return array($primeiro,$ultimo);

    }

    protected function getThisWeek(){

        return array(date("Y/m/d", strtotime("last sunday", strtotime("now"))),date("Y/m/d", strtotime("next saturday", strtotime("now"))));
    }

    protected function getLastSevenDays() {

        return array(date("Y-m-d", strtotime("-7 day", strtotime("now"))), date("Y-m-d", strtotime("now")));
    }

    protected function getThisMonth(){

        $mes = date('m');
        $ano = date('Y'); 
        $qtdDiasMes = date('t');
        $inicia = $ano."-".$mes."-01";

        $ate = $ano."-".$mes."-".$qtdDiasMes;
        return array($inicia, $ate);
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
                                Sistema aguardando conclusão de caixa
                            </h3>
                        </center>
                    </div>
                </div>";
                break;
            case 1:
                return "<div class='alert alert-success span12'>
                        <center>
                            <h3> 
                                Caixa aberto
                            </h3>
                        </center>
                    </div>
                </div>";
                break;
            case 0:
                return "<div class='alert alert-danger span12'>
                        <center>
                            <h3> 
                                Caixa fechado
                            </h3>
                        </center>
                    </div>
                </div>";
                break;
            default:
                return "<div class='alert alert-warning span12'>
                        <center>
                            <h3> 
                                Erro desconhecido, contete o suporte técnico
                            </h3>
                        </center>
                    </div>
                </div>";
                break;
        }
    }

}

