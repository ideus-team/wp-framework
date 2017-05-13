# WP-framework
Based on [HTML Framework](https://github.com/ideus-team/html-framework)

## Установка
1. Скачиваем с [офсайта](https://wordpress.org/download/) архив голого Wordpress и заливаем его в новый пустой проект
2. Удаляем:
  * `wp-content/plugins/hello.php`
  * `wp-content/themes/` все-стандартные-темы
3. Clone https://github.com/ideus-team/wp-framework.git
4. Содержимое репозитория копируем в корень своего проекта копируем поверх существующих файлов
5. Переименовываем тему:
  * правим соответствующие строки в `wp-content/themes/theme/style.css`
  * заменяем `wp-content/themes/theme/screenshot.png` на скриншот проекта (1200х900px)
  * переименовываем папку `wp-content/themes/theme` по имени проекта
6. Во время установки указываем email `wordpress@ideus.biz` (или клиента, но не личный!)
7. Активируем нашу тему
8. На этапе вёрстки под каждую страницу создается шаблон вида `page-PAGE_SLUG.php` (эти страницы также нужно создать в Pages). Главная страница = `front-page.php` (но ни в коем случае не `index.php`, это универсальный шаблон)
9. Permalink Settings → Common Settings → Post name (если WP попросит внести изменения в `.htaccess` — нужно это сделать)
10. Settings → General - выставляем таймозону, форматы даты-времени и т.д.
11. На время разработки следует закрыть сайт паролем при помощи плагина [Password Protected](https://wordpress.org/plugins/password-protected/)
