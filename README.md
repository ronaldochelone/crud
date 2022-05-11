


<h2 style="color:#393c3f">  CRUD - PHP, MYSQL sem Frameworks com comunicação via API. </h2>

<h3 style="color:#393c3f"> Objetivo </h3>

- O objetivo deste projeto é demostrar a criação de CRUD simples em PHP e Mysql sem a necessidade de frameworks.

 - Iremos desenvolver uma  API REST para comunicação de um formulário. 

 - A API irá ter um único endpoint e todos os processos do CRUD serão implementados utilizando os verbos HTTP.
```url

[GET] https://localhost:8000/user/{id} // Caso não seja informado o ID, serão listados todos usuários cadastros
[POST] https://localhost:8000/user
[PUT] https://localhost:8000/user
[PUT] https://localhost:8000/user/:id
[DELETE] https://localhost:8000/user/:id
```

<h3 style="color:#393c3f"> Requisitos </h3>

 - PHP 7+ 
 - MySQL
 - INSOMINIA OU POSTMAN

<h3 style="color:#393c3f"> Como executar </h3> 

 - Importar o arquivo crud.sql da pasta ***SQL*** com a ferramenta de gerenciamento de Banco de Dados de sua preferência.

-  Iniciar o PHP 
-  Iniciar o Mysql
-  Executa: ***composer update***
- Atualizar os dados no arquivo ***Config.php***
        
        const DBDRIVE = 'mysql';
        const DBHOST = 'localhost';
        const DBNAME = '';
        const DBUSER = '';
        const DBPASS = '';
        const HTTP_TOKEN = '';

Acessar o programa pela url do navegador: 

[http://localhost/user](http://localhost:8000/user)


<h3 style="color:#393c3f"> Comunicação </h3>

- A API é implementada utilizando das especificações REST e aceita os formatos **json** e **multipart/form-data**

<h3 style="color:#393c3f"> Comunicação Externa </h3>
 
 - O formulário de cadastro irá se comunicar com a API do [ViaCEP](https://viacep.com.br/) para obtenção dos dados de endereço, através de uma consulta pelo CEP.


<h3 style="color:#393c3f"> Banco de dados </h3>

<h4 style="color:#393c3f"> Tabela - User </h4>

- nome       ***( nome )***
- email      ***( email )***
- Data de Aniversário   ***( data_nascimento )***
- Cpf      ***( cpf )***
- Telefone      ***( telefone )***
- Cep      ***( cep )***
- Data do cadastro  ***( created_at )***
- Data da atualização  ***( updated_at )***

<h4 style="color:#393c3f"> Tabela - Address</h4>

- logradouro      ***( logradouro )***
- Bairro    ***( bairro )***
- estado      ***( estado )***
- cidade        ***( cidade )***
- Cep   ***( cep )***
- Data do cadastro  ***( created_at )***
- Data da atualização  ***( updated_at )***

<h3 style="color:#393c3f">Features</h3>

<h4 style="color:#393c3f"> API</h4>

 [x] Desenvolvolver o Método GET
 [x] Desenvolvolver o Método POST
 [x] Desenvolvolver o Método PUT
 [X] Desenvolvolver o Método DELETE
 [x] Criar autenticação via Token
 [] Criar Testes 

 <h4 style="color:#393c3f">Formulário</h4>

 [] Criação do Formulário o Método GET
 [] Criação do alerta da mensagem de retorno
 [] Criação listagem de usuários cadastrados
 [] Criação do botão cadastrar
 [] Criação do botão atualizar
 [] Criação do botão excluir
