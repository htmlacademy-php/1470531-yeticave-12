<?php
/**
 * @var array $categories
 */
?>

<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="./"><?= htmlspecialchars($category['title']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2>500 Ошибка на сервере</h2>
    <p>Упс...Наш сервер сломался от вашего запроса.</p>
</section>
