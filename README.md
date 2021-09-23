# Backend - Docker Laravel


Clone o repositório
```sh
git clone https://github.com/ricatom/pontential-crud.git
```

Crie o arquivo .env
```sh
cd pontential-crud/api
cp .env.example .env
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acessar o container
```sh
docker-compose exec pontential-crud bash
```

Instalar as dependências do projeto
```sh
composer install
```

Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Criar Migrations e o Seeder para popular o banco de dados Mysql
```sh
php artisan migrate
php artisan db:seed --class=DevelopersSeeder
```

Sair fo container
```sh
exit
```

Concluído

O projeto esta disponível em http://localhost:8989/api/developers

<br><hr>

# Frontend - Docker Vuejs


Acessar diretório
```sh
cd .. (Estando no diretório api, retornar para a raiz)
cd spa
```

Subir os containers do projeto
```sh
docker-compose -f docker-compose.dev.yml up --build
```

Concluído

O projeto esta disponível em http://localhost:8080

