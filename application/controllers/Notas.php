<?php

class Notas extends CI_Controller {
    
    
    function __construct() {
        parent::__construct();
        if((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))){
            redirect('aski/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('notas_model', '', TRUE);
        $this->load->model('fornecedores_model', '', TRUE);
        $this->load->model('produtos_model', '', TRUE);
        $this->data['menuNota'] = 'Notas';
    }

    function index(){
       $this->gerenciar();
    }

    function gerenciar() {

        $this->load->library('table');
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/notas/gerenciar/';
        $config['total_rows'] = $this->notas_model->count('notas');
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
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);   
         
        if($this->input->get('data_inicio') != null) {
            $data_inicio = $this->input->get('data_inicio');
            $data_inicio = implode('-', array_reverse(explode('/', $data_inicio)));
            if($this->input->get('data_fim') != null) {
                $data_fim = $this->input->get('data_fim');
                $data_fim = implode('-', array_reverse(explode('/', $data_fim)));
                $where = " datahora between '" . $data_inicio . "' and '" . $data_fim . "' ";
            } else {
                $where = " datahora > '" . $data_inicio . "'";
            }
        } elseif ($this->input->get('data_fim')) {
            $data_fim = $this->input->get('data_fim');
            $where = " datahora < '" . $data_fim . "'";
        }   
        if(!isset($where)) {
            $where = null;
        }
        $this->data['results'] = $this->notas_model->get('notas','*');
        //die(print_r($this->data['results']));


        $this->data['view'] = 'notas/notas';
        $this->load->view('tema/topo',$this->data);
       
        
    }
    
    function adicionar() {
        $this->load->model('notas_model', '', TRUE);
           // die(print_r($this->input->post()));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_message('verifica_estoque', 'Produto com estoque insuficiente');
        if ($this->form_validation->run('notas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $id_produto = $this->input->post('id_produto');
            $produto = $this->Produtos_model->getById($id_produto);
            $estoque_produto = $produto->estoque;
            $valor_total = $this->input->post('quantidade') * $this->input->post('valor_unitario'); 

            $data = array(
                'datahora' => date('Y-m-d H:i:s'),                
                'tipo_movimentacao' => $this->input->post('tipo_movimentacao'),
                'quantidade_estoque' => $estoque_produto,
                'id_produto' => $id_produto,
                'quantidade' => $this->input->post('quantidade'),
                'valor_unitario' => $this->input->post('valor_unitario'),
                'valor_total' => $valor_total,
                'descricao' => $this->input->post('descricao')
            );
            if ($this->notas_model->add('notas', $data) == TRUE) {
                $this->session->set_flashdata('success','Movimento feito com sucesso!');
                redirect(base_url() . 'index.php/notas/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        $this->data['produtos'] = $this->Produtos_model->get('produto','p.*');
        $this->data['view'] = 'notas/adicionarNotas';
        $this->data['fornecedores'] = $this->fornecedores_model->get('fornecedor', 'id_fornecedor, nome');
        $this->load->view('tema/topo', $this->data);
    }

    function importar($numero_nf, $serie) {
        $filename = 'file.xml';
        $DOMDocument = new DOMDocument( '1.0', 'UTF-8' );
        $DOMDocument->preserveWhiteSpace = false;
        $DOMDocument->load( $filename );
        $products = $DOMDocument->getElementsByTagName( 'prod' );

        foreach( $products as $product ) {
            printf( '<strong>Produto:</strong> %s<br/>
                     <strong>Valor:</strong> %01.2f<br/>', 
                    $product->getElementsByTagName( 'xProd' )->item( 0 )->nodeValue,
                    $product->getElementsByTagName( 'vUnCom' )->item( 0 )->nodeValue
            );
        }


        $this->load->model('notas_model', '', TRUE);
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->form_validation->set_message('verifica_estoque', 'Produto com estoque insuficiente');

        if ($this->form_validation->run('notas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $id_produto = $this->input->post('id_produto');
            $produto = $this->Produtos_model->getById($id_produto);
            $estoque_produto = $produto->estoque;
            $valor_total = $this->input->post('quantidade') * $this->input->post('valor_unitario'); 

            $data = array(
                'datahora' => date('Y-m-d H:i:s'),                
                'tipo_movimentacao' => $this->input->post('tipo_movimentacao'),
                'quantidade_estoque' => $estoque_produto,
                'id_produto' => $id_produto,
                'quantidade' => $this->input->post('quantidade'),
                'valor_unitario' => $this->input->post('valor_unitario'),
                'valor_total' => $valor_total,
                'descricao' => $this->input->post('descricao')
            );
            if ($this->notas_model->add('notas', $data) == TRUE) {
                $this->session->set_flashdata('success','Movimento feito com sucesso!');
                redirect(base_url() . 'index.php/notas/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        $this->data['produtos'] = $this->Produtos_model->get('produto','p.*');
        $this->data['view'] = 'notas/adicionarNotas';
        $this->data['fornecedores'] = $this->fornecedores_model->get('fornecedor', 'id_fornecedor, nome');
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }

                
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        $this->form_validation->set_message('verifica_estoque', 'Produto com estoque insuficiente');
        if ($this->form_validation->run('notasEdit') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'numero_nf' => $this->input->post('numero_nf'),
                'serie' => $this->input->post('serie')

            );



            if ($this->movimento_model->edit('nota', $data, 'id_nota', $this->input->post('id_nota')) == TRUE) {
                $this->session->set_flashdata('success','Nota editada com sucesso!');
                redirect(base_url() . 'index.php/notas/editar/'.$this->input->post('id_nota'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';
            }
        }

        $this->data['result'] = $this->movimento_model->getById($this->uri->segment(3));
        //die(print_r($this->data['result']));
        $this->data['view'] = 'notas/editarNota';
        $this->data['fornecedores'] = $this->fornecedores_model->get('fornecedor', 'id_fornecedor, nome');
        //die(print_r($this->data['fornecedores']));
        $this->load->view('tema/topo', $this->data);
     
    }

    function visualizar() {
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }
        
      
        $this->data['result'] = $this->movimento_model->getById($this->uri->segment(3));

        if($this->data['result'] == null){
            $this->session->set_flashdata('error','Nota não encontrada.');
            redirect(base_url() . 'index.php/Notas/editar/'.$this->input->post('id_nota'));
        }

        $this->data['view'] = 'notas/visualizarNota';
        $this->load->view('tema/topo', $this->data);
     
    }
    
    function excluir() {

              
        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir nota.');            
            redirect(base_url().'index.php/notas_model/gerenciar/');
        }
                
        $this->movimento_model->delete('nota','id_nota',$id);             
        

        $this->session->set_flashdata('success','Nota excluída com sucesso!');            
        redirect(base_url().'index.php/notas/gerenciar/');
    }
}

