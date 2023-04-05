# WP-framework
Based on [`HTML Framework`](https://github.com/ideus-team/html-framework)

* [Установка](#установка)
* [Верстка](#верстка)
* [Сніпети](#сніпети)
  * [Breadcrumbs](#breadcrumbs)
  * [Pagination](#pagination)
  * [Inline SVG](#inline-svg)

## Установка
1. Скачиваем с [офсайта](https://wordpress.org/download/) архив голого Wordpress и заливаем его в новый пустой проект
2. Удаляем:
   * `wp-content/plugins/hello.php`
   * `wp-content/themes/` все-стандартные-темы
3. Clone `https://github.com/ideus-team/wp-framework.git`
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

## Верстка
* На етапі верстки під кожну сторінку створюється шаблон виду `pagename.php` у теці `page-templates` (ці сторінки також потрібно створити в адміїнці у Pages та прив'язати до них відповідні шаблони). У жодному разі не чіпати без потреби `index.php`, це універсальний темплейт, а не головна сторінка.
* Не забути створити сторінку для темплейта `example.php` та стилізувати її.
* Не верстати меню руками а створити їх через адмінку, після чого написавши до них відповідні стилі.
* не вішати класи на елемент `p`, він не для цього.
* всі блоки, що передбачають виведення форматованого тексту, повинні мати клас `b-text` і текст усередині них повинен бути у вигляді абзаців, наприклад:
```html
…
<div class="b-article__description b-text">
  <p>Це текст статті, повний чи скорочений — не має значення</p>
  <ul>
    <li>пункт меню</li>
  </ul>
</div>
…
```
* по можливості не вішати стилі на елементи поза текстовими блоками
* не вішати класи на елементи всередині `b-text`, це саме той випадок, коли слід використовувати елементи. Наприклад:
```scss
…
.b-article {

  &__description {

    p {
      font-size: 15px;
    }

    ul {
      line-height: 2em;
    }
  }
}
…
```

## Сніпети
При верстці хлібних крихт та пагінації слід використовувати наступний код:

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
або просто вставити ось цей код, який одразу буде виводити актуальний HTML для них:
```php
<?php nc_breadcrumbs(); ?>
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

### Inline SVG
Усі інлайнові SVG повинні бути у окремих svg-файлах і додані на сторінку за допомогою наступного кода:
```php
<?php include( get_theme_file_path( 'assets/img/path_to_image.svg' ) ); ?>
```
