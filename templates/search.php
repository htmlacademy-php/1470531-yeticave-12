<?php
/**
 * @var array $categories
 * @var array $offers
 * @var string $search
 * @var int $pages_count
 * @var array $pages
 * @var int $current_page
 * @var boolean $isEmptySearch
 */

?>

<nav class="nav">
    <ul class="nav__list container">
        <?php echo render_categories($categories) ?>
    </ul>
</nav>
<div class="container">
    <section class="lots">
        <?php
        if ($isEmptySearch) : ?>
            <h2>Введите поисковый запрос</h2>
            <?php
        else: ?>
            <h2>Результаты поиска по запросу «<span><?php echo $search ?></span>»</h2>
            <?php
        endif; ?>
        <ul class="lots__list">
            <?php
            if (count($offers)) : ?>
                <?php
                foreach ($offers as $offer): ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="./uploads/<?php echo $offer['image'] ?>" width="350" height="260" alt="">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?php echo htmlspecialchars($offer['category']) ?></span>
                            <h3 class="lot__title">
                                <a class="text-link" href="./lot.php?id=<?php echo $offer['id'] ?>">
                                    <?php echo htmlspecialchars($offer['title']) ?>
                                </a>
                            </h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost">
                                <?php echo htmlspecialchars(format_price($offer['starting_price'])) ?></span>
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
                    <?php
                endforeach; ?>
                <?php
            else: ?>
                <p>Ничего не найдено по вашему запросу</p>
                <?php
            endif; ?>
        </ul>
    </section>
    <?php
    if ($pages_count > 1) : ?>
        <ul class="pagination-list">
            <li class="pagination-item pagination-item-prev <?php echo $current_page <= 1 ? 'disabled' : '' ?>">
                <a href="./search.php?page=<?php echo $current_page > 1 ? $current_page - 1 : 1 ?>&search=<?php echo $search ?>">Назад</a>
            </li>
            <?php
            foreach ($pages as $page): ?>
                <li class="pagination-item <?php echo $page === intval($current_page) ? 'pagination-item-active' : '' ?>">
                    <a href="./search.php?page=<?php echo $page ?>&search=<?php echo $search ?>"><?php echo $page ?></a>
                </li>
                <?php
            endforeach; ?>
            <li class="pagination-item pagination-item-next <?php echo intval($current_page) === $pages_count ? 'disabled' : '' ?>">
                <a href="./search.php?page=<?php echo $current_page < $pages_count ? $current_page + 1 : $pages_count ?>&search=<?php echo $search ?>">Вперед</a>
            </li>
        </ul>
        <?php
    endif; ?>
</div>
