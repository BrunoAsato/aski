<?php

class Usuarios extends CI_Controller {
    
    
    function __construct() {

        parent::__construct();
        if ((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))) {
            redirect('aski/login');
        }
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){
          $this->session->set_flashdata('error','Você não tem permissão para configurar os usuários.');
          redirect(base_url());
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('usuarios_model', '', TRUE);
        $this->data['menuUsuarios'] = 'Usuários';
        $this->data['menuConfiguracoes'] = 'Configurações';
    }

    function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        $this->load->library('pagination');
        

        $config['base_url'] = base_url().'index.php/usuarios/gerenciar/';
        $config['total_rows'] = $this->usuarios_model->count('usuario');
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

		$this->data['results'] = $this->usuarios_model->get($config['per_page']);
       
	    $this->data['view'] = 'usuarios/usuarios';
       	$this->load->view('tema/topo',$this->data);
		
    }
	
    function adicionar(){  
          
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('usuarios') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);

        } else {     
            $this->load->library('encrypt');                       
            $data = array(
                    'id_funcionario' => $this->input->post('id_funcionario'),
					'senha' => $this->encrypt->hash($this->input->post('senha')),
                    //'login' => $this->input->post('login'),
					'status' => $this->input->post('id_situacao'),
                    'id_permissao' => $this->input->post('id_permissao'),
					'data_cadastro' => date('Y-m-d H:i:s')
            );
           
			if ($this->usuarios_model->add('usuario',$data) == TRUE)
			{
                                $this->session->set_flashdata('success','Usuário cadastrado com sucesso!');
				redirect(base_url().'index.php/usuarios/adicionar/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';

			}
		}
        
        $this->load->model('permissoes_model');
        $this->load->model('funcionarios_model');
        $this->data['permissoes'] = $this->permissoes_model->getActive('permissoes','permissoes.idPermissao,permissoes.nome');   
        $this->data['funcionarios'] = $this->funcionarios_model->get('funcionario','*');   
		$this->data['view'] = 'usuarios/adicionarUsuario';
        $this->load->view('tema/topo',$this->data);
   
       
    }	
    
    function editar(){  
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }

        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
        $this->form_validation->set_rules('id_funcionario', 'Funcionario', 'trim|required|xss_clean');
       // $this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_situacao', 'Situação', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        { 

            if ($this->input->post('id_usuario') == 1 && $this->input->post('id_situacao') == 0)
            {
                $this->session->set_flashdata('error','O usuário super admin não pode ser desativado!');
                redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('id_usuario'));
            }

            $senha = $this->input->post('senha'); 
            if($senha != null){
				$this->load->library('encryption');   
            $senha = $this->encryption->encrypt($senha);

                $data = array(
                    'id_funcionario' => $this->input->post('id_funcionario'),
                    'senha' => $senha,
                    //'login' => $this->input->post('login'),
                    'status' => $this->input->post('id_situacao')
                );
            }  

            else{

                $data = array(
                    'id_funcionario' => $this->input->post('id_funcionario'),
                    //'login' => $this->input->post('login'),
                    'status' => $this->input->post('id_situacao')
                );

            }  

           
			if ($this->usuarios_model->edit('usuario',$data,'id_usuario',$this->input->post('id_usuario')) == TRUE)
			{
                $this->session->set_flashdata('success','Usuário editado com sucesso!');
				redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('id_usuario'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';

			}
		}

		$this->data['result'] = $this->usuarios_model->getById($this->uri->segment(3));

        $this->load->model('permissoes_model');
        $this->load->model('funcionarios_model');
        $this->data['permissoes'] = $this->permissoes_model->getActive('permissoes','permissoes.idPermissao,permissoes.nome');   
        $this->data['funcionarios'] = $this->funcionarios_model->get('funcionario','*'); 

		$this->data['view'] = 'usuarios/editarUsuario';
        $this->load->view('tema/topo',$this->data);
			
      
    }
	
    public function excluir(){
        if ($this->input->post('id_usuario') == 1 && $this->input->post('id_situacao') == 0) {
            $this->session->set_flashdata('error','O usuário super admin não pode ser Excluído!');
            redirect(base_url().'index.php/usuarios/gerenciar/');
        } else {
            $id =  $this->input->post('id');
            if ($id == null){
                $this->session->set_flashdata('error','Erro ao tentar excluir fornecedor.');            
                redirect(base_url().'index.php/usuarios/gerenciar/');
            }
            $this->usuarios_model->delete('usuario','id_usuario',$id);  

            $this->session->set_flashdata('success','Usuário excluido com sucesso!');            
            redirect(base_url().'index.php/usuarios/gerenciar/');        
        }
    }

    public function autoCompleteUsuario(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->usuarios_model->autoCompleteUsuario($q);
        }

    }

}

