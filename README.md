# 📋 Sistema de Gerenciamento de Ordens de Serviço

Um sistema web simples em **PHP** com **MySQL**, **Bootstrap** e **jQuery** para o gerenciamento de **Clientes**, **Produtos** e **Ordens de Serviço**.

## 🚀 Funcionalidades

- ✅ **Cadastro, Edição e Exclusão de Clientes**
- ✅ **Cadastro, Edição e Exclusão de Produtos**
- ✅ **Cadastro, Edição e Exclusão de Ordens de Serviço**
- ✅ **Validação básica de formulários no lado do cliente**
- ✅ **Interface amigável com Bootstrap 5**

## 🛠️ Tecnologias Utilizadas

- **PHP** – Back-end
- **MySQL** – Banco de Dados
- **Bootstrap 5** – Estilo e Layout
- **jQuery** – Manipulação de eventos e DOM
- **PDO** – Conexão com o Banco de Dados (**segura contra SQL Injection**)

## 📂 Passos para Executar o Projeto

### 1️⃣ Crie o Banco de Dados

- Execute o script SQL localizado em:

sql/database.sql


### 2️⃣ Configure a Conexão com o Banco de Dados

- No arquivo:

config/db.php


- Insira suas credenciais do banco de dados:

```php
<?php
$host = 'localhost';
$dbname = 'ordem_servico_db';
$username = 'SEU_USUARIO';
$password = 'SUA_SENHA';

```

### 3️⃣ Inicie o Servidor Local

- Navegue até a pasta public/ do projeto e execute o comando:

php -S localhost:8000

### 4️⃣ Acesse o Sistema

- Abra o navegador e acesse:

http://localhost:8000

