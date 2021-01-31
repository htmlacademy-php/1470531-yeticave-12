<?php
/**
 * @var array $categories
 * @var array $offers
 * @var string $search
 * @var int $pages_count
 * @var array $pages
 * @var int $current_page
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
<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?= $search ?></span>»</h2>
        <ul class="lots__list">
            <?php if (count($offers)): ?>
                <?php foreach ($offers as $offer): ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="./uploads/<?= $offer['image'] ?>" width="350" height="260" alt="">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= htmlspecialchars($offer['category']) ?></span>
                            <h3 class="lot__title">
                                <a class="text-link" href="./lot.php?id=<?= $offer['id'] ?>">
                                    <?= htmlspecialchars($offer['title']) ?>
                                </a>
                            </h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost">
                                <?= htmlspecialchars(format_price($offer['starting_price'])) ?></span>
                                </div>
                                <?php
                                [$hours, $minutes] = getRemainingTime($offer['completion_date']);
                                $css_class = $hours < 1 ? 'timer--finishing' : '';

                                print <<<END
                                <div class="lot__timer timer $css_class">
                                    {$hours} : {$minutes}
                                </div>
                            END;
                                ?>

                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Ничего не найдено по вашему запросу</p>
            <?php endif; ?>
        </ul>
    </section>
    <?php if ($pages_count > 1): ?>
        <ul class="pagination-list">
            <li class="pagination-item pagination-item-prev <?= $current_page <= 1 ? 'disabled' : '' ?>">
                <a href="./search.php?page=<?= $current_page > 1 ? $current_page - 1 : 1 ?>&search=<?= $search ?>">Назад</a>
            </li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?= $page === intval($current_page) ? 'pagination-item-active' : '' ?>">
                    <a href="./search.php?page=<?= $page ?>&search=<?= $search ?>"><?= $page ?></a>
                </li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next <?= intval($current_page) === $pages_count ? 'disabled' : '' ?>">
                <a href="./search.php?page=<?= $current_page < $pages_count ? $current_page + 1 : $pages_count ?>&search=<?= $search ?>">Вперед</a>
            </li>
        </ul>
    <?php endif; ?>
</div>
