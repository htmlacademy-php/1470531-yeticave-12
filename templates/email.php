<?php
/**
 * @var array $data
 */
?>

<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?= $data['name'] ?></p>
<p>Ваша ставка для лота
    <a href="http://localhost:8090/lot.php?id=<?= $data['id'] ?>">
        <?= $data['title'] ?>
    </a> победила.
</p>
<p>Перейдите по ссылке <a href="http://localhost:8090/my-bets.php">мои ставки</a>,
    чтобы связаться с автором объявления</p>
<small>Интернет Аукцион "YetiCave"</small>
