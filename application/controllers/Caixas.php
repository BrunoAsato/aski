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


        if($this->input->post('data_abertura')) {
            if ($this->form_validation->run('caixasAbertura') == false) {
                $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            } else {
                $data = array(
                    'data_abertura' => $this->input->post('data_abertura'),
                    'data_fechamento' => null,
                    'valor_abertura' => $this->input->post('valor_abertura'),
                    'valor_fechamento' => null
                );

                if ($this->caixa_model->add('caixa', $data) == TRUE) {
                    $this->session->set_flashdata('success','Caixa aberto com sucesso! Agora você já pode efetuar vendas em <a href="' . base_url('index.php/vendas/adicionar') . '"> Efetuar venda </a>');
                    redirect(base_url() . 'index.php/caixas/adicionar/');
                } else {
                    $this->data['custom_error'] = '<div class="form_error"><p>Erro ao tentar abrir caixa.</p></div>';
                }
            } 
        } else {
            if($this->input->post('valor_abertura') >= 0) {
                if ($this->form_validation->run('caixasFechamento') == false) {
                    $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
                } else {
                    $data = array(
                        'data_fechamento' => $this->input->post('data_fechamento'),
                        'valor_fechamento' => $this->input->post('valor_fechamento')
                    );
                    // Busca dados do ultimo caixa
                    $caixa = $this->caixa_model->lastCaixa();
                    // Considerando que o caixa está aberto (será tratado na interface), atualiza a data de fechamento
                    if ($this->caixa_model->edit('caixa', $data, 'id_caixa', $caixa->id_caixa) == TRUE) {
                        $this->session->set_flashdata('success','Caixa fechado com sucesso!');
                        redirect(base_url() . 'index.php/caixas/adicionar/');
                    } else {
                        $this->data['custom_error'] = '<div class="form_error"><p>Erro ao tentar fechar caixa.</p></div>';
                    }
                }  
            }
        }       

        $caixa = $this->caixa_model->lastCaixa();
        $caixa = $this->caixa_model->getById($caixa->id_caixa);

        $this->data['caixa'] = $caixa;
        // Id do status de caixa, 0 = fechado; 1 = aberto; 2 = aguardando conclusão (quando o caixa foi aberto em uma data anterior a data atul)
        $this->data['id_status_caixa'] = $this->status_caixa();
        // Mensagem de status do caixa
        $this->data['status_caixa'] = $this->mensagem_status_caixa($this->data['id_status_caixa']);

        $this->data['view'] = 'caixas/adicionarCaixa';
        //die(print_r($this->data));
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

