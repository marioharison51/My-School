#!/bin/sh
set -e

if [ ! -f .env ]; then
    cat > .env << 'ENVEOF'
APP_NAME=Laravel
APP_ENV=production
APP_URL=https://my-school-ltmc.onrender.com
ENVEOF
fi

php artisan migrate --force

echo "==> Démarrage sur le port ${PORT:-8000}"
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
