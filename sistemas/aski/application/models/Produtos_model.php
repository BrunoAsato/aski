<?php
class Produtos_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields . ", c.nome as categoria");
        $this->db->from($table . ' p ');
        $this->db->join('categoria c', 'c.id_categoria = p.id_categoria', 'left');
        //$this->db->order_by('id_produto','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }        
		$this->db->order_by('p.nome, p.cor, p.tamanho');
		//echo "<pre>";
        print_r($this->db->get());
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id){
        $this->db->select('p.*, c.nome as categoria');
        $this->db->where('id_produto',$id);
        $this->db->join('categoria c', 'c.id_categoria = p.id_categoria', 'left');
        $this->db->limit(1);
        return $this->db->get('produto p ')->row();
    }
    
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
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
    
    function delete($table,$fieldID,$ID) {
        $this->db->where($fieldID,$ID);
        $acao = $this->db->delete($table);
        if ($this->db->error()['code'] == 1451) {
            return FALSE;
        }

        if($acao) {
            return TRUE;
        } else {
            return FALSE;
        }
        return FALSE;       
    }   
	
	function count($table){
		return $this->db->count_all($table);
	}

    public function autoCompleteProduto($q){
        $this->db->select('*');
        //$this->db->limit(5);
        $this->db->like('nome', $q);
        $query = $this->db->get('produto');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'] . ' ' .$row['cor']. ' '. $row['tamanho'] .' | Preço: R$ '.$row['preco_venda'].' | Estoque: '.$row['estoque'],'estoque'=>$row['estoque'],'id'=>$row['id_produto'],'preco'=>$row['preco_venda']);
            }
            echo json_encode($row_set);
        }
    }
}
