API - Vendas

API de Gerenciamento de Vendas e Estoque.

Autenticação de Usuario

Requisições referenta a Autenticação do Usuário na API

POST Cadastrar Credenciais
https://pedfarma.herokuapp.com/api/auth/credential
CADASTRO DE CREDENCIAS DO USUARIO PARA GERAR O TOKEN DE ACESSO.
Parâmetro	Obrigatoriedade	Tipo	Descrição
name	obrigatório	string	Nome do usuário
email	obrigatório	string	E-mail válido
password	obrigatório	string	Senha de no minimo 8 caracteres
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
BODY raw
{
    "name": "Willy Everton S. Nascimento",
    "email": "willy.everton.s.nascimento@gmail.com",
    "password": "janela123456"
}


Example Request
Success 
curl --location --request POST 'http://local.pedfarma.com/api/auth/credential' \
--data-raw '{
    "name": "Claudemir Rodrigues",
    "email": "claudemir@gmail.com",
    "password": "abcdefghi"
}'
Example Response
200 OK
Body Headers (11)
{
  "status": "success",
  "data": {
    "name": "Claudemir Rodrigues",
    "email": "claudemir@gmail.com",
    "updated_at": "2020-08-28T01:04:14.000000Z",
    "created_at": "2020-08-28T01:04:14.000000Z",
    "id": 6
  }
}
POST Gerar Token de Acesso
https://pedfarma.herokuapp.com/api/auth/token
GERA O BEARER TOKEN DE ACESSO E AUTENTICAÇÃO NA API.
Parâmetro	Obrigatoriedade	Tipo	Descrição
time	opcional	int	Tempo em minutos, que o Token permanecera válido
email	obrigatório	string	E-mail credenciado
password	obrigatório	string	Senha credenciada
Retorno	Tipo	Conteúdo
status	string	success ou error
message	string	Mensagem personalizada de Sucesso ou Erro
data	object	Objeto contendo os atributos: token* e type* caso sucesso ou null caso erro
*token	string	TOKEN de Acesso para utilizar na autenticação da API
*type	string	tipo do tokem, sempre será: "Bearer"
BODY raw
{
    "email": "willy.everton.s.nascimento@gmail.com",
    "password": "janela123456"
}


Example Request
Success 
curl --location --request POST 'http://local.pedfarma.com/api/auth/token' \
--data-raw '{
    "email": "everton@gmail.com",
    "password": "123456789",
    "time": 10080
}'
Example Response
200 OK
Body Headers (11)
{
  "status": "success",
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbC5wZWRmYXJtYS5jb21cL2FwaVwvYXV0aFwvdG9rZW4iLCJpYXQiOjE1OTg1NzY2ODEsImV4cCI6MTU5OTE4MTQ4MSwibmJmIjoxNTk4NTc2NjgxLCJqdGkiOiJJeWRpeGdzZkRkRlRmWmpOIiwic3ViIjo1LCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.VgXyYZra07-pJNIAoB_2aDqq2GA68vRienQo_Tz0Mik",
    "type": "bearer"
  }
}
PUT Alterar Credenciais 
https://pedfarma.herokuapp.com/api/auth/credential
ALETERA AS CREDENCIAIS DO USUÁRIO.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Parâmetro	Obrigatoriedade	Tipo	Descrição
name	opcional	string	Nome do usuário
email	opcional	string	E-mail válido
password	opcional	string	Senha de no minimo 8 caracteres
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY raw
{
    "name": "Willy Everton S. Nascimento",
    "email": "willy.everton.s.nascimento@gmail.com",
    "password": "#janelaFechada"
}


Example Request
Success 
curl --location --request PUT 'http://local.pedfarma.com/api/auth/credential' \
--data-raw '{
    "name": "Everton da Silva",
    "email": "everton.s@gmail.com",
    "password": "123456789"
}'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": {
    "id": 5,
    "name": "Everton da Silva",
    "email": "everton@gmail.com",
    "email_verified_at": null,
    "created_at": "2020-08-25T16:19:17.000000Z",
    "updated_at": "2020-08-25T16:19:17.000000Z"
  }
}
DEL Delete Credenciais 
https://pedfarma.herokuapp.com/api/auth/credential
DELETA AS CREDENCIAIS DO USUÁRIO LOGADO.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Success 
curl --location --request DELETE 'http://local.pedfarma.com/api/auth/credential'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": {
    "id": 5,
    "name": "Everton da Silva",
    "email": "everton.s@gmail.com",
    "email_verified_at": null,
    "created_at": "2020-08-25T16:19:17.000000Z",
    "updated_at": "2020-08-28T01:24:35.000000Z"
  }
}
POST Desativar Token 
https://pedfarma.herokuapp.com/api/auth/deactivate
INVALIDA O TOKEN DE ACESSO ENVIAO.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo a mensagem de sucesso ou erro
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Error 
curl --location --request POST 'http://local.pedfarma.com/api/auth/deactivate'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "message": [
      "Token de acesso inválido"
    ]
  }
}
Fornecedor

Requisições referente ao cadastro de Fornecedores

POST Cadastrar Fornecedor 
https://pedfarma.herokuapp.com/api/supplier
CADASTRA UM NOVO FORNECEDOR.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Parâmetro	Obrigatoriedade	Tipo	Descrição
nome_fantasia	obrigatório	string	Nome fFantasia da empresa Fornecedora
razao_social	opcional	string	Nome da Razão Social da empresa Fornecedora
email	obrigatório	string	E-mail válido
cnpj	obrigatório	string	CNPJ valido com mascara
telefone	obrigatório	string	Telefone valido com mascara
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY raw
{
    "nome_fantasia": "Volkswagen",
    "razao_social": "Volkswagen S.A.",
    "cnpj": "43.662.958/0001-50",
    "email": "atacado@vw.com",
    "telefone": "(14) 9845-3214"
}


Example Request
Success 
curl --location --request POST 'http://local.pedfarma.com/api/supplier' \
--data-raw '{
    "nome_fantasia": "Volkswagen",
    "razao_social": "Volkswagen S.A.",
    "cnpj": "43.662.958/0001-50",
    "email": "atacado@vw.com",
    "telefone": "(14) 9845-3214"
}'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": {
    "nome_fantasia": "Volkswagen",
    "razao_social": "Volkswagen S.A.",
    "email": "atacado@vw.com",
    "cnpj": "43.662.958/0001-50",
    "telefone": "(14) 9845-3214",
    "updated_at": "2020-08-28T00:53:01.000000Z",
    "created_at": "2020-08-28T00:53:01.000000Z",
    "id": 8
  }
}
GET Listar Fornecedores 
https://pedfarma.herokuapp.com/api/supplier
LISTAR FORNECEDORES CADASTRADOS.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	array	Array de objetos contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Success
curl --location --request GET 'http://local.pedfarma.com/api/supplier'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "nome_fantasia": "Ford",
      "razao_social": "Ford S.A.",
      "cnpj": "38.351.217/0001-19",
      "email": "atacado@ford.com",
      "telefone": "+55 (14) 3451-5365",
      "created_at": "2020-08-22T12:19:16.000000Z",
      "updated_at": "2020-08-22T12:19:20.000000Z"
    },
    {
      "id": 2,
GET Visualizar Fornecedor 
https://pedfarma.herokuapp.com/api/supplier/1
BUSCA O FORNECEDOR ESPECÍFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/supplier/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY formdata


Example Request
Error 
curl --location --request GET 'http://local.pedfarma.com/api/supplier/7'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": {
    "message": [
      "Nenhum registro encontrado"
    ]
  }
}
PUT Editar Fornecedor 
https://pedfarma.herokuapp.com/api/supplier/8
ALTERA O FORNECEDOR ESPECÍFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/supplier/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Parâmetro	Obrigatoriedade	Tipo	Descrição
nome_fantasia	opcional	string	Nome fantasia da empresa Fornecedora
razao_social	opcional	string	Nome da Razão Social da empresa Fornecedora
email	opcional	string	E-mail válido
cnpj	opcional	string	CNPJ valido com mascara
telefone	opcional	string	Telefone valido com mascara
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY raw
{
    "nome_fantasia": "Volkswagen",
    "razao_social": "Volkswagen LTDA",
    "email": "atacado@vw.com.br",
    "telefone": "(14) 9845-3214"
}


Example Request
Success 
curl --location --request PUT 'http://local.pedfarma.com/api/supplier/7' \
--data-raw '{
    "nome_fantasia": "Volkswagen",
    "razao_social": "Volkswagen LTDA",
    "cnpj": "43.662.958/0001-50",
    "email": "atacado@vw.com.br",
    "telefone": "(14) 9845-3214"
}'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "cnpj": [
      "O campo cnpj já está sendo utilizado."
    ]
  }
}
DEL Deletar Fornecedor 
https://pedfarma.herokuapp.com/api/supplier/8
EXCLUI O FORNECEDOR PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/supplier/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Error 
curl --location --request DELETE 'http://local.pedfarma.com/api/supplier/7'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "message": [
      "Nenhum registro encontrado"
    ]
  }
}
Cliente

Requisições referente ao cadastro de cliente

POST Cadastrar Cliente 
https://pedfarma.herokuapp.com/api/customer
CADASTRA UM NOVO CLIENTE.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Parâmetro	Obrigatoriedade	Tipo	Descrição
nome	obrigatório	string	Nome do Cliente
email	obrigatório	string	E-mail válido
cpf	obrigatório	string	CPF valido com mascara
telefone	obrigatório	string	Telefone valido com mascara
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY raw
{
    "nome": "Valeria Rodrigues Garcia",
    "cpf": "656.394.460-48",
    "email": "valeria@hotmail.com",
    "telefone": "(14) 9874-7894"
}


Example Request
Error 
curl --location --request POST 'http://local.pedfarma.com/api/customer' \
--data-raw '{
    "nome": "Willy",
    "cpf": "356.377.618-09",
    "email": "willy@hotmail.com",
    "telefone": "(14) 9887-8574"
}'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "email": [
      "O campo email já está sendo utilizado."
    ],
    "cpf": [
      "O campo cpf já está sendo utilizado."
    ]
  }
}
GET Listar Clientes 
https://pedfarma.herokuapp.com/api/customer
LISTA TODOS OS CLIENTES CADASTRADOS.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	array	Array de objetos contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Success
curl --location --request GET 'http://local.pedfarma.com/api/customer'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": [
    {
      "id": 2,
      "nome": "Daniele",
      "cpf": "019.668.490-01",
      "email": "daniele@hotmail.com",
      "telefone": "(11) 7894-1234",
      "created_at": "2020-08-25T01:13:24.000000Z",
      "updated_at": "2020-08-25T01:14:51.000000Z"
    },
    {
      "id": 3,
      "nome": "Willy",
GET Visualizar Cliente 
https://pedfarma.herokuapp.com/api/customer/4
BUSCA O CLIENTE ESPECÍFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/customer/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY formdata


Example Request
Error 
curl --location --request GET 'http://local.pedfarma.com/api/customer/1'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": {
    "message": [
      "Nenhum registro encontrado"
    ]
  }
}
PUT Editar Cliente 
https://pedfarma.herokuapp.com/api/customer/2
ALTERA O CLIENTE ESPECÍFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/customer/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Parâmetro	Obrigatoriedade	Tipo	Descrição
nome	opcional	string	Nome do Cliente
email	opcional	string	E-mail válido
cpf	opcional	string	CPF valido com mascara
telefone	opcional	string	Telefone valido com mascara
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY raw
{
    "telefone": "(11) 7894-1234"
}


Example Request
Error 
curl --location --request PUT 'http://local.pedfarma.com/api/customer/2' \
--data-raw '{
    "nome": "Daniele da Silva",
    "cpf": "019.668.490-01",
    "email": "daniele@hotmail.com",
    "telefone": "(11) 7894-1234"
}'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "email": [
      "O campo email já está sendo utilizado."
    ],
    "cpf": [
      "O campo cpf já está sendo utilizado."
    ]
  }
}
DEL Deletar Cliente 
https://pedfarma.herokuapp.com/api/customer/4
EXCLUI O CLIENTE ESPECIFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/customer/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Error 
curl --location --request DELETE 'http://local.pedfarma.com/api/customer/1'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "message": [
      "Nenhum registro encontrado"
    ]
  }
}
Produto

Requisições referente ao cadastro de produtos

POST Cadastrar Produto 
https://pedfarma.herokuapp.com/api/product
CADASTRA UM NOVO PRODUTO.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Parâmetro	Obrigatoriedade	Tipo	Descrição
nome	obrigatório	string	Nome do produto
descricao	opcional	string	Descrição do produto
quantidade	obrigatório	int	Quantidade do produto em estoque
valor	obrigatório	double	Valor de venda do Produto
custo	obrigatório	double	Preço de custo do Produto
fornecedor_id	obrigatório	int	foreing key, id do fornecedor do produto
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo todos os registros criados ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY raw
{
    "nome": "Fiesta Sedan",
    "descricao": "1.6 8v 2012",
    "quantidade": 4,
    "valor": 35123.99,
    "custo": 25321.65,
    "fornecedor_id": 1
}


Example Request
Error 
curl --location --request POST 'http://local.pedfarma.com/api/product' \
--data-raw '{
    "nome": "Fiesta Rocan Sedan",
    "descricao": "1.6 8v 2012",
    "quantidade": 4,
    "valor": 35123.99,
    "custo": 25321.65,
    "fornecedor_id": 1
}'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "nome": [
      "O campo nome já está sendo utilizado."
    ]
  }
}
GET Listar Produtos 
https://pedfarma.herokuapp.com/api/product
LISTA TODOS OS PROUTOS CADASTRADOS.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	array	Array de Objetos contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Success
curl --location --request GET 'http://local.pedfarma.com/api/product'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": [
    {
      "id": 3,
      "nome": "Fiesta Rocan Sedan",
      "descricao": "1.6 8v 2012",
      "quantidade": 5,
      "valor": 35123.99,
      "custo": 25321.65,
      "fornecedor_id": 1,
      "created_at": "2020-08-26T20:20:31.000000Z",
      "updated_at": "2020-08-27T21:22:03.000000Z"
    },
    {
GET Visualizar Produto 
https://pedfarma.herokuapp.com/api/product/2
BUSCA O PRODUTO ESPECÍFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/product/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY formdata


Example Request
Error 
curl --location --request GET 'http://local.pedfarma.com/api/product/2'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": {
    "message": [
      "Nenhum registro encontrado"
    ]
  }
}
PUT Editar Produto 
https://pedfarma.herokuapp.com/api/product/2
ALTERA O CLIENTE ESPECÍFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/product/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Parâmetro	Obrigatoriedade	Tipo	Descrição
nome	opcional	string	Nome do produto
descricao	opcional	string	Descrição do produto
quantidade	opcional	int	Quantidade do produto em estoque
valor	opcional	double	Valor de venda do Produto
custo	opcional	double	Preço de custo do Produto
fornecedor_id	opcional	int	foreing key, id do fornecedor do produto
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY raw
{
    "nome": "Fiesta Sedan",
    "descricao": "Rocan 1.6 8v 2012",
    "quantidade": 4,
    "valor": 35123.99,
    "custo": 25321.65,
    "fornecedor_id": 1
}


Example Request
Error 
curl --location --request PUT 'http://local.pedfarma.com/api/product/2' \
--data-raw '{
    "nome": "Fiesta Sedan",
    "descricao": "Rocan 1.6 8v 2012",
    "quantidade": 4,
    "valor": 35123.99,
    "custo": 25321.65,
    "fornecedor_id": 1
}'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "nome": [
      "O campo nome já está sendo utilizado."
    ]
  }
}
DEL Deletar Produto 
https://pedfarma.herokuapp.com/api/product/2
EXCLUI O PRODUTO ESPECIFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/product/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros ou os erros
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Error 
curl --location --request DELETE 'http://local.pedfarma.com/api/product/2'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "message": [
      "Nenhum registro encontrado"
    ]
  }
}
Venda

Requisições referente ao registro de vendas

POST Registrar Venda 
https://pedfarma.herokuapp.com/api/sale
REGISTA UM NOVA VENDA.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Parâmetro	Obrigatoriedade	Tipo	Descrição
forma_pagamento	obrigatório	string	Nome da Forma de Pagamento (Boleto, Cartão, etc...)
parcelas	obrigatório	int	Quantidade de parcelamento
acrescimo	opcional	double	Valor de acrescimo
desconto	opcional	double	Valor de desconto
total	obrigatório	double	Valor Total da venda
status	opcional	string	ativo ou cancelado
observacao	opcional	string	Descrição de alguma observação
produtos	obrigatório	array	array contendo um ou mais objetos com o produto_id e quantidade de produtos vendidos
cliente_id	obrigatório	int	id do cliente comprador
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros criados ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY raw
{
    "forma_pagamento": "Boleto",
    "parcelas": 24,
    "acrescimo": null,
    "desconto": 0,
    "total": 75321.65,
    "status": "ativo",
    "observacao": "",
    "cliente_id": 2,
    "produtos": [
        {
            "produto_id": 3,
            "quantidade": 4
        },
        {


Example Request
Error 
curl --location --request POST 'http://local.pedfarma.com/api/sale' \
--data-raw '{
    "forma_pagamento": "Boleto",
    "parcelas": 24,
    "acrescimo": null,
    "desconto": 0,
    "total": 75321.65,
    "status": "ativo",
    "observacao": "",
    "cliente_id": 2,
    "produtos": [
        {
            "produto_id": 3,
            "quantidade": 4
        },
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "message": [
      "produto_id não encontrado"
    ]
  }
}
GET Listar Vendas 
https://pedfarma.herokuapp.com/api/sale
LISTA TODOS OS VENDAS CADASTRADOS.
Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	array	Array de objetos contendo os registros ou contendo os erros
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Listar Vendas
curl --location --request GET 'https://pedfarma.herokuapp.com/api/sale'
GET Visualizar Venda 
https://pedfarma.herokuapp.com/api/sale/14
BUSCA A VENDA ESPECÍFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/sale/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os atributos do registro ou uma menssagem de erro
AUTHORIZATION

Bearer Token

Token<token>
BODY formdata


Example Request
Error 
curl --location --request GET 'http://local.pedfarma.com/api/sale/2'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": {
    "message": [
      "Nenhum registro encontrado"
    ]
  }
}
PUT Editar Venda 
https://pedfarma.herokuapp.com/api/sale/14
ALTERA UMA VENDA ESPECÍFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/sale/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Parâmetro	Obrigatoriedade	Tipo	Descrição
forma_pagamento	opcional	string	Nome da Forma de Pagamento (Boleto, Cartão, etc...)
parcelas	opcional	int	Quantidade de parcelamento
acrescimo	opcional	double	Valor de acrescimo
desconto	opcional	double	Valor de desconto
total	opcional	double	Valor Total da venda
status	opcional	string	ativo ou cancelado
observacao	opcional	string	Descrição de alguma observação
produtos	opcional	array	array contendo um ou mais objetos com o produto_id e quantidade de produtos vendidos
cliente_id	opcional	int	id do cliente comprador
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os registros criados ou os erros
AUTHORIZATION

Bearer Token

Token<token>
BODY raw
{
    "forma_pagamento": "Dinheiro",
    "parcelas": 1,
    "acrescimo": null,
    "desconto": 0,
    "total": 75321.65,
    "status": "ativo",
    "observacao": "",
    "cliente_id": 2,
    "produtos": [
        {
            "produto_id": 3,
            "quantidade": 4
        },
        {


Example Request
Error 
curl --location --request PUT 'http://local.pedfarma.com/api/sale/2' \
--data-raw '{
    "nome": "Fiesta Sedan",
    "descricao": "Rocan 1.6 8v 2012",
    "quantidade": 4,
    "valor": 35123.99,
    "custo": 25321.65,
    "fornecedor_id": 1
}'
Example Response
400 Bad Request
Body Headers (11)
{
  "status": "error",
  "data": {
    "message": [
      "Nenhum registro encontrado"
    ]
  }
}
DEL Deletar Venda 
https://pedfarma.herokuapp.com/api/sale/2
EXCLUI A VENDA ESPECIFICADO PELO ID PASSADO NA URL.
http://local.pedfarma.com/api/sale/{id}

Headers	Tipo	Conteúdo
Authorization	Bearer	Hash Access Token
Content-Type	application/json	Object Json {"param":"value"}
Retorno	Tipo	Conteúdo
status	string	success ou error
data	object	Objeto contendo os todos os atributos do registro excluido ou null caso occora algum erro
AUTHORIZATION

Bearer Token

Token<token>

Example Request
Success 
curl --location --request DELETE 'http://local.pedfarma.com/api/sale/2'
Example Response
200 OK
Body Headers (12)
{
  "status": "success",
  "data": {
    "id": 2,
    "forma_pagamento": "Cartão de Crédito - Master Card",
    "parcelas": 2,
    "acrescimo": 0,
    "desconto": 1000,
    "total": 75321.65,
    "status": "ativo",
    "observacao": "Desconto da Promoção do COVID-19",
    "cliente_id": 2,
    "created_at": "2020-08-26T20:21:45.000000Z",
    "updated_at": "2020-08-26T20:21:45.000000Z"
  }
