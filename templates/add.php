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
<form class="form form--add-lot container <?php echo count(array_filter($errors)) ? 'form--invalid' : '' ?>" action="add.php"
      method="post"
      enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?php echo isset($errors['title']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input
                id="lot-name"
                type="text"
                name="title"
                placeholder="Введите наименование лота"
                value="<?php echo isset($form['title']) ? $form['title'] : '' ?>"
            >
            <span class="form__error"><?php echo $errors['title'] ?? '' ?></span>
        </div>
        <div class="form__item <?php echo isset($errors['category_id']) ? 'form__item--invalid' : '' ?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category_id">
                <?php
                foreach ($categories as $category): ?>
                    <option
                        value="<?php echo $category['id'] ?>"
                        <?php echo isset($form['category_id']) && $form['category_id'] === $category['id'] ? 'selected' : '' ?>
                    >
                        <?php echo $category['title'] ?>
                    </option>
                    <?php
                endforeach; ?>
            </select>
            <span class="form__error"><?php echo $errors['category_id'] ?? '' ?></span>
        </div>
    </div>
    <div class="form__item form__item--wide <?php echo isset($errors['description']) ? 'form__item--invalid' : '' ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea
            id="message"
            name="description"
            placeholder="Напишите описание лота"
        ><?php echo isset($form['description']) ? $form['description'] : '' ?></textarea>
        <span class="form__error"><?php echo $errors['description'] ?? '' ?></span>
    </div>
    <div class="form__item form__item--file <?php echo isset($errors['image']) ? 'form__item--invalid' : '' ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot-img" value="" name="image">
            <label for="lot-img">
                Добавить
            </label>
            <span class="form__error"><?php echo $errors['image'] ?? '' ?></span>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?php echo isset($errors['starting_price']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input
                id="lot-rate"
                type="text"
                name="starting_price"
                placeholder="0"
                value="<?php echo isset($form['starting_price']) ? $form['starting_price'] : '' ?>"
            >
            <span class="form__error"><?php echo $errors['starting_price'] ?? '' ?></span>
        </div>
        <div class="form__item form__item--small <?php echo isset($errors['bet_step']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input
                id="lot-step"
                type="text"
                name="bet_step"
                placeholder="0"
                value="<?php echo isset($form['bet_step']) ? $form['bet_step'] : '' ?>"
            >
            <span class="form__error"><?php echo $errors['bet_step'] ?? '' ?></span>
        </div>
        <div class="form__item <?php echo isset($errors['completion_date']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input
                class="form__input-date"
                id="lot-date"
                type="text"
                name="completion_date"
                placeholder="Введите дату в формате ГГГГ-ММ-ДД"
                value="<?php echo isset($form['completion_date']) ? $form['completion_date'] : '' ?>"
            >
            <span class="form__error"><?php echo $errors['completion_date'] ?? '' ?></span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
