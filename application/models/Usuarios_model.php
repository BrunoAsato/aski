<?php
class Usuarios_model extends CI_Model {


    function __construct() {
        parent::__construct();
    }


    function get($perpage=0,$start=0,$one=false) {
        $this->db->select('u.*, p.*, pf.*, t.*, permissoes.nome as permissao');        
        $this->db->from('usuario u');
        $this->db->join('funcionario f', 'f.id_funcionario = u.id_funcionario');
        $this->db->join('pessoa_fisica pf', 'pf.id_pessoa_fisica = f.id_pessoa_fisica');
        $this->db->join('pessoa p', 'p.id_pessoa = pf.id_pessoa');
        $this->db->join('telefone t', 't.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('permissoes', 'u.id_permissao = permissoes.idPermissao', 'left');
        $this->db->order_by('p.nome');
        $this->db->limit($perpage,$start);
  
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
 
     function getAllTipos() {
        $this->db->where('situacao',1);
        return $this->db->get('tiposUsuario')->result();
    }

    function getById($id){
        $this->db->where('id_usuario',$id);
        $this->db->limit(1);
        return $this->db->get('usuario')->row();
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

    public function autoCompleteUsuario($q) {

        $this->db->select('p.nome, t.ddd, t.telefone, u.id_usuario ');
        $this->db->from('pessoa p');
        $this->db->join('telefone t', 't.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('pessoa_fisica pf', 'pf.id_pessoa = p.id_pessoa');
        $this->db->join('funcionario f', 'f.id_pessoa_fisica = pf.id_pessoa_fisica');
        $this->db->join('usuario u', 'u.id_funcionario = f.id_funcionario');
        $this->db->limit(5);
        $this->db->like('p.nome', $q);
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array('label'=>$row['nome'].' | Telefone: '.$row['telefone'],'id'=>$row['id_usuario']);
            }
            echo json_encode($row_set);
            //echo "<pre>";
            //die(print_r($query->result()));
        }
        //echo "<pre>";
        //die(print_r($query->result()));
    }
}