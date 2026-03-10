#!/bin/sh

# arrêt dès la première erreur
set -e

cat <<EOF > /usr/share/nginx/config.js
window.__CONFIG__ = {
  API_URL: "${API_URL:-}"
};
EOF

echo "Configuration générée :"
cat /usr/share/nginx/config.js

exec nginx -g 'daemon off;'