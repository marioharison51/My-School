#!/bin/bash
set -e

echo "==> Installation des dépendances PHP et JS"
composer install --no-interaction
npm install

echo "==> Configuration de l'environnement"
cp -n .env.example .env
php artisan key:generate

echo "==> Base de données SQLite"
touch database/database.sqlite
php artisan migrate --force

echo "==> Détection de l'URL publique du Codespace"
if [ -n "$CODESPACE_NAME" ] && [ -n "$GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN" ]; then
    CODESPACE_URL="https://${CODESPACE_NAME}-8000.${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}"
    echo "URL détectée : $CODESPACE_URL"
    sed -i "s|^APP_URL=.*|APP_URL=${CODESPACE_URL}|" .env
else
    echo "Pas dans un Codespace (ou variables absentes) — APP_URL laissé tel quel."
fi

echo "==> Compilation des assets (CSS/JS)"
npm run build

echo "==> Nettoyage des caches"
php artisan config:clear

echo "==> Setup terminé. Lance : php artisan serve --host=0.0.0.0 --port=8000"
