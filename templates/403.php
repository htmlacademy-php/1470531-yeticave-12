<?php
/**
 * @var array $categories
 */
?>

<nav class="nav">
    <ul class="nav__list container">
        <?= render_categories($categories) ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2>403 Доступ запрещен</h2>
    <p>Необходима авторизация.</p>
</section>
