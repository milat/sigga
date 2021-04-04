# SIGGA

## Sistema de Gestão de Gabinete

### Instalando pendendências

```
composer install
```

Antes de executar a migração, setar as variáveis de ambiente `SUPERUSER_EMAIL` e `SUPERUSER_INIT_PASSWORD` no arquivo .env e realizar possíveis modificações nos arquivos de configuração `config/app.php`, `config/language.php`, `config/document_types.php`, `config/generate.php`, `config/phone_types.php`, `config/request_statuses.php` e `config/system.php`.

### Migrando tabelas

```
php artisan migrate
```

### Populando tabelas

```
php artisan db:seed
```

### Gerar um cliente fake para testes e demonstrações

```
php artisan command:generate
```

--------

## Political Office Management System

### Installing dependencies

```
composer install
```

Before running migration, set environment variables `SUPERUSER_EMAIL` and `SUPERUSER_INIT_PASSWORD` at .env file and make possible changes at the files `config/app.php`, `config/language.php`, `config/document_types.php`, `config/generate.php`, `config/phone_types.php`, `config/request_statuses.php` and `config/system.php`.

### Migration

```
php artisan migrate
```

### Seeding

```
php artisan db:seed
```

### Generate a fake client for dev and display purposes

```
php artisan command:generate
```