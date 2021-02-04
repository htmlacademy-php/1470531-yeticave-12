<?php
/**
 * @var array $categories
 * @var array $offer
 * @var boolean $is_bet_visible
 * @var string $bet_error
 * @var string $current_price
 * @var string $minimal_bet
 * @var array $bets
 */

?>

<nav class="nav">
    <ul class="nav__list container">
        <?= render_categories($categories) ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?= $offer['title'] ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="./uploads/<?= $offer['image'] ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?= $offer['category'] ?></span></p>
            <p class="lot-item__description"><?= $offer['description'] ?></p>
        </div>
        <div class="lot-item__right">
            <?php if ($is_bet_visible): ?>
                <div class="lot-item__state">
                    <?php
                    [$hours, $minutes] = getRemainingTime($offer['completion_date']);
                    $css_class = $hours < 1 ? 'timer--finishing' : '';

                    print <<<END
                                    <div class="lot-item__timer timer $css_class">
                                        {$hours} : {$minutes}
                                    </div>
                                END;
                    ?>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= $current_price ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= $minimal_bet ?> р</span>
                        </div>
                    </div>
                    <form
                        class="lot-item__form"
                        action="lot.php?id=<?= $offer['id'] ?>"
                        method="post"
                        autocomplete="off"
                    >
                        <p class="lot-item__form-item form__item <?= strlen($bet_error) ? 'form__item--invalid' : '' ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="bet" placeholder="<?= $minimal_bet ?>">
                            <span class="form__error"><?= $bet_error ?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
            <?php endif; ?>
            <div class="history">
                <h3>История ставок (<span><?= count($bets) ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($bets as $bet): ?>
                        <tr class="history__item">
                            <td class="history__name"><?= $bet['name'] ?></td>
                            <td class="history__price"><?= $bet['price'] ?></td>
                            <td class="history__time"><?= time_ago(time() - strtotime($bet['created_on'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
