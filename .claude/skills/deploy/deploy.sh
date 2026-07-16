#!/usr/bin/env bash
# Деплой темы и плагина на хостинг по FTPS (lftp mirror).
# Использование: deploy.sh [theme|core|all]   (по умолчанию all)
# Креденшелы — вне git: /root/ShumoffNet/.deploy-ftp.env (см. SKILL.md).
set -euo pipefail

TARGET="${1:-all}"
ENV_FILE="${DEPLOY_ENV:-/root/ShumoffNet/.deploy-ftp.env}"
REPO="$(cd "$(dirname "${BASH_SOURCE[0]}")/../../.." && pwd)"

if [[ ! -f "$ENV_FILE" ]]; then
  echo "ОШИБКА: нет файла с креденшелами $ENV_FILE" >&2
  echo "Создайте его по шаблону из SKILL.md (chmod 600)." >&2
  exit 1
fi
# shellcheck source=/dev/null
source "$ENV_FILE"
: "${FTP_HOST:?FTP_HOST не задан в $ENV_FILE}"
: "${FTP_USER:?FTP_USER не задан в $ENV_FILE}"
: "${FTP_PASS:?FTP_PASS не задан в $ENV_FILE}"
: "${FTP_REMOTE_ROOT:?FTP_REMOTE_ROOT не задан в $ENV_FILE (путь к корню WordPress)}"

if [[ -n "$(git -C "$REPO" status --porcelain -- shumoff-theme shumoff-core)" ]]; then
  echo "ВНИМАНИЕ: в shumoff-theme/shumoff-core есть незакоммиченные изменения — они тоже уедут на сервер." >&2
fi

MIRROR_OPTS="--only-newer --no-perms --parallel=4 --verbose"
CMDS="set cmd:fail-exit true;"
if [[ "$TARGET" == "theme" || "$TARGET" == "all" ]]; then
  CMDS+=" mirror -R $MIRROR_OPTS '$REPO/shumoff-theme' '$FTP_REMOTE_ROOT/wp-content/themes/shumoff-theme';"
fi
if [[ "$TARGET" == "core" || "$TARGET" == "all" ]]; then
  CMDS+=" mirror -R $MIRROR_OPTS '$REPO/shumoff-core' '$FTP_REMOTE_ROOT/wp-content/plugins/shumoff-core';"
fi
if [[ "$CMDS" == "set cmd:fail-exit true;" ]]; then
  echo "ОШИБКА: неизвестная цель '$TARGET' (ожидается theme|core|all)" >&2
  exit 1
fi

# FTP_VERIFY_CERT=no можно задать в env-файле осознанно (самоподписанный
# сертификат у хостинга); по умолчанию сертификат проверяется.
export LFTP_PASSWORD="$FTP_PASS"
lftp --env-password -u "$FTP_USER" \
  -e "set ftp:ssl-allow true; set ssl:verify-certificate ${FTP_VERIFY_CERT:-yes}; $CMDS bye" \
  "$FTP_HOST"

echo "Деплой завершён: $TARGET → $FTP_HOST:$FTP_REMOTE_ROOT"
