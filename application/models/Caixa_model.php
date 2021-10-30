<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caixa_model extends CI_Model {
    
	function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        //$this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        $this->db->order_by('data_abertura');
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }


    function getById($id) {
        $this->db->where('id_caixa',$id);
        $this->db->limit(1);
        return $this->db->get('caixa')->row();
    }

    function getMovimentos(){
        $this->db->where('id_caixa',$id);
        $this->db->limit(1);
        return $this->db->get('caixa_movimento')->result();
    }

    function lastCaixa() {
        $this->db->select_max('id_caixa');
        $this->db->limit(1);
        return $this->db->get('caixa')->row();        
    }
    
    function add($table,$data) {
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return $this->db->insert_id();
		}
		
		return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID) {
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
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
	
	function count($table) {
		return $this->db->count_all($table);
	}

    public function search($pesquisa, $de, $ate) {
        
        if($pesquisa != null){
            $this->db->like('caixa',$pesquisa);
        }

        if($de != null){
            $this->db->where('dt_cadastro >=' ,$de);
            $this->db->where('dt_cadastro <=', $ate);
        }
        $this->db->limit(10);
        return $this->db->get('caixa')->result();
    }

}

/* End of file arquivos_model.php */
/* Location: ./application/models/arquivos_model.php */