<?php
/**
 * @var array $categories
 * @var array $bets
 */

?>

<nav class="nav">
    <ul class="nav__list container">
        <?= render_categories($categories) ?>
    </ul>
</nav>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($bets as $bet): ?>
        <!-- TODO: добавить выйгравшую ставку -->
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= $bet['image'] ?>" width="54" height="40"
                             alt="<?= htmlspecialchars($bet['title']) ?>">
                    </div>
                    <h3 class="rates__title"><a
                            href="./lot.php?id=<?= $bet['id'] ?>"><?= htmlspecialchars($bet['title']) ?></a></h3>
                </td>
                <td class="rates__category">
                    <?= $bet['category'] ?>
                </td>
                <td class="rates__timer">
                    <?php
                    [$hours, $minutes] = getRemainingTime($bet['completion_date']);
                    $css_class = $hours < 1 ? 'timer--finishing' : '';

                    print <<<END
                                <div class="timer $css_class">
                                    {$hours} : {$minutes}
                                </div>
                            END;
                    ?>
                </td>
                <td class="rates__price">
                    <?= htmlspecialchars(format_price($bet['price'])) ?>
                </td>
                <td class="rates__time">
                    <?= time_ago(time() - strtotime($bet['created_on'])) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
