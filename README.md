
## CRUD - PHP, MYSQL sem Frameworks com comunicação via API.
- O objetivo deste projeto é demostrar a criação de CRUD simples em PHP e Mysql sem a necessidade de frameworks.

 - Iremos desenvolver uma  API REST para comunicação de um formulário. 

 - A API irá ter um único endpoint e todos os processos do CRUD serão implementados utilizando os verbos HTTP.
```url

[GET] https://localhost:8000/user/{id} // Caso não seja informado o ID, deverá listar todos usuários cadastros
[POST] https://localhost:8000/user
[PUT] https://localhost:8000/user
[PUT] https://localhost:8000/user/:id
[DELETE] https://localhost:8000/user/:id
```
### Cadastro de usuário
- O cadastro será um formulário HTML estilizado com **bootstrap**
onde iremos enviar -lo a  API

### Comunicação
- A API é implementada utilizando das especificações REST e aceita os formatos **json** e **multipart/form-data**

### Externo
 - O formulário de cadastro irá se comunicar com a API do **ViaCEP** para obtenção dos dados de endereço, através de uma consulta pelo CEP.

### Banco de dados

#### Tabela - User
- name       ***( nome )***
- email      ***( e-mail )***
- birthday   ***( Data de Aniversário )***
- phone      ***( Telefone )***
- created_at  ***( Data do cadastro )***
- updated_at  ***( Data da atualização )***

#### Tabela - Addresses

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

### Features
#####API
 [x] Desenvolvolver o Método GET
 [] Desenvolvolver o Método POST
 [] Desenvolvolver o Método PUT
 [] Desenvolvolver o Método DELETE

 [] Criar autenticação via Token
 [] Criar Testes 
#####Formulário
 [] Criação do Formulário o Método GET
 [] Criação do alerta da mensagem de retorno
 [] Criação listagem de usuários cadastrados
 [] Criação do botão cadastrar
 [] Criação do botão atualizar
 [] Criação do botão excluir
