<?php
class Clientes_model extends CI_Model {

    
    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array') {
        
        $this->db->select('*, pessoa_fisica.cpf as documento, pessoa_juridica.cnpj as documento, p.id_pessoa');
        $this->db->from($table);
        $this->db->join('pessoa p ', 'p.id_pessoa = cliente.id_pessoa');
        $this->db->join('telefone', 'telefone.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('pessoa_fisica', 'pessoa_fisica.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('pessoa_juridica', 'pessoa_juridica.id_pessoa = p.id_pessoa', 'left');
        //$this->db->order_by('id_cliente','desc');
        //$this->db->limit($perpage,$start);
        if($where) {
            $this->db->where($where);
        }
        $this->db->order_by('p.nome');
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id) {
        $this->db->select('*, pessoa_fisica.cpf as documento, pessoa_juridica.cnpj as documento, pessoa.id_pessoa');
        $this->db->where('id_cliente',$id);
        $this->db->join('pessoa', 'pessoa.id_pessoa = cliente.id_pessoa');
        $this->db->join('telefone', 'telefone.id_pessoa = pessoa.id_pessoa', 'left');
        $this->db->join('pessoa_fisica', 'pessoa_fisica.id_pessoa = pessoa.id_pessoa', 'left');
        $this->db->join('pessoa_juridica', 'pessoa_juridica.id_pessoa = pessoa.id_pessoa', 'left');
        $this->db->limit(1);
        //echo "<pre>";
        //die(print_r($this->db->get('cliente')->row()));
        return $this->db->get('cliente')->row();
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
    

    public function autoCompleteCliente($q) {

        $this->db->select('p.nome, t.ddd, t.telefone, c.id_cliente ');
        $this->db->from('pessoa p');
        $this->db->join('telefone t', 't.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('cliente c', 'c.id_pessoa = p.id_pessoa');
        $this->db->join('pessoa_fisica pf', 'pf.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('pessoa_juridica pj', 'pj.id_pessoa = p.id_pessoa', 'left');
        $this->db->limit(5);
        $this->db->like('p.nome', $q);
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array('label'=>$row['nome'].' | Telefone: '.$row['telefone'],'id'=>$row['id_cliente']);
            }
            echo json_encode($row_set);
            //echo "<pre>";
            //die(print_r($query->result()));
        }
        //echo "<pre>";
        //die(print_r($query->result()));
    }
}