#!/bin/sh
set -e

# Base paths
APP_ROOT=/var/www/html
STORAGE_PATH="$APP_ROOT/storage"
PUBLIC_PATH="$APP_ROOT/public"
PUBLIC_STORAGE_LINK="$PUBLIC_PATH/storage"
CERT_PATH="$STORAGE_PATH/certs/ca.pem"

# If AIVEN_CA_PEM is provided as an env var, write it to storage/certs/ca.pem
if [ -n "$AIVEN_CA_PEM" ]; then
  mkdir -p "$STORAGE_PATH/certs"
  printf "%s\n" "$AIVEN_CA_PEM" > "$CERT_PATH"
  chmod 600 "$CERT_PATH"
fi

# Ensure storage and bootstrap/cache exist and are writable by www-data
mkdir -p "$STORAGE_PATH" "$APP_ROOT/bootstrap/cache" || true
chown -R www-data:www-data "$STORAGE_PATH" "$APP_ROOT/bootstrap/cache" || true
chmod -R 775 "$STORAGE_PATH" "$APP_ROOT/bootstrap/cache" || true

# Prepare the SQLite database file when the service is configured to use SQLite.
if [ "${DB_CONNECTION:-}" = "sqlite" ]; then
  SQLITE_DB_PATH="${DB_DATABASE:-$APP_ROOT/database/database.sqlite}"
  case "$SQLITE_DB_PATH" in
    :memory:)
      ;;
    *)
      mkdir -p "$(dirname "$SQLITE_DB_PATH")" || true
      touch "$SQLITE_DB_PATH" || true
      chown www-data:www-data "$SQLITE_DB_PATH" || true
      chmod 664 "$SQLITE_DB_PATH" || true
      ;;
  esac
fi

# Ensure public/storage symlink exists and points to storage/app/public
mkdir -p "$PUBLIC_PATH"
mkdir -p "$STORAGE_PATH/app/public"
ln -sfn "$STORAGE_PATH/app/public" "$PUBLIC_STORAGE_LINK"
chown -R www-data:www-data "$PUBLIC_STORAGE_LINK" "$STORAGE_PATH/app/public" || true
# Ensure directories are readable/executable and files are readable by the webserver
find "$STORAGE_PATH/app/public" -type d -exec chmod 775 {} + || true
find "$STORAGE_PATH/app/public" -type f -exec chmod 644 {} + || true
chmod 775 "$PUBLIC_STORAGE_LINK" || true

# Clear stale cached views/config/routes from the image before booting.
php artisan optimize:clear || true

# Optionally run migrations if RUN_MIGRATIONS=true
if [ "$RUN_MIGRATIONS" = "true" ]; then
  # Allow failure so container still starts if migrations have issues during deploy
  php artisan migrate --force || true
fi

# Execute the container CMD
exec "$@"
