<?php
class Relatorios_model extends CI_Model {


    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
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
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }

    function count($table) {
        return $this->db->count_all($table);
    }
    
    public function clientesCustom($dataInicial = null,$dataFinal = null){
        
        if($dataInicial == null || $dataFinal == null){
            $dataInicial = date('Y-m-d');
            $dataFinal = date('Y-m-d');
        }
        //$query = "SELECT * FROM cliente WHERE data_cadastro BETWEEN ? AND ?";
        $this->db->select('*, pessoa_fisica.cpf as documento, pessoa_juridica.cnpj as documento, p.id_pessoa');
        $this->db->from('cliente');
        $this->db->join('pessoa p ', 'p.id_pessoa = cliente.id_pessoa');
        $this->db->join('telefone', 'telefone.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('pessoa_fisica', 'pessoa_fisica.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('pessoa_juridica', 'pessoa_juridica.id_pessoa = p.id_pessoa', 'left');
        $this->db->where('data_cadastro between "' . $dataInicial . '" and "' . $dataFinal . '"');
        $this->db->order_by('p.nome');
        
        return $this->db->get()->result();
        
        
        //return $this->db->query($query, array($dataInicial,$dataFinal))->result();
        //die(print_r($this->db->query($query, array($dataInicial,$dataFinal))->result()));

    }

    public function caixasCustom($dataInicial = null,$dataFinal = null) {
        if($dataInicial == null || $dataFinal == null) {
            $dataInicial = date('Y-m-d');
            $dataFinal = date('Y-m-d');
        }
        //$query = "SELECT * FROM cliente WHERE data_cadastro BETWEEN ? AND ?";
        $this->db->select('*');
        $this->db->from('caixa');
        $this->db->where("data_abertura between DATE_FORMAT('" . $dataInicial . "',  '%Y-%m-%d 00:00:00' ) and DATE_FORMAT('" . $dataFinal . "',  '%Y-%m-%d 23:59:59' ) ");
        $this->db->order_by('data_abertura');
        //echo "<pre>";
        //die(print_r($this->db));
        return $this->db->get()->result();
        
        //return $this->db->query($query, array($dataInicial,$dataFinal))->result();
        //die(print_r($this->db->query($query, array($dataInicial,$dataFinal))->result()));

    }

    public function LancamentosCaixas($dataInicial = null,$dataFinal = null) {
        
        if($dataInicial == null || $dataFinal == null) {
            $dataInicial = date('Y-m-d');
            $dataFinal = date('Y-m-d');
        }
        //$query = "SELECT * FROM cliente WHERE data_cadastro BETWEEN ? AND ?";
        $this->db->select('*');
        $this->db->from('lancamentos');
        $this->db->where("data_pagamento between DATE_FORMAT('" . $dataInicial . "',  '%Y-%m-%d 00:00:00' ) and DATE_FORMAT('" . $dataFinal . "',  '%Y-%m-%d 23:59:59' ) ");
        $this->db->order_by('data_pagamento');
        
        return $this->db->get()->result();
        
        //return $this->db->query($query, array($dataInicial,$dataFinal))->result();
        //die(print_r($this->db->query($query, array($dataInicial,$dataFinal))->result()));

    }

    public function clientesRapid(){
        $this->db->from('cliente c');
        $this->db->join('pessoa p', 'p.id_pessoa = c.id_pessoa');
        $this->db->join('telefone t', 't.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('pessoa_fisica pf', 'pf.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('pessoa_juridica pj', 'pj.id_pessoa = p.id_pessoa', 'left');
        $this->db->order_by('nome','asc');
        return $this->db->get()->result();
    }

    public function produtosRapid(){
        $this->db->order_by('nome','asc');
        return $this->db->get('produto')->result();
    }

    public function servicosRapid(){
        $this->db->order_by('nome','asc');
        return $this->db->get('servico')->result();
    }

    public function osRapid(){
        $this->db->select('os.*,clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes','clientes.idClientes = os.clientes_id');
        return $this->db->get()->result();
    }

    public function produtosRapidMin(){
        $this->db->order_by('nome','asc');
        $this->db->where('estoque < estoque_minimo');
        return $this->db->get('produto')->result();
    }

    public function produtosCustom($precoInicial = null,$precoFinal = null,$estoqueInicial = null,$estoqueFinal = null) {
        $wherePreco = "";
        $whereEstoque = "";
        if (isset($precoInicial) || isset($precoFinal)){
            if($precoInicial == null) {
                $precoInicial = 0;
            }
            if($precoFinal == null) {
                $precoFinal = 10000000;
            }
        }
        if (isset($estoqueInicial) || isset($estoqueFinal)){
            if($estoqueInicial == null) {
                $estoqueInicial = 0;
            }
            if($estoqueFinal == null) {
                $estoqueFinal = 10000000;
            }
        }

        if($precoInicial != null){
            $wherePreco = "AND preco_venda BETWEEN ".$this->db->escape($precoInicial)." AND ".$this->db->escape($precoFinal);
        }
        if($estoqueInicial != null){
            $whereEstoque = "AND estoque BETWEEN ".$this->db->escape($estoqueInicial)." AND ".$this->db->escape($estoqueFinal);
        }
        $query = "SELECT * FROM produto WHERE estoque >= 0 $wherePreco $whereEstoque";
        //die(print_r($query));
        return $this->db->query($query)->result();
    }

    public function servicosCustom($precoInicial = null,$precoFinal = null){
        $query = "SELECT * FROM servicos WHERE preco BETWEEN ? AND ?";
        return $this->db->query($query, array($precoInicial,$precoFinal))->result();
    }


    public function osCustom($dataInicial = null,$dataFinal = null,$cliente = null,$responsavel = null,$status = null){
        $whereData = "";
        $whereCliente = "";
        $whereResponsavel = "";
        $whereStatus = "";
        if($dataInicial != null){
            $whereData = "AND dataInicial BETWEEN ".$this->db->escape($dataInicial)." AND ".$this->db->escape($dataFinal);
        }
        if($cliente != null){
            $whereCliente = "AND clientes_id = ".$this->db->escape($cliente);
        }
        if($responsavel != null){
            $whereResponsavel = "AND usuarios_id = ".$this->db->escape($responsavel);
        }
        if($status != null){
            $whereStatus = "AND status = ".$this->db->escape($status);
        }
        $query = "SELECT os.*,clientes.nomeCliente FROM os LEFT JOIN clientes ON os.clientes_id = clientes.idClientes WHERE idOs != 0 $whereData $whereCliente $whereResponsavel $whereStatus";
        return $this->db->query($query)->result();
    }


    public function financeiroRapid(){
        
        $dataInicial = date('Y-m-01');
        $dataFinal = date("Y-m-t");
        $query = "SELECT * FROM lancamentos WHERE data_vencimento BETWEEN ? and ? ORDER BY tipo";
        return $this->db->query($query, array($dataInicial,$dataFinal))->result();
    }


    public function financeiroCustom($dataInicial, $dataFinal, $tipo = null, $situacao = null){
        
        $whereTipo = "";
        $whereSituacao = "";

        if($dataInicial == null){
            $dataInicial = '1900-01-01';
        }
        if($dataFinal == null){
            $dataFinal = '3000-01-01';  
        }

        if($tipo == 'receita'){
            $whereTipo = "AND tipo = 'receita'";
        }
        if($tipo == 'despesa'){
            $whereTipo = "AND tipo = 'despesa'";
        }
        if($situacao == 'pendente'){
            $whereSituacao = "AND baixado = 0 or baixado is null";
        }
        if($situacao == 'pago'){
            $whereSituacao = "AND baixado = 1";
        } 
        
        
        $query = "SELECT * FROM lancamentos WHERE data_vencimento BETWEEN ? and ? $whereTipo $whereSituacao";
        //die($query);
        return $this->db->query($query, array($dataInicial,$dataFinal))->result();
    }


    public function vendasRapid(){
        $this->db->select('v.*,p1.nome as nomeCliente, p2.nome');
        $this->db->from('venda v');
        $this->db->join('cliente c','c.id_cliente = v.id_cliente');
        $this->db->join('pessoa p1','p1.id_pessoa = c.id_pessoa');
        $this->db->join('usuario u', 'u.id_usuario = v.id_usuario');
        $this->db->join('funcionario f', 'f.id_funcionario = f.id_funcionario');
        $this->db->join('pessoa_fisica pf', 'pf.id_pessoa_fisica = f.id_pessoa_fisica');
        $this->db->join('pessoa p2','p2.id_pessoa = pf.id_pessoa');
        $this->db->order_by('data_venda', 'desc');
        return $this->db->get()->result();
    }


    public function vendasCustom($dataInicial = null,$dataFinal = null,$cliente = null,$responsavel = null){
        $whereData = "";
        $whereCliente = "";
        $whereResponsavel = "";
        $whereStatus = "";
        if (isset($dataInicial) || isset($dataFinal)){
            if($dataInicial == null) {
                $dataInicial = '1900-01-01';
            }
            if($dataFinal == null) {
                $dataFinal = '3000-01-01';
            }
        }
        if($dataInicial != null){
            $whereData = "AND data_venda BETWEEN ".$this->db->escape($dataInicial)." AND ".$this->db->escape($dataFinal);
        }
        if($cliente != null){
            $whereCliente = "AND v.id_cliente = ".$this->db->escape($cliente);
        }
        if($responsavel != null){
            $whereResponsavel = "AND v.id_usuario = ".$this->db->escape($responsavel);
        }

        $query = "SELECT v.*, p1.nome as nomeCliente, p2.nome 
                    FROM venda v 
                    LEFT JOIN cliente c
                        ON v.id_cliente = c.id_cliente 
                    INNER JOIN pessoa p1
                        ON p1.id_pessoa = c.id_pessoa
                    INNER JOIN usuario u 
                        ON v.id_usuario = u.id_usuario 
                    INNER JOIN funcionario f
                        ON f.id_funcionario = u.id_funcionario
                    INNER JOIN pessoa_fisica pf
                        ON pf.id_pessoa_fisica = f.id_pessoa_fisica
                    INNER JOIN pessoa p2
                        ON p2.id_pessoa = pf.id_pessoa
                    WHERE id_venda != 0 
                    $whereData 
                    $whereCliente 
                    $whereResponsavel
                    order by data_venda desc";
        return $this->db->query($query)->result();
    }
}