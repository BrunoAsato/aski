<?php
class Fornecedores_model extends CI_Model {

    
    function __construct() {
        parent::__construct();
    }

    
     function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array') {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('pessoa_juridica', 'pessoa_juridica.id_pessoa_juridica = fornecedor.id_pessoa_juridica');
        $this->db->join('pessoa p', 'p.id_pessoa = pessoa_juridica.id_pessoa');
        $this->db->join('telefone', 'telefone.id_pessoa = p.id_pessoa', 'left');
        //$this->db->order_by('id_fornecedor','desc');
        $this->db->limit($perpage, $start);
        if($where) {
            $this->db->where($where);
        }        
        $this->db->order_by('p.nome');
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id) {
        $this->db->select('*');
        $this->db->where('id_fornecedor', $id);
        $this->db->join('pessoa_juridica', 'pessoa_juridica.id_pessoa_juridica = fornecedor.id_pessoa_juridica');
        $this->db->join('pessoa', 'pessoa.id_pessoa = pessoa_juridica.id_pessoa');
        $this->db->join('telefone', 'telefone.id_pessoa = pessoa.id_pessoa', 'left');
        $this->db->limit(1);
        return $this->db->get('fornecedor')->row();
    }
    
    function add($table,$data) {
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
    
    function delete($table,$fieldID,$ID){
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
}