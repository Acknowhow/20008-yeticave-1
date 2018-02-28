<?=$nav; ?>
<form class="form container <?if (!empty($errors)) : ?>form__invalid<?endif; ?>" action="/login.php" method="post">
    <h2>Вход</h2>
    <div class="form__item <?if (!empty($errors['user_email'])) : ?>form__item--invalid<?endif; ?>">
        <label for="<?=$user_email['name']; ?>"><?=$user_email['title']; ?></label>
        <input id="<?=$user_email['name']; ?>"
               type="text"
               name="<?=$user_email['name']; ?>"
               placeholder="<?=$user_email['placeholder']; ?>"
               value="<?=htmlspecialchars($user_email['input']); ?>">
        <span class="form__error"><?if (isset($errors['user_email'])) : ?><?=$errors['user_email']; ?><?endif; ?></span>
    </div>
    <div class="form__item form__item--last <?if (!empty($errors['user_password'])) : ?>form__item--invalid<?endif; ?>">
        <label for="<?=$user_password['name']; ?>"><?=$user_password['title']; ?></label>
        <input id="<?=$user_password['name']; ?>"
               type="text"
               name="<?=$user_password['name']; ?>"
               placeholder="<?=$user_password['placeholder']; ?>"
               value="<?=htmlspecialchars($user_password['input']); ?>">
        <span class="form__error"><?if (isset($errors['user_password'])) : ?><?=$errors['user_password']; ?><?endif; ?></span>
        <input type="hidden" name="login" value="">
    </div>
    <button type="submit" class="button">Войти</button>
</form>
