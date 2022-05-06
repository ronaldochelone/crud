


<h2 style="color:#393c3f">  CRUD - PHP, MYSQL sem Frameworks com comunicação via API. </h2>
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
<h3 style="color:#393c3f"> Cadastro de usuário </h3>
- O cadastro será um formulário HTML estilizado com [bootstrap](https://getbootstrap.com/) 
onde iremos enviar -lo a  API

<h3 style="color:#393c3f"> Comunicação </h3>
- A API é implementada utilizando das especificações REST e aceita os formatos **json** e **multipart/form-data**

<h3 style="color:#393c3f"> Comunicação Externa </h3>
 - O formulário de cadastro irá se comunicar com a API do [ViaCEP](https://viacep.com.br/) para obtenção dos dados de endereço, através de uma consulta pelo CEP.


<h3 style="color:#393c3f"> Banco de dados </h3>

<h4 style="color:#393c3f"> Tabela - User </h4>

- name       ***( nome )***
- email      ***( e-mail )***
- birthday   ***( Data de Aniversário )***
- phone      ***( Telefone )***
- created_at  ***( Data do cadastro )***
- updated_at  ***( Data da atualização )***

<h4 style="color:#393c3f"> Tabela - Addresses</h4>

- street      ***( rua )***
- number      ***( número )***
- district    ***( Bairro )***
- complement  ***( Complemento )***
- states      ***( estado )***
- city        ***( Cidade )***
- post_code   ***( CEP )***
- country`    ***( País )***
- created_at  ***( Data do cadastro )***
- updated_at  ***( Data da atualização )***

<h3 style="color:#393c3f">Features</h3>

<h4 style="color:#393c3f"> API</h4>

 [x] Desenvolvolver o Método GET
 [] Desenvolvolver o Método POST
 [] Desenvolvolver o Método PUT
 [] Desenvolvolver o Método DELETE

 [] Criar autenticação via Token
 [] Criar Testes 

 <h4 style="color:#393c3f">Formulário</h4>

 [] Criação do Formulário o Método GET
 [] Criação do alerta da mensagem de retorno
 [] Criação listagem de usuários cadastrados
 [] Criação do botão cadastrar
 [] Criação do botão atualizar
 [] Criação do botão excluir
