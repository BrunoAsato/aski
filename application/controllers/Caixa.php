<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caixas extends CI_Controller {
    
    
    function __construct() {
        parent::__construct();
        //die(print_r($htis->session->has_userdata('session_id')));
        if((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))){
            redirect('aski/login');
        }
        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('caixa_model', '', TRUE);
        $this->data['menuCaixas'] = 'Caixas';
    }

    function index(){
	   $this->gerenciar();
    }

    function gerenciar(){

        $this->load->library('table');
        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/caixas/gerenciar/';
        $config['total_rows'] = $this->caixa_model->count('caixa');
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
        
        $this->pagination->initialize($config); 	

	    $this->data['results'] = $this->caixa_model->get('caixa','*','',$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'caixas/caixas';
       	$this->load->view('tema/topo',$this->data);
       
		
    }
	
    function adicionar() {
        $this->load->library('funcoes');
           // die(print_r($this->input->post()));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('caixas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'descricao' => $this->input->post('descricao'),
                'nome' => $this->funcoes->primeirasMaiusculas($this->input->post('nome')),
                'dt_cadastro' => date('Y-m-d H:i:s')
            );
            if ($this->caixa_model->add('caixa', $data) == TRUE) {
                $this->session->set_flashdata('success','Caixa adicionado com sucesso!');
                redirect(base_url() . 'index.php/caixas/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        $this->data['view'] = 'caixas/adicionarCaixa';
        $this->load->view('tema/topo', $this->data);
    }

    function editar() {
        $this->load->library('funcoes');
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }

        
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('caixasEdit') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
              $data = array(
                'descricao' => set_value('descricao'),
                'nome' => $this->funcoes->primeirasMaiusculas(set_value('nome')),
                'dt_alteracao' => date('Y-m-d H:i:s')
            );

            if ($this->caixa_model->edit('caixa', $data, 'id_caixa', $this->input->post('id_caixa')) == TRUE) {
                $this->session->set_flashdata('success','Caixa editado com sucesso!');
                redirect(base_url() . 'index.php/caixas/editar/'.$this->input->post('id_caixa'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';
            }
        }

        $this->data['result'] = $this->caixa_model->getById($this->uri->segment(3));

        $this->data['view'] = 'caixas/editarCaixa';
        $this->load->view('tema/topo', $this->data);
     
    }


    function visualizar() {
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }
        
      
        $this->data['result'] = $this->caixa_model->getById($this->uri->segment(3));

        if($this->data['result'] == null){
            $this->session->set_flashdata('error','Caixa não encontrado.');
            redirect(base_url() . 'index.php/caixas/editar/'.$this->input->post('id_caixa'));
        }

        $this->data['view'] = 'caixas/visualizarCaixa';
        $this->load->view('tema/topo', $this->data);
     
    }
	
    function excluir(){

        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir caixa.');            
            redirect(base_url().'index.php/caixas/gerenciar/');
        }

        try{
            $acao = $this->caixa_model->delete('caixa','id_caixa',$id);
        }
        catch (SqlException $ex) {
            SqlException::throwDeleteException($ex);
        }
        if($acao){
            $this->session->set_flashdata('success', 'Caixa excluída com sucesso!');            
            redirect(base_url().'index.php/caixas/gerenciar/');
        } else {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir caixa.');            
            redirect(base_url().'index.php/caixas/gerenciar/');
        }

        $this->session->set_flashdata('success','Caixa excluida com sucesso!');            
        redirect(base_url().'index.php/caixas/gerenciar/');
        
    }
}

