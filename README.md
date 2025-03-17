### Slim middlewares simple app

## Installation guide

1. Uncommit `.env` file.

2. Build containers:

```shell
docker compose --env-file .env up -d --build
```

3. **Dependencies**:

```shell
docker exec -it middleware-php composer install
```

4. Run **migrations**:

```shell
docker exec -it middleware-php ./vendor/bin/doctrine-migrations migrate
```
