<?php
/**
 * @var array $categories
 * @var array $bets
 * @var int $user_id
 */

?>

<nav class="nav">
    <ul class="nav__list container">
        <?php echo render_categories($categories) ?>
    </ul>
</nav>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php
        foreach ($bets as $bet):
            $is_win = $bet['winner_id'] && $user_id === intval($bet['winner_id']);
            $is_end = !$is_win && strtotime($bet['completion_date']) < time();
            ?>
            <tr class="rates__item <?php echo $is_win ? 'rates__item--win' : '' ?> <?php echo $is_end ? 'rates__item--end' : '' ?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?php echo $bet['image'] ?>" width="54" height="40"
                             alt="<?php echo htmlspecialchars($bet['title']) ?>">
                    </div>
                    <div>
                        <h3 class="rates__title">
                            <a href="./lot.php?id=<?php echo $bet['id'] ?>">
                                <?php echo htmlspecialchars($bet['title']) ?>
                            </a>
                        </h3>
                        <?php
                        if ($is_win) : ?>
                            <p><?php echo $bet['contact'] ?></p>
                            <?php
                        endif; ?>
                    </div>
                </td>
                <td class="rates__category">
                    <?php echo $bet['category'] ?>
                </td>
                <td class="rates__timer">
                    <?php
                    if ($is_win) : ?>
                        <div class="timer timer--win">Ставка выиграла</div>
                        <?php
                    elseif ($is_end) : ?>
                        <div class="timer timer--end">Торги окончены</div>
                        <?php
                    else: ?>
                        <?php
                        [$hours, $minutes] = getRemainingTime($bet['completion_date']);
                        $css_class = $hours < 1 ? 'timer--finishing' : '';

                        print <<<END
                                <div class="timer $css_class">
                                    {$hours} : {$minutes}
                                </div>
                            END;
                        ?>
                        <?php
                    endif; ?>
                </td>
                <td class="rates__price">
                    <?php echo htmlspecialchars(format_price($bet['price'])) ?>
                </td>
                <td class="rates__time">
                    <?php echo time_ago(time() - strtotime($bet['created_on'])) ?>
                </td>
            </tr>
            <?php
        endforeach; ?>
    </table>
</section>
