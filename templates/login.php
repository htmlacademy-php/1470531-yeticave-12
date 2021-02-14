<?php
/**
 * @var array $categories
 * @var array $errors
 * @var array $form
 */

?>

<nav class="nav">
    <ul class="nav__list container">
        <?php echo render_categories($categories) ?>
    </ul>
</nav>
<form class="form container <?php echo count(array_filter($errors)) ? 'form--invalid' : '' ?>" action="login.php"
      method="post">
    <h2>Вход</h2>
    <div class="form__item <?php echo isset($errors['email']) ? 'form__item--invalid' : '' ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input
            id="email"
            type="text"
            name="email"
            placeholder="Введите e-mail"
            value="<?php echo isset($form['email']) ? $form['email'] : '' ?>"
        >
        <span class="form__error"><?php echo $errors['email'] ?? '' ?></span>
    </div>
    <div class="form__item form__item--last <?php echo isset($errors['password']) ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input
            id="password"
            type="password"
            name="password"
            placeholder="Введите пароль"
            value="<?php echo isset($form['password']) ? $form['password'] : '' ?>"
        >
        <span class="form__error"><?php echo $errors['password'] ?? '' ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
