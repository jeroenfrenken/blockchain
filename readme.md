# Build & Run the project
All commands in the root directory
```bash
docker-compose build
```

```bash
docker run -v $(pwd):/var/www/blockchain blockchain_app:latest composer install
```
```bash
`docker run -v $(pwd):/var/www/blockchain blockchain_app:latest php index.php`
```
