# WP-framework
Based on [HTML Framework](https://github.com/ideus-team/html-framework)

* [Установка](#Установка)
* [Вёрстка](#Вёрстка)
* [Сниппеты](#Сниппеты)
  * [Breadcrumbs](#breadcrumbs)
  * [Pagination](#pagination)

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
8. Permalink Settings → Common Settings → Post name (если WP попросит внести изменения в `.htaccess` — нужно это сделать)
9. Settings → General - выставляем таймозону, форматы даты-времени и т.д.
10. На время разработки следует закрыть сайт паролем при помощи плагина [Password Protected](https://wordpress.org/plugins/password-protected/)

## Вёрстка
* На этапе вёрстки под каждую страницу создается шаблон вида `pagename.php` в папке `page-templates` (эти страницы также нужно создать в адмиинке в Pages и привязать к ним соответствующие шаблоны). Ни в коем случае не трогать без надобности `index.php`, это универсальный шаблон а не главная страница.
* Не верстать менюшки руками а создать их через админку, после чего написав к ним соответствующие стили.

## Сниппеты
При вёрстке хлебных крошек и пагинации следует использовать следующий код:

### Breadcrumbs
```html
<div class="l-breadcrumbs">
  <ul class="b-breadcrumbs">
    <li class="b-breadcrumbs__item">
      <a class="b-breadcrumbs__link" href="#">Item</a>
    </li>

    <li class="b-breadcrumbs__item">
      <a class="b-breadcrumbs__link" href="#">Item</a>
    </li>

    <li class="b-breadcrumbs__item -state_current">
      Item
    </li>
  </ul>
</div>
```
### Pagination
```html
<div class="b-pagination">
  <div class="b-pagination__total">Found 250</div>
  <div class="b-pagination__pages">Page 2 of 25</div>

  <ul class="b-pagination__list">
    <li class="b-pagination__item">
      <a class="b-pagination__link -type_prev" href="#">←</a>
    </li>
    <li class="b-pagination__item">
      <a class="b-pagination__link" href="#">1</a>
    </li>
    <li class="b-pagination__item">
      <span class="b-pagination__link -state_active">2</span>
    </li>
    <li class="b-pagination__item">
      <span class="b-pagination__link -type_dots">…</span>
    </li>
    <li class="b-pagination__item">
      <a class="b-pagination__link" href="#">25</a>
    </li>
    <li class="b-pagination__item">
      <a class="b-pagination__link -type_next" href="#">→</a>
    </li>
  </ul>
</div>
```
