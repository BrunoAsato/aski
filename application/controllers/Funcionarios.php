<?php

class Funcionarios extends CI_Controller {
    
    
    function __construct() {
        parent::__construct();
            if((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))){
            redirect('aski/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('Pessoas_model','',TRUE);
            $this->load->model('Pessoas_fisicas_model','',TRUE);
            $this->load->model('Telefones_model','',TRUE);
            $this->load->model('Funcionarios_model','',TRUE);
            $this->data['menuFuncionarios'] = 'Funcionarios';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'index.php/funcionarios/gerenciar/';
        $config['total_rows'] = $this->Funcionarios_model->count('funcionario');
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
        
        $this->data['results'] = $this->Funcionarios_model->get('funcionario','*');
       	
       	$this->data['view'] = 'funcionarios/funcionarios';
       	$this->load->view('tema/topo', $this->data);
		
    }
	
    function adicionar() {
        
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_message('documento', 'Número de CPF inválido.');
        $this->form_validation->set_message('validar_data_nascimento', 'Data de nascimento não pode ser posterior a data atual.');
        if ($this->form_validation->run('funcionarios') == false) {
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
            $pessoa->sexo = $this->input->post('sexo');
            $pessoa->data_nascimento = $this->input->post('data_nascimento');
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

            $pessoa_fisica = new stdClass();
            $pessoa_fisica->id_pessoa = $id_pessoa;
            $pessoa_fisica->cpf = $this->input->post('cpf');
            $id_pessoa_fisica = $this->Pessoas_fisicas_model->add('pessoa_fisica', $pessoa_fisica);
           

            $funcionario = new stdClass();
            $funcionario->id_pessoa_fisica = $id_pessoa_fisica;
            $funcionario->cargo = $this->input->post('cargo');
            $funcionario->data_contratacao = $this->input->post('data_contratacao');
            $id_funcionario = $this->Funcionarios_model->add('funcionario', $funcionario);

            $this->db->trans_complete();
            if($this->db->trans_status() === TRUE) {
                if ($id_funcionario == TRUE) {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('success','Funcionario adicionado com sucesso!');
                    redirect(base_url() . 'index.php/funcionarios/adicionar/');
                } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                }
            } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';            
            }
            
        }

        $this->data['view'] = 'funcionarios/adicionarFuncionario';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }
        
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_message('documento', 'Número de CPF inválido.');
        if ($this->form_validation->run('funcionariosEdit') == false) {
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
            $pessoa->sexo = $this->input->post('sexo');
            $pessoa->data_nascimento = $this->input->post('data_nascimento');
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
            } else {
                if($this->input->post('telefone')) {
                    $ntelefone = str_replace(array('-', '(', ')'), '', $this->input->post('telefone'));
                    $ddd = substr($ntelefone, 0, 2);
                    $ntelefone = substr($ntelefone, 2, strlen($ntelefone));
                    $telefone = new stdClass();
                    $telefone->tipo_telefone = $this->input->post('tipo_telefone');
                    $telefone->telefone = $ntelefone;
                    $telefone->ddd = $ddd;
                    $telefone->id_pessoa = $this->input->post('id_pessoa');
                    $this->Telefones_model->add('telefone', $telefone); 
                }
            }

            /* FAZER POSTERIORMENTE: EXCLUIR UM CASO O USUÁRIO ALTERE O TIPO DE PESSOA. SE ERA PF E ELE ALTERAR PARA PJ POR EXEMPLO, EXLUIR O PF */
            

            $pessoa_fisica = new stdClass();
            $pessoa_fisica->id_pessoa =  $this->input->post('id_pessoa');
            $pessoa_fisica->cpf = $this->input->post('cpf');
            $this->Pessoas_fisicas_model->edit('pessoa_fisica', $pessoa_fisica, 'id_pessoa_fisica', $this->input->post('id_pessoa_fisica'));

            $funcionario = new stdClass();
            $funcionario->id_pessoa_fisica =  $this->input->post('id_pessoa_fisica');
            $funcionario->cargo = $this->input->post('cargo');
            $funcionario->data_contratacao = $this->input->post('data_contratacao');
            $id_funcionario = $this->Funcionarios_model->edit('funcionario', $funcionario, 'id_funcionario', $this->input->post('id_funcionario'));

            $this->db->trans_complete();
            if($this->db->trans_status() === TRUE) {
                if ($id_funcionario == TRUE) {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('success','Funcionario editado com sucesso!');
                    redirect(base_url() . 'index.php/funcionarios/editar/' . $this->input->post('id_funcionario'));
                } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                }
            } else {
                    $this->db->trans_rollback();
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';     
            }
        }

        $funcionario = $this->Funcionarios_model->getById($this->uri->segment(3));
        /* O tipo de pessoa não é armazenado no banco de dados, por isso é necessário fazer a comparação
            dos dados recebidos, sendo que, se o cpf está preenchido, a pessoa é física, senão, juridica */

        if (isset($funcionario->cpf)) {
            $funcionario->tipo_pessoa = 'F';
        } else {
            $funcionario->tipo_pessoa = 'J';
        }
        $this->data['result'] = $funcionario;
        $this->data['view'] = 'funcionarios/editarFuncionario';
        //redirect(base_url() . 'index.php/funcionarios/editarFuncionario/');
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar() {

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->Funcionarios_model->getById($this->uri->segment(3));
        $this->data['view'] = 'funcionarios/visualizarFuncionario';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

           
            $id =  $this->input->post('id');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir funcionario.');            
                redirect(base_url().'index.php/funcionarios/gerenciar/');
            }

            if($this->Funcionarios_model->delete('funcionario','id_funcionario',$id)) {
                $this->session->set_flashdata('success','Funcionario excluido com sucesso!');            
                redirect(base_url().'index.php/funcionarios/gerenciar/');
            } else {
                $this->session->set_flashdata('error','Erro ao tentar excluir funcionario. Verifique se este funcionário não está vinculado a um usuário ou a uma venda.');            
                redirect(base_url().'index.php/funcionarios/gerenciar/');
            }

            
    }

    function validar_data_nascimento($data) {
        if($data >= date("Y-m-d")) {
            return false;
        } else {
            return true;
        }

    }

    function validar_documento($doc) {
        if($val = $this->validar_cpf($doc)) {
            return $val;
        } else {
            return $this->validar_cnpj($doc);
        }
    }

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
}

