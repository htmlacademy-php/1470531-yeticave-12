<?php
/**
 * @var array $data
 */

?>

<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?php echo $data['name'] ?></p>
<p>Ваша ставка для лота
    <a href="<?php echo SITE_PATH ?>/lot.php?id=<?php echo $data['id'] ?>">
        <?php echo $data['title'] ?>
    </a> победила.
</p>
<p>Перейдите по ссылке <a href="<?php echo SITE_PATH ?>/my-bets.php">мои ставки</a>,
    чтобы связаться с автором объявления</p>
<small>Интернет Аукцион "YetiCave"</small>
