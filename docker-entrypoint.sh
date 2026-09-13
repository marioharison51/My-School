#!/bin/sh
set -e

if [ ! -f .env ]; then
    cat > .env << 'ENVEOF'
APP_NAME="My School"
APP_ENV=production
ENVEOF
fi

if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    touch "${DB_DATABASE:-database/database.sqlite}"
fi

php artisan migrate --force

echo "==> Démarrage sur le port ${PORT:-8000}"
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
