# Queues Laravel

## Aplicação

Implementação utilizando laravel de um sistema que recebe via API uma requisição JSON e
armazene em uma fila. Ao receber um comando para rodar o job da fila o sistema
grava todos os JSONs recebidos em um arquivo CSV único na ordem inversa de chegada
dos itens na fila.

## Instalação

Guia de instalação oficial do laravel no link: [Official Documentation](https://laravel.com/docs/5.8/installation)

Guia de instalação oficial do docker no link: [Official Documentation](https://docs.docker.com/install)

Link da documentação da API: [Documentação](https://www.getpostman.com/collections/20b2b5a9bcf5e7b9f6c1)

Clone o repositório

    git clone https://github.com/anderson-matheus/queues-laravel.git

Entre na pasta

    cd queues-laravel

Instalação

    docker-compose up -d

Instalação das dependências do composer

    docker exec -it container_name composer install

Faça uma cópia do arquivo .env.example para .env

    docker exec -it container_name cp .env.example .env

Gere a key da aplicação

    docker exec -it container_name php artisan key:generate

Configure as variáveis de ambiente para o banco de dados no .env

    DB_CONNECTION=mysql
    DB_HOST=queues_laravel
    DB_PORT=3306
    DB_DATABASE=queues_laravel
    DB_USERNAME=root
    DB_PASSWORD=123456

Rode as migrações

    docker exec -it container_name php artisan migrate

Limpe o cache do config

    docker exec -it container_name php artisan config:cache

Rodar os testes

    docker exec -it container_name ./vendor/bin/phpunit
    
Processar dados da fila

    docker exec -it container_name php artisan queue:work --tries=1

Acesse o projeto na seguinte url http://localhost:8080
