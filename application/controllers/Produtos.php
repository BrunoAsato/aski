<?php

class Produtos extends CI_Controller {
    
    
    function __construct() {
        parent::__construct();
        if ((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))) {
            redirect('aski/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('produtos_model', '', TRUE);
        $this->data['menuProdutos'] = 'Produtos';
    }

    function index() {
	   $this->gerenciar();
    }

    function gerenciar() {
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar produtos.');
           redirect(base_url());
        }

        $this->load->library('table');
        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/produtos/gerenciar/';
        $config['total_rows'] = $this->produtos_model->count('produto');
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
		$this->data['results'] = $this->produtos_model->get('produto','p.*');
	    $this->data['view'] = 'produtos/produtos';
       	$this->load->view('tema/topo', $this->data);
    }
	
    function adicionar() {
        $this->load->library('funcoes');
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar produtos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $preco_compra = $this->input->post('preco_compra');
            $preco_compra = str_replace(",","", $preco_compra);
            $preco_venda = $this->input->post('preco_venda');
            $preco_venda = str_replace(",", "", $preco_venda);
            $data = array(
                'nome' => $this->funcoes->primeirasMaiusculas(set_value('nome')),
                'id_categoria' => set_value('id_categoria'),
                'codigo_barras' => set_value('codigo_barras'),
                'estoque' => 0,
                'estoque_minimo' => set_value('estoque_minimo'),
                'cor' => $this->funcoes->primeirasMaiusculas(set_value('cor')),
                'tamanho' => set_value('tamanho'),
                'material' => $this->funcoes->primeirasMaiusculas(set_value('material')),
                'descricao' => set_value('descricao'),
                'preco_compra' => $preco_compra,
                'preco_venda' => $preco_venda
            );

            //$id_produto = $this->produtos_model->add('produto', $data);

            /*$movimento = array(
                'datahora' => date('Y-m-d H:i:s'),                
                'tipo_movimentacao' => 'E',
                'quantidade_estoque' => 0,
                'id_produto' => $id_produto,
                'quantidade' => set_value('estoque'),
                'descricao' => 'Movimentação manual - Cadastro'
            );

            $this->load->model('movimento_model', '', TRUE);
*/
            if ($this->produtos_model->add('produto', $data) == TRUE) {
                $this->session->set_flashdata('success','Produto adicionado com sucesso!');
                redirect(base_url() . 'index.php/produtos/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        $this->load->model('categoria_model', '', TRUE);
        $this->data['categorias'] = $this->categoria_model->get('categoria', 'id_categoria, nome');
        $this->data['view'] = 'produtos/adicionarProduto';
        $this->load->view('tema/topo', $this->data);
     
    }


    function editar() {
        $this->load->library('funcoes');
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para editar produtos.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $preco_compra = $this->input->post('preco_compra');
            $preco_compra = str_replace(",","", $preco_compra);
            $preco_venda = $this->input->post('preco_venda');
            $preco_venda = str_replace(",", "", $preco_venda);
            $data = array(
                'nome' => $this->funcoes->primeirasMaiusculas(set_value('nome')),
                'id_categoria' => set_value('id_categoria'),
                'codigo_barras' => set_value('codigo_barras'),
                'estoque' => set_value('estoque'),
                'estoque_minimo' => set_value('estoque_minimo'),
                'cor' => $this->funcoes->primeirasMaiusculas(set_value('cor')),
                'tamanho' => set_value('tamanho'),
                'material' => $this->funcoes->primeirasMaiusculas(set_value('material')),
                'descricao' => set_value('descricao'),
                'preco_compra' => $preco_compra,
                'preco_venda' => $preco_venda
            );

            if ($this->produtos_model->edit('produto', $data, 'id_produto', $this->input->post('id_produto')) == TRUE) {
                $this->session->set_flashdata('success','Produto editado com sucesso!');
                redirect(base_url() . 'index.php/produtos/editar/'.$this->input->post('id_produto'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';
            }
        }

        $this->data['result'] = $this->produtos_model->getById($this->uri->segment(3));
        //echo "<pre>";
        //die(print_r($this->data['result']));
        $this->load->model('categoria_model', '', TRUE);
        $this->data['categorias'] = $this->categoria_model->get('categoria', 'id_categoria, nome');
        $this->data['view'] = 'produtos/editarProduto';
        $this->load->view('tema/topo', $this->data);
     
    }


    function visualizar() {
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar produtos.');
           redirect(base_url());
        }

        $this->data['result'] = $this->produtos_model->getById($this->uri->segment(3));

        if($this->data['result'] == null){
            $this->session->set_flashdata('error','Produto não encontrado.');
            redirect(base_url() . 'index.php/produtos/editar/'.$this->input->post('id_produto'));
        }

        $this->data['view'] = 'produtos/visualizarProduto';
        $this->load->view('tema/topo', $this->data);
     
    }
	
    function excluir() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir produtos.');
           redirect(base_url());
        }

        $id =  $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error','Erro ao tentar excluir produto.');            
            redirect(base_url().'index.php/produtos/gerendciar/');
        }

        try{
            $acao = $this->produtos_model->delete('produto','id_produto',$id);
        }
        catch (SqlException $ex) {
            SqlException::throwDeleteException($ex);
        }
        if($acao){
            $this->session->set_flashdata('success', 'Produto excluido com sucesso!');            
            redirect(base_url().'index.php/produtos/gerenciar/');
        } else {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir produto, verifique se o mesmo não tem venda associada a ele.');            
            redirect(base_url().'index.php/produtos/gerenciar/');
        }             
        

        //$this->session->set_flashdata('success','Produto excluido com sucesso!');            
        //redirect(base_url().'index.php/produtos/gerenciar/');
    }

    public function autoCompleteProduto(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']); //converte a string para minuscula
            $this->produtos_model->autoCompleteProduto($q);
        }

    }
}

