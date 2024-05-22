#!/bin/bash

C='\033[0;36m'
N='\033[0m' # No Color

echo ${C}  "Levantando contenedores (docker)."${N}
cd backend_proyecto_laravue
docker-compose up -d
echo ${C}  "contenedores Lanzados (docker)."${N}
echo ${C}  "Creación de aplicaciones dentro de contenedores."${N}
docker-compose exec -T laravel composer install
# docker-compose exec -T laravel php artisan module:use
# docker-compose exec -T laravel php artisan module:enable
docker-compose exec -T laravel php artisan optimize
docker-compose exec -T laravel php artisan migrate:fresh
docker-compose exec -T laravel php artisan db:seed
echo ${C}  "La aplicación está lista en IP:80 y IP:80/api." ${N}