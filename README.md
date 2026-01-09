
# 🏎️ Garagem API - Backend Documentation

Esta é uma API RESTful de nível profissional desenvolvida com o framework **CodeIgniter 4**. O sistema foi projetado para gerenciar operações de uma garagem ou estacionamento, integrando controle de usuários e gestão de frotas com segurança de ponta baseada em **JWT (JSON Web Token)**.

## 🚀 Visão Geral do Sistema
O projeto utiliza a arquitetura **MVC** (Model-View-Controller) para separar as responsabilidades. A lógica de autenticação é centralizada em um `AuthController`, enquanto a gestão de dados utiliza `ResourceControllers` para garantir respostas JSON padronizadas.

### Tecnologias Principais
* **Engine:** PHP 8.2.12.
* **Framework:** CodeIgniter 4.4.4.
* **Autenticação:** JSON Web Token (JWT) via biblioteca Firebase.
* **Servidor Local:** XAMPP v3.3.0 (Apache & MySQL).
* **Client de Testes:** Insomnia.

---

## 📸 SCREENSHOTS

### 🗄️ Modelagem de Dados (Database)
A persistência de dados é gerenciada pelo MySQL. A tabela de usuários foi projetada com **UUID (CHAR 36)** para identificadores únicos, aumentando a segurança do sistema.

![MySQL Workbench Schema](Garagem_final_database.png)
> Estrutura das tabelas `usuarios` e `automovel` visualizada no MySQL Workbench.

### 📂 Infraestrutura e Servidor
Utilização do XAMPP para gerenciamento do ambiente local de desenvolvimento.

![XAMPP Control Panel](projeto_garage_api_2.png)

---

### 💻 Implementação do Backend (Código)
O sistema utiliza Controllers robustos com tratamento de exceções e Models para abstração da camada de dados.



![Controller Logic](Garagem_final.png)
* **CRUD de Automóveis:** Implementado no arquivo `Automovel.php`.
* **Persistência Segura:** Uso de blocos `try-catch` para capturar falhas na inserção e retornar status HTTP 500 em caso de erro.

---

### 🧪 Validação de Endpoints e Respostas
Abaixo, a validação de uma requisição de leitura (GET) utilizando autenticação via **Bearer Token**.

![Insomnia Request Success](Garagem%20final.png)
* **Endpoint:** `GET /automovel`.
* **Status Code:** `200 OK`.
* **Autorização:** O cabeçalho `Authorization` transporta o token JWT validado pelo sistema.

---

## 🔐 Camadas de Segurança

### 1. Autenticação JWT
O fluxo de segurança segue o padrão da indústria:
1.  **Geração**: O usuário realiza login com credenciais válidas e recebe um Token assinado.
2.  **Mapeamento**: O token armazena o `id_users` no payload para identificação segura do usuário.
3.  **Transporte**: O cliente envia o token via Header `Authorization: Bearer <TOKEN>` em cada requisição protegida.

### 2. Filtros de Rota (Middleware)
Foi implementado um **Filtro JWT** que intercepta as requisições para rotas sensíveis. Ele verifica a validade da assinatura e a expiração do token antes de permitir o acesso aos métodos do Controller.

---

## 🛠️ Endpoints Disponíveis

| Método | Rota | Descrição | Protegido |
| :--- | :--- | :--- | :--- |
| **POST** | `/login` | Autentica usuário e gera Token | Não |
| **GET** | `/automovel` | Lista todos os veículos registrados | **Sim** |
| **POST** | `/automovel/create` | Registra um novo veículo no sistema | **Sim** |
| **PUT** | `/automovel/update/(:id)`| Atualiza dados de um veículo específico | **Sim** |
| **DELETE**| `/automovel/delete/(:id)`| Remove um registro permanentemente | **Sim** |

---

## ⚙️ Configuração do Ambiente Local

1.  Clone o projeto para o diretório `htdocs` do seu servidor local.
2.  Importe o banco de dados `garage_api.sql` visualizado no schema.
3.  Configure o arquivo `.env` na raiz do projeto:
    * Defina o `database.default.database = garage_api`.
    * Adicione sua `JWT_SECRET` para assinatura dos tokens.
4.  Execute `composer install` para instalar as bibliotecas JWT.
5.  Inicie o servidor e utilize o **Insomnia** para testar os endpoints.

---

**Desenvolvido por:** Cauã Santos de Carvalho
