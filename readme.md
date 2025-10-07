# 🛒 Desafio Técnico Fullstack: Carrinho de Compras

Este projeto é a solução para um desafio técnico fullstack, que consiste no desenvolvimento de um módulo de **carrinho de compras**.
O sistema simula a jornada de compra de um usuário, permitindo a seleção de produtos, escolha da forma de pagamento e cálculo do valor final com aplicação de **regras de desconto e juros**.

---

## 📦 Tecnologias

O projeto utiliza uma arquitetura de **microsserviços** e é totalmente orquestrado com **Docker Compose**.

| Serviço          | Tecnologia                  | Descrição                                                                      |
| :--------------- | :-------------------------- | :----------------------------------------------------------------------------- |
| **API**          | **PHP (Laravel)**           | Responsável pela lógica de negócio, cálculo do carrinho e regras de pagamento. |
| **Frontend**     | **Vue.js**                  | Interface do usuário para adicionar produtos e simular o checkout.             |
| **Web Server**   | **Nginx**                   | Servidor web que roteia requisições para a API.                                |
| **Database**     | **MySQL 8.0**               | Banco de dados relacional (opcional, pois o desafio foca na lógica).           |
| **Orquestração** | **Docker / Docker Compose** | Gerencia e isola os serviços da aplicação.                                     |

---

## ⚙️ Estrutura do Projeto

```
carrinho-compras/
├── api/                # Backend PHP/Laravel
│   ├── docker/
│   │   └── nginx.conf  # Configuração do Nginx
│   └── ...
├── web/                # Frontend Vue.js
│   └── ...
├── docker-compose.yml  # Orquestração dos serviços
└── .env                # Variáveis de ambiente
```

---

## 🚀 Como Executar o Projeto

### 🧩 1. Pré-requisitos

Certifique-se de ter instalado:

* [Docker](https://docs.docker.com/get-docker/)
* [Docker Compose](https://docs.docker.com/compose/)

---

### 🧾 2. Configurar Variáveis de Ambiente

Crie um arquivo `.env` na RAIZ DO SEU PROJETO com o seguinte conteúdo:

```env
# Variáveis do Banco de Dados
DB_DATABASE=carrinho_compras
DB_USERNAME=user
DB_PASSWORD=secret
APP_DB_PORT=3307

# Variáveis das Aplicações
APP_API_PORT=8001
APP_WEB_PORT=5173
```

---

### 🐳 3. Subir os Contêineres

Execute o comando:

```bash
docker compose up --build -d
```

Isso iniciará todos os serviços:

* MySQL em `localhost:3307`
* API (Laravel) em `http://localhost:8001`
* Frontend (Vue.js) em `http://localhost:5173`

---
### 🧰 4. Comandos Úteis

Subir em background:

```bash
docker compose up -d
```

Parar todos os serviços:

```bash
docker compose down
```

Ver logs:

```bash
docker compose logs -f
```

Acessar o container da API:

```bash
docker exec -it carrinho_compras_api bash
```

---

### ✅ 5. Testes
Há testes automatizados disponíveis para o backend. Para executá-los, acesse o container da API e rode:
```bash
php artisan test
```
