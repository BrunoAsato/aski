<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends CI_Controller {
    
    
    function __construct() {
        parent::__construct();
            if((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))){
            redirect('aski/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('clientes_model','',TRUE);
            $this->load->model('Pessoas_model','',TRUE);
            $this->load->model('Pessoas_fisicas_model','',TRUE);
            $this->load->model('Pessoas_juridicas_model','',TRUE);
            $this->load->model('Telefones_model','',TRUE);
            $this->data['menuClientes'] = 'clientes';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'index.php/clientes/gerenciar/';
        $config['total_rows'] = $this->clientes_model->count('cliente');
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
        
        //$this->data['results'] = $this->clientes_model->get('cliente','cliente.*','',$config['per_page'],$this->uri->segment(3));
       	$this->data['results'] = $this->clientes_model->get('cliente','cliente.*');
        //echo "<pre>";
        //die(print_r($this->data['results']));
       	$this->data['view'] = 'clientes/clientes';
       	$this->load->view('tema/topo',$this->data);		
    }

    function adicionar() {
        $this->load->library('funcoes');
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar clientes.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if($this->input->post('tipo_pessoa') == 'F') {
            $this->form_validation->set_message('validar_data_nascimento', 'A data de nascimento não pode ser maior que a data atual.');
            $this->form_validation->set_message('validar_documento', 'Número de CPF inválido.');
            $validacao = $this->form_validation->run('clientesPF');
        } else {
            $this->form_validation->set_message('validar_documento', 'Número de CNPJ inválido.');
            $validacao = $this->form_validation->run('clientesPJ');
        }

        if ($validacao == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $this->db->trans_start();

            $pessoa = new stdClass();
            $pessoa->nome = $this->funcoes->primeirasMaiusculas($this->input->post('nome'));
            $pessoa->email = strtolower($this->input->post('email'));
            $pessoa->logradouro = $this->funcoes->primeirasMaiusculas($this->input->post('logradouro'));
            $pessoa->numero = $this->input->post('numero');
            $pessoa->bairro = $this->funcoes->primeirasMaiusculas($this->input->post('bairro'));
            $pessoa->cidade = $this->funcoes->primeirasMaiusculas($this->input->post('cidade'));
            $pessoa->cep = str_replace('-', '', $this->input->post('cep'));
            $pessoa->estado = $this->funcoes->primeirasMaiusculas($this->input->post('estado'));
            $pessoa->sexo = strtoupper($this->input->post('sexo'));
            $pessoa->data_nascimento = $this->input->post('data_nascimento');
            $id_pessoa = $this->Pessoas_model->add('pessoa', $pessoa);

            if($this->input->post('telefone')) {
                $ntelefone = str_replace(array('-', '(', ')'), '', $this->input->post('telefone'));
                $ddd = substr($ntelefone, 0, 2);
                $ntelefone = substr($ntelefone, 2, strlen($ntelefone));
                if(substr($ntelefone, 0, 1) > 7) {
                    $telefone->tipo_telefone = 'C';
                } else {
                    $telefone->tipo_telefone = 'F';
                }
                $telefone = new stdClass();
                $telefone->tipo_telefone = strtoupper($this->input->post('tipo_telefone'));
                $telefone->telefone = $ntelefone;
                $telefone->ddd = $ddd;
                $telefone->id_pessoa = $id_pessoa;
                $id_telefone = $this->Telefones_model->add('telefone', $telefone);
            }

            $documento = str_replace('.', '', 
                            str_replace('/', '', 
                                str_replace('-', '', 
                                    $this->input->post('documento')
                                )
                            )
                        );
            if($this->input->post('tipo_pessoa') == 'F') {
                $pessoa_fisica = new stdClass();
                $pessoa_fisica->id_pessoa = $id_pessoa;
                $pessoa_fisica->cpf = $documento;
                $id_pessoa_fisica = $this->Pessoas_fisicas_model->add('pessoa_fisica', $pessoa_fisica);
            } elseif($this->input->post('tipo_pessoa') == 'J') {
                $pessoa_juridica = new stdClass();
                $pessoa_juridica->id_pessoa = $id_pessoa;
                $pessoa_juridica->cnpj = $documento;
                $pessoa_juridica->nome_fantasia = $this->funcoes->primeirasMaiusculas($this->input->post('nome_fantasia'));
                $pessoa_juridica->razao_social = $this->input->post('razao_social');
                $id_pessoa_juridica = $this->Pessoas_juridicas_model->add('pessoa_juridica', $pessoa_juridica);
            }

            $cliente = new stdClass();
            $cliente->id_pessoa = $id_pessoa;
            $cliente->data_cadastro = date('Y-m-d');
            if(isset($id_pessoa_fisica)) {
                $cliente->id_pessoa_fisica = $id_pessoa_fisica;
            } else {
                $cliente->id_pessoa_juridica = $id_pessoa_juridica;
            }
            $id_cliente = $this->clientes_model->add('cliente', $cliente);

            $this->db->trans_complete();
            if($this->db->trans_status() === TRUE) {
                if ($id_cliente == TRUE) {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('success','Cliente adicionado com sucesso!');
                    redirect(base_url() . 'index.php/clientes/adicionar/');
                } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                }

            } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';           
            }
        }
        $this->data['view'] = 'clientes/adicionarCliente';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        $this->load->library('funcoes');
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }


        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')) {
           $this->session->set_flashdata('error','Você não tem permissão para editar clientes.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if($this->input->post('tipo_pessoa') == 'F') {
            $this->form_validation->set_message('validar_data_nascimento', 'A data de nascimento não pode ser maior que a data atual.');
            $this->form_validation->set_message('validade_cpf', 'Número de CPF inválido.');
            $validacao = $this->form_validation->run('clientesEditPF');
        } else {
            $this->form_validation->set_message('validar_cnpj', 'Número de CNPJ inválido.');
            $validacao = $this->form_validation->run('clientesEditPJ');
        }

        if ($validacao == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $this->db->trans_start();

            $pessoa = new stdClass();
            $pessoa->nome = $this->funcoes->primeirasMaiusculas($this->input->post('nome'));
            $pessoa->email = strtolower($this->input->post('email'));
            $pessoa->logradouro = $this->funcoes->primeirasMaiusculas($this->input->post('logradouro'));
            $pessoa->numero = $this->input->post('numero');
            $pessoa->bairro = $this->funcoes->primeirasMaiusculas($this->input->post('bairro'));
            $pessoa->cidade = $this->funcoes->primeirasMaiusculas($this->input->post('cidade'));
            $pessoa->estado = $this->funcoes->primeirasMaiusculas($this->input->post('estado'));
            $pessoa->sexo = strtoupper($this->input->post('sexo'));
            $pessoa->data_nascimento = $this->input->post('data_nascimento');
            $this->Pessoas_model->edit('pessoa', $pessoa, 'id_pessoa', $this->input->post('id_pessoa'));

            //die(print_r($pessoa->nome));

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
            } else {

                $ntelefone = str_replace(array('-', '(', ')'), '', $this->input->post('telefone'));
                $ddd = substr($ntelefone, 0, 2);
                $ntelefone = substr($ntelefone, 2, strlen($ntelefone));
                if(substr($ntelefone, 0, 1) > 7) {
                    $telefone->tipo_telefone = 'C';
                } else {
                    $telefone->tipo_telefone = 'F';
                }
                $telefone = new stdClass();
                $telefone->tipo_telefone = strtoupper($this->input->post('tipo_telefone'));
                $telefone->telefone = $ntelefone;
                $telefone->ddd = $ddd;
                $telefone->id_pessoa = $this->input->post('id_pessoa');
                $id_telefone = $this->Telefones_model->add('telefone', $telefone);
            }

            /* FAZER POSTERIORMENTE: EXCLUIR UM CASO O USUÁRIO ALTERE O TIPO DE PESSOA. SE ERA PF E ELE ALTERAR PARA PJ POR EXEMPLO, EXLUIR O PF */
            
            $documento = str_replace('.', '', 
                            str_replace('/', '', 
                                str_replace('-', '', 
                                    $this->input->post('documento')
                                )
                            )
                        );
            if($this->input->post('tipo_pessoa') == 'F') {
                $this->excluirPJ($this->input->post('id_pessoa'));
                if($this->input->post('id_pessoa_fisica')) {
                    $pessoa_fisica = new stdClass();
                    $pessoa_fisica->id_pessoa =  $this->input->post('id_pessoa');
                    $pessoa_fisica->cpf = $documento;
                    $this->Pessoas_fisicas_model->edit('pessoa_fisica', $pessoa_fisica, 'id_pessoa_fisica', $this->input->post('id_pessoa_fisica'));
                } else {
                    $pessoa_fisica = new stdClass();
                    $pessoa_fisica->id_pessoa = $this->input->post('id_pessoa');
                    $pessoa_fisica->cpf = $documento;
                    $id_pessoa_fisica = $this->Pessoas_fisicas_model->add('pessoa_fisica', $pessoa_fisica);
                }
            } elseif($this->input->post('tipo_pessoa') == 'J') {
                $this->excluirPF($this->input->post('id_pessoa'));
                if($this->input->post('id_pessoa_juridica')) {
                    $pessoa_juridica = new stdClass();
                    $pessoa_juridica->id_pessoa =  $this->input->post('id_pessoa');
                    $pessoa_juridica->cnpj = $documento;
                    $pessoa_juridica->nome_fantasia = $this->input->post('nome_fantasia');
                    $pessoa_juridica->razao_social = $this->input->post('razao_social');
                    $this->Pessoas_juridicas_model->edit('pessoa_juridica', $pessoa_juridica, 'id_pessoa_juridica', $this->input->post('id_pessoa_juridica'));
                } else {
                    $pessoa_juridica = new stdClass();
                    $pessoa_juridica->id_pessoa = $this->input->post('id_pessoa');
                    $pessoa_juridica->cnpj = $documento;
                    $pessoa_juridica->nome_fantasia = $this->funcoes->primeirasMaiusculas($this->input->post('nome_fantasia'));
                    $pessoa_juridica->razao_social = $this->input->post('razao_social');
                    $id_pessoa_juridica = $this->Pessoas_juridicas_model->add('pessoa_juridica', $pessoa_juridica);
                }
            }

            $cliente = new stdClass();
            $cliente->id_pessoa =  $this->input->post('id_pessoa');
            $cliente->data_alteracao = date('Y-m-d');
            $id_cliente = $this->clientes_model->edit('cliente', $cliente, 'id_cliente', $this->input->post('id_cliente'));

            $this->db->trans_complete();
            if($this->db->trans_status() === TRUE) {
                if ($id_cliente == TRUE) {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('success','Cliente alterado com sucesso!');
                    redirect(base_url() . 'index.php/clientes/editar/' . $this->input->post('id_cliente'));
                } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                }
            } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';     
            }
        }

        $cliente = $this->clientes_model->getById($this->uri->segment(3));
        /* O tipo de pessoa não é armazenado no banco de dados, por isso é necessário fazer a comparação
            dos dados recebidos, sendo que, se o cpf está preenchido, a pessoa é física, senão, juridica */

        if (isset($cliente->cpf)) {
            $cliente->tipo_pessoa = 'F';
        } else {
            $cliente->tipo_pessoa = 'J';
        }
        $this->data['result'] = $cliente;
        $this->data['view'] = 'clientes/editarCliente';
        //redirect(base_url() . 'index.php/clientes/editarCliente/');
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        //$this->data['results'] = $this->clientes_model->getOsByCliente($this->uri->segment(3));
        $this->data['view'] = 'clientes/visualizarCliente';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir() {            
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir clientes.');
           redirect(base_url());
        }
        
        $id =  $this->input->post('id');
        if (($id != null) && ($this->clientes_model->delete('cliente','id_cliente',$id))) {
            $this->session->set_flashdata('success','Cliente excluído com sucesso!');            
            redirect(base_url().'index.php/clientes/gerenciar/');  
        } else {
            $this->session->set_flashdata('error','Erro ao tentar excluir cliente. Um cliente associado a uma ou mais vendas não pode ser excluído.');            
            redirect(base_url().'index.php/clientes/gerenciar/'); 
        }
    }

    public function excluirPF($id) {
            $this->clientes_model->delete('pessoa_fisica','id_pessoa',$id); 
    }

    public function excluirPJ($id) {
            $this->clientes_model->delete('pessoa_juridica','id_pessoa',$id); 
    }

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->clientes_model->autoCompleteCliente($q);
        }
    }
/*
    function validar_documento($doc) {
        if($val = $this->validar_cpf($doc)) {
            return $val;
        } else {
            return $this->validar_cnpj($doc);
        }
    }67732070968
*/
    function validar_cpf($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
        // Valida tamanho
        if (strlen($cpf) != 11)
            return false;
        // Calcula e confere primeiro dígito verificador
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Calcula e confere segundo dígito verificador
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        return ($cpf{10} == ($resto < 2 ? 0 : 11 - $resto));
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

    function validar_data_nascimento($data) {
        if($data >= date("Y-m-d")) {
            return false;
        } else {
            return true;
        }

    }
}

