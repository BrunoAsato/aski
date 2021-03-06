<?php
$config = array('clientesPF' => array(array(
                                	'field'=>'nome',
                                	'label'=>'nome',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'data_nascimento',
                                	'label'=>'Data de Nascimento',
                                	'rules'=>'required|trim|xss_clean|callback_validar_data_nascimento'
                                ),
								array(
                                	'field'=>'sexo',
                                	'label'=>'sexo',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'telefone[]',
                                	'label'=>'telefone',
                                	'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'email',
                                    'label'=>'email',
                                    'rules'=>'required|trim|valid_email|xss_clean|is_unique[pessoa.email]'
                                ),
								array(
                                	'field'=>'documento',
                                	'label'=>'CPF',
                                	'rules'=>'required|trim|xss_clean|callback_validar_cpf|is_unique[pessoa_fisica.cpf]'
                                ),
                                array(
                                    'field'=>'logradouro',
                                    'label'=>'logradouro',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'numero',
                                    'label'=>'numero',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'bairro',
                                    'label'=>'bairro',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cidade',
                                    'label'=>'cidade',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'estado',
                                    'label'=>'estado',
                                    'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'cep',
                                	'label'=>'cep',
                                	'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'clientesPJ' => array(array(
                                    'field'=>'nome',
                                    'label'=>'nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'sexo',
                                    'label'=>'Sexo',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'telefone',
                                    'label'=>'Telefone',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'email',
                                    'label'=>'E-mail',
                                    'rules'=>'required|trim|valid_email|xss_clean|is_unique[pessoa.email]'
                                ),
                                array(
                                    'field'=>'documento',
                                    'label'=>'CNPJ',
                                    'rules'=>'required|trim|xss_clean|callback_validar_cnpj|is_unique[pessoa_juridica.cnpj]'
                                ),
                                array(
                                    'field'=>'logradouro',
                                    'label'=>'Logradouro',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'numero',
                                    'label'=>'Numero',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'bairro',
                                    'label'=>'Bairro',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cidade',
                                    'label'=>'Cidade',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'estado',
                                    'label'=>'#stado',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'nome_fantasia',
                                    'label'=>'Nome Fantasia',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'razao_social',
                                    'label'=>'Raz??o Social',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cep',
                                    'label'=>'cep',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,'clientesEditPF' => array(array(
                                    'field'=>'nome',
                                    'label'=>'nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'data_nascimento',
                                    'label'=>'Data de Nascimento',
                                    'rules'=>'required|trim|xss_clean|callback_validar_data_nascimento'
                                ),
                                array(
                                    'field'=>'sexo',
                                    'label'=>'sexo',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'telefone',
                                    'label'=>'telefone',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'email',
                                    'label'=>'email',
                                    'rules'=>'required|trim|valid_email|xss_clean'
                                ),
                                array(
                                    'field'=>'documento',
                                    'label'=>'CPF/CNPJ',
                                    'rules'=>'required|trim|xss_clean|callback_validar_cpf'
                                ),
                                array(
                                    'field'=>'logradouro',
                                    'label'=>'logradouro',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'numero',
                                    'label'=>'numero',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'bairro',
                                    'label'=>'bairro',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cidade',
                                    'label'=>'cidade',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'estado',
                                    'label'=>'estado',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cep',
                                    'label'=>'cep',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'clientesEditPJ' => array(array(
                                    'field'=>'nome',
                                    'label'=>'nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'sexo',
                                    'label'=>'Sexo',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'telefone',
                                    'label'=>'Telefone',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'email',
                                    'label'=>'E-mail',
                                    'rules'=>'required|trim|valid_email|xss_clean'
                                ),
                                array(
                                    'field'=>'documento',
                                    'label'=>'CPF/CNPJ',
                                    'rules'=>'required|trim|xss_clean|callback_validar_cnpj'
                                ),
                                array(
                                    'field'=>'logradouro',
                                    'label'=>'Logradouro',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'numero',
                                    'label'=>'Numero',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'bairro',
                                    'label'=>'Bairro',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cidade',
                                    'label'=>'Cidade',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'estado',
                                    'label'=>'#stado',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'nome_fantasia',
                                    'label'=>'Nome Fantasia',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'razao_social',
                                    'label'=>'Raz??o Social',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cep',
                                    'label'=>'cep',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'servicos' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'descricao',
                                    'label'=>'',
                                    'rules'=>'trim|xss_clean'
                                ),
                                array(
                                    'field'=>'preco',
                                    'label'=>'',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'produtos' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'preco_compra',
                                    'label'=>'Pre??o de Compra',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'preco_venda',
                                    'label'=>'Pre??o de Venda',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'id_categoria',
                                    'label'=>'Categoria',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'movimentos' => array(array(
                                    'field'=>'quantidade',
                                    'label'=>'Quantidade',
                                    'rules'=>'required|trim|xss_clean|callback_verifica_estoque'
                                ),
                                array(
                                    'field'=>'tipo_movimentacao',
                                    'label'=>'Tipo movimento',
                                    'rules'=>'required'
                                ),
                                array(
                                    'field'=>'valor_unitario',
                                    'label'=>'Valor unitario',
                                    'rules'=>'required'
                                ),
                                array(
                                    'field'=>'descricao',
                                    'label'=>'Descri????o',
                                    'rules'=>'required'
                                ))
                ,
                'movimentosEdit' => array(array(
                                    'field'=>'quantidade',
                                    'label'=>'Quantidade',
                                    'rules'=>'required|trim|xss_clean|callback_verifica_estoque|callback_verifica_qtd_permitida'
                                ),
                                array(
                                    'field'=>'tipo_movimentacao',
                                    'label'=>'Tipo movimento',
                                    'rules'=>'required'
                                ),
                                array(
                                    'field'=>'valor_unitario',
                                    'label'=>'Valor unitario',
                                    'rules'=>'required'
                                ),
                                array(
                                    'field'=>'descricao',
                                    'label'=>'Descri????o',
                                    'rules'=>'required'
                                ))
                ,
                'categorias' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean|is_unique[categoria.nome]'
                                ))
                ,
                'categoriasEdit' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'usuarios' => array(array(
                                    'field'=>'id_funcionario',
                                    'label'=>'Funcion??rio',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'id_situacao',
                                    'label'=>'Situa????o',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'senha',
                                    'label'=>'Senha',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'id_permissao',
                                    'label'=>'Permiss??o',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,      
                'os' => array(array(
                                    'field'=>'dataInicial',
                                    'label'=>'DataInicial',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'dataFinal',
                                    'label'=>'DataFinal',
                                    'rules'=>'trim|xss_clean'
                                ),
                                array(
                                    'field'=>'garantia',
                                    'label'=>'Garantia',
                                    'rules'=>'trim|xss_clean'
                                ),
                                array(
                                    'field'=>'descricaoProduto',
                                    'label'=>'DescricaoProduto',
                                    'rules'=>'trim|xss_clean'
                                ),
                                array(
                                    'field'=>'defeito',
                                    'label'=>'Defeito',
                                    'rules'=>'trim|xss_clean'
                                ),
                                array(
                                    'field'=>'status',
                                    'label'=>'Status',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'observacoes',
                                    'label'=>'Observacoes',
                                    'rules'=>'trim|xss_clean'
                                ),
                                array(
                                    'field'=>'clientes_id',
                                    'label'=>'clientes',
                                    'rules'=>'trim|xss_clean|required'
                                ),
                                array(
                                    'field'=>'usuarios_id',
                                    'label'=>'usuarios_id',
                                    'rules'=>'trim|xss_clean|required'
                                ),
                                array(
                                    'field'=>'laudoTecnico',
                                    'label'=>'Laudo Tecnico',
                                    'rules'=>'trim|xss_clean'
                                ))

                  ,
				'tiposUsuario' => array(array(
                                	'field'=>'nomeTipo',
                                	'label'=>'NomeTipo',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'situacao',
                                	'label'=>'Situacao',
                                	'rules'=>'required|trim|xss_clean'
                                ))

                ,
                'receita' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'Descri????o',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'valor',
                                    'label'=>'Valor',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'vencimento',
                                    'label'=>'Data Vencimento',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                        
                                array(
                                    'field'=>'cliente',
                                    'label'=>'Cliente',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'tipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'despesa' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'Descri????o',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'valor',
                                    'label'=>'Valor',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'vencimento',
                                    'label'=>'Data Vencimento',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'fornecedor',
                                    'label'=>'Fornecedor',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'tipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'vendas' => array(array(
                                    'field' => 'data_venda',
                                    'label' => 'Data da Venda',
                                    'rules' => 'required|callback_validar_data_venda|trim'
                                ),
                                array(
                                    'field'=>'id_cliente',
                                    'label'=>'Cliente',
                                    'rules'=>'trim|xss_clean|required'
                                ),
                                array(
                                    'field'=>'id_usuario',
                                    'label'=>'Vendedor',
                                    'rules'=>'trim|xss_clean|required'
                                )),
                'funcionarios' => array(
                                array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'email',
                                    'label'=>'email',
                                    'rules'=>'required|trim|valid_email|xss_clean|is_unique[pessoa.email]'
                                ),array(
                                    'field'=>'data_nascimento',
                                    'label'=>'Data de data_nascimento',
                                    'rules'=>'trim|xss_clean|required|callback_validar_data_nascimento'
                                ),array(
                                    'field'=>'sexo',
                                    'label'=>'sexo',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'telefone',
                                    'label'=>'telefone',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cpf',
                                    'label'=>'cpf',
                                    'rules'=>'trim|xss_clean|required|callback_validar_cpf|is_unique[pessoa_fisica.cpf]'
                                ),array(
                                    'field'=>'cargo',
                                    'label'=>'cargo',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'data_contratacao',
                                    'label'=>'Data contratacao',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'logradouro',
                                    'label'=>'Logradouro',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'numero',
                                    'label'=>'N??mero',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'bairro',
                                    'label'=>'Bairro',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cidade',
                                    'label'=>'Cidade',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'estado',
                                    'label'=>'Estado',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cep',
                                    'label'=>'cep',
                                    'rules'=>'trim|xss_clean|required'
                                )),
                'funcionariosEdit' => array(
                                array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'email',
                                    'label'=>'email',
                                    'rules'=>'required|trim|valid_email|xss_clean'
                                ),array(
                                    'field'=>'data_nascimento',
                                    'label'=>'Data de data_nascimento',
                                    'rules'=>'trim|xss_clean|required|callback_validar_data_nascimento'
                                ),array(
                                    'field'=>'sexo',
                                    'label'=>'sexo',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'telefone',
                                    'label'=>'telefone',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cpf',
                                    'label'=>'cpf',
                                    'rules'=>'trim|xss_clean|required|callback_validar_cpf'
                                ),array(
                                    'field'=>'cargo',
                                    'label'=>'cargo',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'data_contratacao',
                                    'label'=>'Data contratacao',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'logradouro',
                                    'label'=>'Logradouro',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'numero',
                                    'label'=>'N??mero',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'bairro',
                                    'label'=>'Bairro',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cidade',
                                    'label'=>'Cidade',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'estado',
                                    'label'=>'Estado',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cep',
                                    'label'=>'cep',
                                    'rules'=>'trim|xss_clean|required'
                                )),
                'fornecedores' => array(
                                array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'telefone',
                                    'label'=>'telefone',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cnpj',
                                    'label'=>'CNPJ',
                                    'rules'=>'trim|xss_clean|required|callback_validar_cnpj|is_unique[pessoa_juridica.cnpj]'
                                ),array(
                                    'field'=>'descricao',
                                    'label'=>'Descricao',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'logradouro',
                                    'label'=>'Logradouro',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'numero',
                                    'label'=>'N??mero',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'bairro',
                                    'label'=>'Bairro',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cidade',
                                    'label'=>'Cidade',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'estado',
                                    'label'=>'Estado',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cep',
                                    'label'=>'cep',
                                    'rules'=>'trim|xss_clean|required'
                                )),
                'fornecedoresEdit' => array(
                                array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'telefone',
                                    'label'=>'telefone',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cnpj',
                                    'label'=>'CNPJ',
                                    'rules'=>'trim|xss_clean|required|callback_validar_cnpj'
                                ),array(
                                    'field'=>'descricao',
                                    'label'=>'Descricao',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'logradouro',
                                    'label'=>'Logradouro',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'numero',
                                    'label'=>'N??mero',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'bairro',
                                    'label'=>'Bairro',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cidade',
                                    'label'=>'Cidade',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'estado',
                                    'label'=>'Estado',
                                    'rules'=>'trim|xss_clean|required'
                                ),array(
                                    'field'=>'cep',
                                    'label'=>'cep',
                                    'rules'=>'trim|xss_clean|required'
                                )),
                'caixasAbertura' => array(array(
                                    'field' => 'valor_abertura',
                                    'label' => 'Valor de abertura',
                                    'rules' => 'required|trim'
                                )),
                'caixasFechamento' => array(array(
                                    'field' => 'valor_fechamento',
                                    'label' => 'Valor de fechamento',
                                    'rules' => 'required|trim'
                                ))
		);
			   