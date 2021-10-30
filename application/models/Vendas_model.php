<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendas_model extends CI_Model {

	function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields.', p.nome as nomeCliente, c.id_cliente, (select count(1) from venda_produto where id_venda = venda.id_venda) as qtd_produtos' );
		$this->db->from($table);
		if($perpage and $start) {
			$this->db->limit($perpage,$start);
		}
        $this->db->join('cliente c', 'c.id_cliente = '.$table.'.id_cliente');
        $this->db->join('pessoa p', 'p.id_pessoa = c.id_pessoa', 'left');
        $this->db->join('telefone t', 't.id_pessoa = p.id_pessoa', 'left');
		$this->db->order_by('data_venda','desc');
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id) {
        $this->db->select('v.*, c.*, u.*, p1.*, p1.nome as nomeCliente, p2.nome as nomeUsuario, t2.telefone as telefoneUsuario, p2.email as emailUsuario');
        $this->db->from('venda v');
        $this->db->join('cliente c','c.id_cliente = v.id_cliente');
        $this->db->join('pessoa p1','p1.id_pessoa = c.id_pessoa');
        $this->db->join('usuario u','u.id_usuario = v.id_usuario');
        $this->db->join('funcionario f','f.id_funcionario = u.id_funcionario');
        $this->db->join('pessoa_fisica pf','pf.id_pessoa_fisica = f.id_pessoa_fisica');
        $this->db->join('pessoa p2','p2.id_pessoa = pf.id_pessoa');
        $this->db->join('telefone t2','t2.id_pessoa = p2.id_pessoa', 'left');
        $this->db->where('v.id_venda',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function getProdutos($id = null) {
        $this->db->select('vp.*, p.*');
        $this->db->from('venda_produto vp');
        $this->db->join('produto p','p.id_produto = vp.id_produto');
        $this->db->where('id_venda',$id);
        return $this->db->get()->result();
    }

    
    function add($table,$data,$returnId = false){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
                        if($returnId == true){
                            return $this->db->insert_id($table);
                        }
			return $this->db->insert_id();
		}
		
		return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }   

    function count($table){
	return $this->db->count_all($table);
    }

    public function autoCompleteProduto($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('descricao', $q);
        $query = $this->db->get('produtos');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricao'].' | Preço: R$ '.$row['precoVenda'].' | Estoque: '.$row['estoque'],'estoque'=>$row['estoque'],'id'=>$row['idProdutos'],'preco'=>$row['precoVenda']);
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteCliente($q) {

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nomeCliente', $q);
        $query = $this->db->get('clientes');
        if($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array('label'=>$row['nomeCliente'].' | Telefone: '.$row['telefone'],'id'=>$row['idClientes']);
            }
            echo json_encode($row_set);
            //echo "<pre>";
            //die(print_r($query->result()));
        }
        //echo "<pre>";
        //die(print_r($query->result()));
    }

    public function autoCompleteUsuario($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nome', $q);
        $this->db->where('situacao',1);
        $query = $this->db->get('usuarios');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'].' | Telefone: '.$row['telefone'],'id'=>$row['idUsuarios']);
            }
            echo json_encode($row_set);
        }
    }



}

/* End of file vendas_model.php */
/* Location: ./application/models/vendas_model.php */
