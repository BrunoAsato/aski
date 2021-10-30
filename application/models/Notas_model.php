<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notas_model extends CI_Model {
    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array') {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        if($where) {
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id) {
        $this->db->select('*');
        $this->db->from('nota n');
        $this->db->where('id_nota',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
        //echo "<pre>";
        //die(print_r($this->db));
    }


    // Retorna a quantidade de produtos vendidos depois deste movimento
    function get_prox_vendas($id) {
        // Retorna o id do produto relativo ao movimento atual
        $this->db->select('id_produto');
        $this->db->from('movimento m');
        $this->db->where('id_movimento',$id);
        $this->db->limit(1);
        $produto = $this->db->get()->row();
        // Limpa a classe db;
        $this->db->flush_cache();

        // Retorna a quantidade de produtos vendidos depois deste movimento
        $this->db->select('sum(m.quantidade) as qtd');
        $this->db->from('movimento m');
        $this->db->where('id_movimento > ',$id, false);
        $this->db->where('id_produto',$produto->id_produto);
        //echo "<pre>";
        $quantidade = $this->db->get()->row();
        //echo "<pre>";
        //die(print_r($quantidade->qtd));
        if($quantidade->qtd) {
            return $quantidade;
        } else {
            return false;
        }        
    }
    
    function add($table,$data) {
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1') {
            return $this->db->insert_id();
        }
        
        return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID) {
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
    
    function count($table) {
        return $this->db->count_all($table);
    }

    public function search($pesquisa, $de, $ate) {        
        if($pesquisa != null){
            $this->db->like('movimento',$pesquisa);
        }

        if($de != null){
            $this->db->where('dt_cadastro >=' ,$de);
            $this->db->where('dt_cadastro <=', $ate);
        }
        $this->db->limit(10);
        return $this->db->get('movimento')->result();
    }

}

/* End of file arquivos_model.php */
/* Location: ./application/models/arquivos_model.php */