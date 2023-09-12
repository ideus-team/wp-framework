# WP-framework
Based on [`HTML Framework`](https://github.com/ideus-team/html-framework)

* [Встановлення](#встановлення)
* [Верстка](#верстка)
* [Сніпети](#сніпети)
  * [Breadcrumbs](#breadcrumbs)
  * [Pagination](#pagination)
  * [Inline SVG](#inline-svg)

## Встановлення
1. Завантажуємо з [офсайту](https://wordpress.org/download/) архів останнього WordPress та заливаємо його в новий порожній проект
2. Видаляємо:
   * `wp-content/plugins/hello.php`
   * `wp-content/themes/*` (всі стандартні теми)
3. Завантажуємо останню версію [WP-framework](https://github.com/ideus-team/wp-framework/releases/latest)
4. Копіюємо вміст архіву в корінь свого проекту поверх існуючих файлів
5. Перейменовуємо тему:
   * правимо відповідні рядки в `wp-content/themes/theme/style.css`
   * замінюємо `wp-content/themes/theme/screenshot.png` на скріншот проекту (1200х900px)
   * перейменовуємо теку `wp-content/themes/theme` на ім'я проекту
6. Правимо `wp-config.php`:
   * прописуємо dev/local домени для автоматичного визначення ***environment type***
   * правимо необхідні `wp-config.*.php`
   * не забуваємо згенерувати ***Authentication unique keys and salts***
7. Встановлюємо WordPress
   * під час встановлення вказуємо email `wordpress@ideus.biz` (або клієнта, але не особистий!)
8. Активуємо нашу тему
9. Permalink Settings → Common Settings → Post name (якщо WP попросить внести зміни до `.htaccess` — потрібно це зробити)
10. Settings → General — встановлюємо таймозону, формати дати-часу тощо.
11. На час розробки слід закрити сайт паролем за допомогою плагіна [Password Protected](https://wordpress.org/plugins/password-protected/)

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
