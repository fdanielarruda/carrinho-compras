#!/bin/sh

echo "Configurando permissões das pastas de storage e cache..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "Instalando dependências do Composer..."
composer install --prefer-dist --optimize-autoloader

echo "Aguardando o serviço de banco de dados..."
timeout=30
while ! nc -z db 3306; do
  sleep 1
  timeout=$((timeout-1))
  if [ "$timeout" -le 0 ]; then
    echo "Erro: O banco de dados não está pronto após 30 segundos."
    exit 1
  fi
done
echo "Banco de dados pronto!"

echo "Gerando variáveis básicas..."
cp .env.example .env

echo "Executando migrações..."
php artisan migrate --force

echo 'Executando Seeders...' &&
php artisan db:seed --force &&

exec "$@"