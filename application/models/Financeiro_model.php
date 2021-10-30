<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Financeiro_model extends CI_Model {

    
	function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('data_vencimento', 'asc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }


    function getById($id){
        $this->db->where('id_lancamento',$id);
        $this->db->limit(1);
        return $this->db->get('lancamentos')->row();
    }

    function getLancByVenda($id) {
        $this->db->where('id_venda',$id);
        return $this->db->get('lancamentos')->result();

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

    function baixarLancamento($table,$fieldID,$ID, $dt_baixa = null){
        $venda = $this->getById($ID);
        $id_venda = $venda->id_venda;

        $this->db->where('id_venda',$id_venda);
        $this->db->limit(1);
        $venda = $this->db->get('venda')->row();
        $data_venda = $venda->data_venda;

        $this->db->flush_cache();


        if($dt_baixa) {
            $data = array(  'baixado' => '1',
                        'data_pagamento' => $dt_baixa
                    );
            // Retira a hora do datetime da venda e compara à data de pagamento
            $data_venda = explode(' ', $data_venda);
            $data_venda = $data_venda[0];
            if($data['data_pagamento'] < $data_venda) {
                die($data_venda . ' - ' . $data['data_pagamento'] );
                return false;
            }

        } else {
            $data = array(  'baixado' => '1',
                        'data_pagamento' => date('Y-m-d H:i:s')
                    );
        }

        $this->db->where($fieldID, $ID);
        $acao = $this->db->update($table, $data);

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

