#!/usr/bin/env bash
set -euo pipefail

PATCH_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
REPO_DIR="${1:-$(pwd)}"

if [[ ! -f "$REPO_DIR/artisan" ]]; then
  echo "Error: target bukan root project Laravel (artisan tidak ditemukan): $REPO_DIR" >&2
  exit 1
fi

copy_paths=(app bootstrap database routes resources tests)
for path in "${copy_paths[@]}"; do
  cp -R "$PATCH_DIR/$path/." "$REPO_DIR/$path/"
done

while IFS= read -r item; do
  [[ -z "$item" || "$item" == \#* ]] && continue
  rm -rf "$REPO_DIR/$item"
done < "$PATCH_DIR/REMOVE_FILES.txt"

cat <<'EOF'
Refactor berhasil diterapkan.
Berikutnya:
  1. Tambahkan ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD ke .env.
  2. Konfigurasi MAIL_* jika fitur lupa password akan dipakai.
  3. Jalankan: php artisan optimize:clear
  4. Jalankan: php artisan migrate:fresh --seed
  5. Jalankan: php artisan storage:link (jika belum)
  6. Jalankan test / smoke test aplikasi.
EOF
