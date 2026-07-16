---
name: deploy
description: Залить тему shumoff-theme и плагин shumoff-core из репозитория на хостинг по FTPS (lftp). Использовать, когда пользователь просит задеплоить/залить сайт или файлы на хостинг.
---

# Деплой на хостинг (FTPS)

Заливает `shumoff-theme/` → `wp-content/themes/shumoff-theme` и `shumoff-core/` → `wp-content/plugins/shumoff-core` на боевой сайт (сейчас http://shumanet.flowaibot.ru/). WordPress-ядро, uploads и всё остальное на сервере не трогается; файлы на сервере не удаляются (только добавление/обновление, `--only-newer`).

## Как выполнять

1. Убедись, что нужные изменения закоммичены (скрипт предупредит про незакоммиченное, но не остановится).
2. Запусти:
   ```bash
   bash .claude/skills/deploy/deploy.sh          # тема + плагин
   bash .claude/skills/deploy/deploy.sh theme    # только тема
   bash .claude/skills/deploy/deploy.sh core     # только плагин
   ```
3. Проверь результат: `curl -s http://shumanet.flowaibot.ru/ | grep -o 'ver=[0-9]*'` — версии CSS/JS должны обновиться (тема версионирует ассеты по filemtime).

## Креденшелы

Лежат ВНЕ git в `/root/ShumoffNet/.deploy-ftp.env` (chmod 600):

```bash
FTP_HOST=ftp.example.com
FTP_USER=login
FTP_PASS='пароль'
FTP_REMOTE_ROOT=/путь/к/корню/wordpress   # каталог, где лежит wp-content
# FTP_VERIFY_CERT=no  # только если у хостинга самоподписанный сертификат и деплой падает на TLS
```

Если файла нет — попроси у пользователя данные FTP из панели хостинга и создай файл сам (не коммить, не выводить пароль в ответах).

## Ограничения

- Скрипт не удаляет файлы на сервере: если файл переименован/удалён в репо, старый останется на хостинге — удалить вручную через панель.
- `--only-newer` сравнивает mtime: после свежего `git clone` все файлы посчитаются новыми и зальются целиком — это нормально.
- Прайс-данные `shumoff-core/data/price-list.php` — часть плагина, уезжают вместе с ним.
