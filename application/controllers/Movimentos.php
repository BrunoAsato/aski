<?php

class Movimentos extends CI_Controller {
    
    
    function __construct() {
        parent::__construct();
        if((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))){
            redirect('aski/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('movimento_model', '', TRUE);
        $this->load->model('fornecedores_model', '', TRUE);
        $this->load->model('produtos_model', '', TRUE);
        $this->data['menuMovimentos'] = 'Movimentos';
    }

    function index(){
       $this->gerenciar();
    }

    function gerenciar() {

        $this->load->library('table');
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/movimentos/gerenciar/';
        $config['total_rows'] = $this->movimento_model->count('movimento');
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
/*
        if($this->uri->segment(3) != null) {
            if($this->uri->segment(4) != null && ($this->uri->segment(5) != null)) {
                $diaInicio = substr($this->uri->segment(4), 0, 2);
                $mesInicio = substr($this->uri->segment(4), 2, 2);
                $anoInicio = substr($this->uri->segment(4), 4, 4);
                $diaFim = substr($this->uri->segment(5), 0, 2);
                $mesFim = substr($this->uri->segment(5), 2, 2);
                $anoFim = substr($this->uri->segment(5), 4, 4);
                $inicio = $anoInicio . "-" . $mesInicio . "-" . $diaInicio;
                $fim = $anoFim . "-" . $mesFim . "-" . $diaFim;
                $where = " datahora between '" . $inicio . "' and '" . $fim . "'";
            }
        }
        */
        if(!isset($where)) {
            $where = null;
        }

        //$this->data['results'] = $this->movimento_model->get_last_mov('movimento','m.id_movimento,m.id_produto,m.tipo_movimentacao,m.quantidade_estoque,m.quantidade,p.nome as nm_produto, p.material, p.cor, p.tamanho, m.descricao, datahora, id_venda_produto', $where, $config['per_page'], $this->uri->segment(3));
        $this->data['results'] = $this->movimento_model->get_last_mov('movimento','m.id_movimento,m.id_produto,m.tipo_movimentacao,m.quantidade_estoque,m.quantidade,p.nome as nm_produto, p.material, p.cor, p.tamanho, m.descricao, datahora, id_venda_produto');
       //die(print_r($this->data['results']));
        $this->data['view'] = 'movimentos/movimentos';
        $this->load->view('tema/topo',$this->data);
       
        
    }
    
    function adicionar() {
        if($this->uri->segment(3) || is_numeric($this->uri->segment(3))){
            $this->data['id_produto'] = $this->uri->segment(3);
        }
        $this->load->model('Produtos_model', '', TRUE);
           // die(print_r($this->input->post()));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_message('verifica_estoque', 'Produto com estoque insuficiente');
        if ($this->form_validation->run('movimentos') == false) {
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
            if ($this->movimento_model->add('movimento', $data) == TRUE) {
                $this->session->set_flashdata('success','Movimento feito com sucesso!');
                redirect(base_url() . 'index.php/movimentos/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        $this->data['produtos'] = $this->Produtos_model->get('produto','p.*');
        $this->data['view'] = 'movimentos/adicionarMovimento';
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
        if ($this->form_validation->run('movimentosEdit') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'datahora' => date('Y-m-d H:i:s'),
                'tipo_movimentacao' => $this->input->post('tipo_movimentacao'),
                'quantidade' => $this->input->post('quantidade'),
                'valor_unitario' => $this->input->post('valor_unitario'),
                'valor_total' => $this->input->post('quantidade') * $this->input->post('valor_unitario'),   
                'descricao' => $this->input->post('descricao')   

            );



            if ($this->movimento_model->edit('movimento', $data, 'id_movimento', $this->input->post('id_movimento')) == TRUE) {
                $this->session->set_flashdata('success','Movimento editado com sucesso!');
                redirect(base_url() . 'index.php/movimentos/editar/'.$this->input->post('id_movimento'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';
            }
        }

        $this->data['result'] = $this->movimento_model->getById($this->uri->segment(3));
        //die(print_r($this->data['result']));
        $this->data['view'] = 'movimentos/editarMovimento';
        $this->data['fornecedores'] = $this->fornecedores_model->get('fornecedor', 'id_fornecedor, nome');
        //die(print_r($this->data['fornecedores']));
        $this->load->view('tema/topo', $this->data);
     
    }

    function verifica_qtd_permitida() {
        $movimento = $this->movimento_model->getById($this->input->post('id_movimento'));
        if($movimento->tipo_movimentacao == 'S') {
            // Retorna a quantidade de produtos vendidos depois deste movimento
            $quantidade_vendida = $this->movimento_model->get_prox_vendas($this->input->post('id_movimento'));
            if(!$quantidade_vendida) {
                return true;
            }
            $quantidade_permitida = $movimento->quantidade_estoque - $movimento->quantidade - $quantidade_vendida->qtd;
            
            if($this->input->post('quantidade') > $quantidade_permitida) {
                $this->form_validation->set_message('verifica_qtd_permitida', 'Você não pode alterar a quantidade deste movimento em mais de ' . $quantidade_permitida . ' unidades. Vendas foram feitas.');
                return false;
            } else {
                return true;
            }
        } else {
            // Retorna a quantidade de produtos vendidos depois deste movimento
            $quantidade_vendida = $this->movimento_model->get_prox_vendas($this->input->post('id_movimento'));
            if(!$quantidade_vendida) {
                return true;
            }
            $quantidade_permitida = $movimento->quantidade_estoque + $movimento->quantidade - $quantidade_vendida->qtd;
            
            if($this->input->post('quantidade') > $quantidade_permitida) {
                $this->form_validation->set_message('verifica_qtd_permitida', 'Você não pode alterar a quantidade deste movimento com menos de ' . $quantidade_permitida * (-1) . ' unidades. Vendas foram feitas.');
                return false;
            } else {
                return true;
            }
        } 
    }


    function visualizar() {
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('aski');
        }
        
      
        $this->data['result'] = $this->movimento_model->getById($this->uri->segment(3));

        if($this->data['result'] == null){
            $this->session->set_flashdata('error','Movimento não encontrado.');
            redirect(base_url() . 'index.php/movimentos/editar/'.$this->input->post('id_movimento'));
        }

        $this->data['view'] = 'movimentos/visualizarMovimento';
        $this->load->view('tema/topo', $this->data);
     
    }
    
    function excluir() {

              
        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir movimento.');            
            redirect(base_url().'index.php/movimentos/gerenciar/');
        }
                
        $this->movimento_model->delete('movimento','id_movimento',$id);             
        

        $this->session->set_flashdata('success','Movimento excluida com sucesso!');            
        redirect(base_url().'index.php/movimentos/gerenciar/');
    }

    function verifica_estoque() {
        $produto = $this->produtos_model->getById($this->input->post('id_produto'));
        if (($this->input->post('tipo_movimentacao') == 'S') && ($produto->estoque < $this->input->post('quantidade'))) {
            return false;
        } else {
            return true;
        }
    }
}

