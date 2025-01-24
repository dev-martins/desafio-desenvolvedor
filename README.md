# FileFlow

## Design Pattern Implementados

 1. Service
 2. Repository
 3. Strategy
 4. Specification
 5. Factory

## Funcionalidades

 1. Upload de csv/excel e armazenamento no banco de dados
 2. Armazenamento em fila para processamento posterior
 3. Buscar pela arquivo
 4. Filtrar conteúdo do arquivo
 5. Registro de usuários
 6. Login com autenticação de dois fatores (2FA)

## Serviços Externos

 1. [MailTrap](https://mailtrap.io/): para envio do código de login
 2. [CloudAMQP](https://www.cloudamqp.com): para filas RabbitMQ
 3. [Ngrok](https://download.ngrok.com/downloads/windows): para criar um tunel para conexão do CloudAMQP com a aplicação localmente
 4. [Postman](https://documenter.getpostman.com/view/7646530/2sAYQfDpWk): para testar e documentar endpoints

## Como Iniciar a Aplicação e Testar

### Usando docker

 1. Ter o Docker instalado
 2. Ter Mysql instalado
 3. No .env na conexão com banco: `DB_HOST=host.docker.internal`
 4. Na raiz do projeto rodar: `docker-compose up -d --build`


### Usando Servidor do próprio Laravel

 1. Ter PHP 8.3 instalado
 2. ter a extensão sockets habilitada
 3. No .env na conexão com banco: `DB_HOST=127.0.0.1`
 4. Na raiz do Projeto rodar: `php artisan serve --port=8001`

### Tanto no Docker quanto no Laravel 

 1. Ter o Ngrok instalado e rodar: `ngrok http 8001`
 2. Ter uma conta configurada no CloudAMQP
 3. Configurar o smtp
 4. Rodar o comando: `php artisan queue:work`

