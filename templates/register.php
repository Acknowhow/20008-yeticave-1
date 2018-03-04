<form class="form container<?php if (!empty($errors)) : ?> form_invalid<?php endif; ?>" action="/register.php" method="POST" enctype="multipart/form-data">
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item<?php if (!empty($errors['user_email'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="<?= $user_email['name'] ?>"><?= $user_email['title'] ?></label>
        <input id="<?= $user_email['name'] ?>"
               type="text"
               name="<?= $user_email['name'] ?>"
               placeholder="<?= $user_email['placeholder'] ?>"
               value="<?= htmlspecialchars($user_email['input']) ?>">
        <span class="form__error"><?php if (!empty($errors['user_email'])) : ?><?= $errors['user_email'] ?><?php endif; ?></span>
    </div>

    <div class="form__item<?php if (!empty($errors['user_password'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="<?= $user_password['name'] ?>"><?= $user_password['title'] ?></label>
        <input id="<?= $user_password['name'] ?>"
               type="text"
               name="<?= $user_password['name'] ?>"
               placeholder="<?= $user_password['placeholder'] ?>"
               value="<?= htmlspecialchars($user_password['input']) ?>">
        <span class="form__error"><?php if (!empty($errors['user_password'])) : ?><?= $errors['user_password'] ?><?php endif; ?></span>
    </div>
    <div class="form__item<?php if (!empty($errors['user_name'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="<?= $user_name['name'] ?>"><?= $user_name['title'] ?></label>
        <input id="<?= $user_name['name'] ?>"
               type="text"
               name="<?= $user_name['name'] ?>"
               placeholder="<?= $user_name['placeholder'] ?>"
               value="<?= htmlspecialchars($user_name['input']) ?>">
        <span class="form__error"><?php if (!empty($errors['user_name'])) : ?><?= $errors['user_name'] ?><?php endif; ?></span>
    </div>
    <div class="form__item<?php if (!empty($errors['user_contacts'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="<?= $user_contacts['name'] ?>"><?= $user_contacts['title'] ?></label>
        <textarea id="<?= $user_contacts['name'] ?>"
                  name="<?= $user_contacts['name'] ?>"
                  placeholder="<?= $user_contacts['placeholder'] ?>"><?= htmlspecialchars($user_contacts['input']) ?></textarea>
        <span class="form__error"><?php if (!empty($errors['user_contacts'])) : ?><?= $errors['user_contacts'] ?><?php endif; ?></span>
    </div>
    <div class="form__item form__item--file form__item--last<?php if (!empty($upload_error)) : ?>form__item--invalid<?php endif; ?>">
        <label><?= $user_img['title'] ?></label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="" width="113" height="113" alt="<?= $user_img['name'] ?>">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" value="" name="<?= $user_img['name'] ?>">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
            <span
                class="form_error"><?php if (!empty($upload_error)) : ?><?= $upload_error ?><?php endif; ?></span>
        </div>
    </div>
    <input type="hidden" name="register" value="">
    <span class="form__error form__error--bottom"></span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
