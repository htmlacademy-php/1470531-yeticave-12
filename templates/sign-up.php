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
<form
    class="form container <?php echo count(array_filter($errors)) ? 'form--invalid' : '' ?>"
    action="sign-up.php"
    method="post"
    autocomplete="off"
>
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?php echo isset($errors['email']) ? 'form__item--invalid' : '' ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail"
               value="<?php echo isset($form['email']) ? $form['email'] : '' ?>">
        <span class="form__error"><?php echo $errors['email'] ?? '' ?></span>
    </div>
    <div class="form__item <?php echo isset($errors['password']) ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль"
               value="<?php echo isset($form['password']) ? $form['password'] : '' ?>">
        <span class="form__error"><?php echo $errors['password'] ?? '' ?></span>
    </div>
    <div class="form__item <?php echo isset($errors['name']) ? 'form__item--invalid' : '' ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя"
               value="<?php echo isset($form['name']) ? $form['name'] : '' ?>">
        <span class="form__error"><?php echo $errors['name'] ?? '' ?></span>
    </div>
    <div class="form__item <?php echo isset($errors['message']) ? 'form__item--invalid' : '' ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message"
                  placeholder="Напишите как с вами связаться"><?php echo isset($form['message']) ? $form['message'] : '' ?></textarea>
        <span class="form__error"><?php echo $errors['message'] ?? '' ?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="./login.php">Уже есть аккаунт</a>
</form>
