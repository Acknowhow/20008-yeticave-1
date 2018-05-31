<form class="form container<?php if (!empty($errors)) : ?> form_invalid<?php endif; ?>" action="register.php" method="POST" enctype="multipart/form-data">
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item<?php if (!empty($errors['email'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="<?= $email['name'] ?>"><?= $email['title'] ?></label>
        <input id="<?= $email['name'] ?>"
               type="text"
               name="<?= $email['name'] ?>"
               placeholder="<?= $email['placeholder'] ?>"
               value="<?= htmlspecialchars($email['input']) ?>">
        <span class="form__error"><?php if (!empty($errors['email'])) : ?><?= $errors['email'] ?><?php endif; ?></span>
    </div>

    <div class="form__item<?php if (!empty($errors['password'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="<?= $password['name'] ?>"><?= $password['title'] ?></label>
        <input id="<?= $password['name'] ?>"
               type="text"
               name="<?= $password['name'] ?>"
               placeholder="<?= $password['placeholder'] ?>"
               value="<?= htmlspecialchars($password['input']) ?>">
        <span class="form__error"><?php if (!empty($errors['password'])) : ?><?= $errors['password'] ?><?php endif; ?></span>
    </div>
    <div class="form__item<?php if (!empty($errors['name'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="<?= $name['name'] ?>"><?= $name['title'] ?></label>
        <input id="<?= $name['name'] ?>"
               type="text"
               name="<?= $name['name'] ?>"
               placeholder="<?= $name['placeholder'] ?>"
               value="<?= htmlspecialchars($name['input']) ?>">
        <span class="form__error"><?php if (!empty($errors['name'])) : ?><?= $errors['name'] ?><?php endif; ?></span>
    </div>
    <div class="form__item<?php if (!empty($errors['contacts'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="<?= $contacts['name'] ?>"><?= $contacts['title'] ?></label>
        <textarea id="<?= $contacts['name'] ?>"
                  name="<?= $contacts['name'] ?>"
                  placeholder="<?= $contacts['placeholder'] ?>"><?= htmlspecialchars($contacts['input']) ?></textarea>
        <span class="form__error"><?php if (!empty($errors['contacts'])) : ?><?= $errors['contacts'] ?><?php endif; ?></span>
    </div>
    <div class="form__item form__item--file form__item--last<?php if (!empty($upload_error)) : ?>form__item--invalid<?php endif; ?>">
        <label><?= $avatar_path['title'] ?></label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="" width="113" height="113" alt="<?= $avatar_path['name'] ?>">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" value="" name="<?= $avatar_path['name'] ?>">
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
