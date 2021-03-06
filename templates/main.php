<?php
/**
 * @var array $categories
 * @var array $offers
 */

?>
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
        снаряжение.</p>
    <ul class="promo__list">
        <?php
        foreach ($categories as $category): ?>
            <li class="promo__item promo__item promo__item--<?php echo $category['symbol_code'] ?>">
                <a class="promo__link"
                   href="./lots.php?category=<?php echo $category['id'] ?>"><?php echo htmlspecialchars($category['title']) ?></a>
            </li>
            <?php
        endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
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
    </ul>
</section>
