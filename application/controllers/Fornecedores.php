<?php

class Fornecedores extends CI_Controller {
    
    
    function __construct() {
        parent::__construct();
            if((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))){
            redirect('aski/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('Pessoas_model','',TRUE);
            $this->load->model('Pessoas_juridicas_model','',TRUE);
            $this->load->model('Telefones_model','',TRUE);
            $this->load->model('Fornecedores_model','',TRUE);
            $this->data['menuFornecedores'] = 'Fornecedores';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'index.php/fornecedores/gerenciar/';
        $config['total_rows'] = $this->Fornecedores_model->count('fornecedor');
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
        
        $this->data['results'] = $this->Fornecedores_model->get('fornecedor','*');
       	
       	$this->data['view'] = 'fornecedores/fornecedores';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
    function adicionar() {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_message('validar_documento', 'Número de CNPJ inválido.');
        if ($this->form_validation->run('fornecedores') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $this->db->trans_start();

            $pessoa = new stdClass();
            $pessoa->nome = $this->input->post('nome');
            $pessoa->email = $this->input->post('email');
            $pessoa->logradouro = $this->input->post('logradouro');
            $pessoa->numero = $this->input->post('numero');
            $pessoa->bairro = $this->input->post('bairro');
            $pessoa->cidade = $this->input->post('cidade');
            $pessoa->cep = str_replace('-', '', $this->input->post('cep'));
            $pessoa->estado = $this->input->post('estado');
            $id_pessoa = $this->Pessoas_model->add('pessoa', $pessoa);

            $ntelefone = str_replace(array('-', '(', ')'), '', $this->input->post('telefone'));
            $ddd = substr($ntelefone, 0, 2);
            $ntelefone = substr($ntelefone, 2, strlen($ntelefone));
            if(substr($ntelefone, 0, 1) > 7) {
                $telefone->tipo_telefone = 'C';
            } else {
                $telefone->tipo_telefone = 'F';
            }
            $telefone = new stdClass();
            $telefone->tipo_telefone = $this->input->post('tipo_telefone');
            $telefone->telefone = $ntelefone;
            $telefone->ddd = $ddd;
            $telefone->id_pessoa = $id_pessoa;
            $id_telefone = $this->Telefones_model->add('telefone', $telefone);

            $pessoa_juridica = new stdClass();
            $pessoa_juridica->id_pessoa = $id_pessoa;
            $pessoa_juridica->cnpj = $this->input->post('cnpj');
            $id_pessoa_juridica = $this->Pessoas_juridicas_model->add('pessoa_juridica', $pessoa_juridica);

            $fornecedor = new stdClass();
            $fornecedor->id_pessoa_juridica = $id_pessoa_juridica;
            $fornecedor->descricao = $this->input->post('descricao');
            $id_fornecedor = $this->Fornecedores_model->add('fornecedor', $fornecedor);

            $this->db->trans_complete();
            if($this->db->trans_status() === TRUE) {
                if ($id_fornecedor == TRUE) {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('success','Fornecedor adicionado com sucesso!');
                    redirect(base_url() . 'index.php/fornecedores/adicionar/');
                } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                }
            } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';            
            }
            
        }

        $this->data['view'] = 'fornecedores/adicionarFornecedor';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }
        // Carregar biblioteca de validação de formularios
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_message('validar_cnpj', 'Número de CNPJ inválido.');
        // Faz a chamada de validacao do form_validatrion
        if ($this->form_validation->run('fornecedoresEdit') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $this->db->trans_start();

            $pessoa = new stdClass();
            $pessoa->nome = $this->input->post('nome');
            $pessoa->email = $this->input->post('email');
            $pessoa->logradouro = $this->input->post('logradouro');
            $pessoa->numero = $this->input->post('numero');
            $pessoa->bairro = $this->input->post('bairro');
            $pessoa->cidade = $this->input->post('cidade');
            $pessoa->estado = $this->input->post('estado');
            $this->Pessoas_model->edit('pessoa', $pessoa, 'id_pessoa', $this->input->post('id_pessoa'));

            if($this->input->post('id_telefone')) {
                $ntelefone = str_replace(array('-', '(', ')'), '', $this->input->post('telefone'));
                $ddd = substr($ntelefone, 0, 2);
                $ntelefone = substr($ntelefone, 2, strlen($ntelefone));
                $telefone = new stdClass();
                $telefone->tipo_telefone = $this->input->post('tipo_telefone');
                $telefone->telefone = $ntelefone;
                $telefone->ddd = $ddd;
                $telefone->id_pessoa = $this->input->post('id_pessoa');
                $this->Telefones_model->edit('telefone', $telefone, 'id_telefone', $this->input->post('id_telefone'));
            }

            $pessoa_juridica = new stdClass();
            $pessoa_juridica->id_pessoa =  $this->input->post('id_pessoa');
            $pessoa_juridica->cnpj = $this->input->post('cnpj');
            $this->Pessoas_juridicas_model->edit('pessoa_juridica', $pessoa_juridica, 'id_pessoa_juridica', $this->input->post('id_pessoa_juridica'));

            $fornecedor = new stdClass();
            $fornecedor->id_pessoa_juridica =  $this->input->post('id_pessoa_juridica');
            $fornecedor->descricao = $this->input->post('descricao');
            $id_fornecedor = $this->Fornecedores_model->edit('fornecedor', $fornecedor, 'id_fornecedor', $this->input->post('id_fornecedor'));

            $this->db->trans_complete();
            if($this->db->trans_status() === TRUE) {
                if ($id_fornecedor == TRUE) {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('success','Fornecedor alterado com sucesso!');
                    redirect(base_url() . 'index.php/fornecedores/editar/' . $this->input->post('id_fornecedor'));
                } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                }
            } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';     
            }
        }

        $fornecedor = $this->Fornecedores_model->getById($this->uri->segment(3));
        /* O tipo de pessoa não é armazenado no banco de dados, por isso é necessário fazer a comparação
            dos dados recebidos, sendo que, se o cpf está preenchido, a pessoa é física, senão, juridica */

        if (isset($fornecedor->cnpj)) {
            $fornecedor->tipo_pessoa = 'J';
        } else {
            $fornecedor->tipo_pessoa = 'F';
        }
        $this->data['result'] = $fornecedor;
        $this->data['view'] = 'fornecedores/editarFornecedor';
        //redirect(base_url() . 'index.php/fornecedores/editarFornecedor/');
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar() {

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->Fornecedores_model->getById($this->uri->segment(3));
        $this->data['view'] = 'fornecedores/visualizarFornecedor';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            
        $id =  $this->input->post('id');
                if (($id != null) && ($this->Fornecedores_model->delete('fornecedor','id_fornecedor',$id))) {
                    $this->session->set_flashdata('success','Fornecedor excluído com sucesso!');            
                    redirect(base_url().'index.php/fornecedores/gerenciar/');  
                } else {
                    $this->session->set_flashdata('error','Erro ao tentar excluir fornecedor.');            
                    redirect(base_url().'index.php/fornecedores/gerenciar/'); 
                }
    }

    function validar_cnpj($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }
}


