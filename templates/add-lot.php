<form class="form form--add-lot container <?php if (!empty($errors)) : ?>form--invalid<?php endif; ?>"
      action="/add-lot.php" method="POST" enctype="multipart/form-data">
  <h2>Добавление лота</h2>

  <div class="form__container-two">
    <div class="form__item <?php if (!empty($errors['lot_name'])) : ?>form__item--invalid<?php endif; ?>">
      <label for="<?=$lot_name['name'] ?>"><?=$lot_name['title'] ?></label>
      <input id="<?=$lot_name['name'] ?>"
             type="text"
             name="<?=$lot_name['name'] ?>"
             placeholder="<?=$lot_name['placeholder'] ?>"
             value="<?=htmlspecialchars($lot_name['input']) ?>">
      <span class="form__error"><?php if (!empty($errors['lot_name'])) : ?><?= $errors['lot_name'] ?><?php endif; ?></span>
    </div>
    <!-- TODO: what is up with category field height??? -->
    <div class="form__item <?php if (!empty($errors['lot_category'])) : ?>form__item--invalid<?php endif; ?>">
      <label for="<?=$lot_category['name'] ?>"><?=$lot_category['title'] ?></label>
      <select id="<?=$lot_category['name'] ?>"
              name="<?=$lot_category['name'] ?>">
        <option><?=$lot_category['input'] ?></option><?php foreach ($categories as $category => $value) : ?>
        <option><?=$value ?></option><?php endforeach; ?>
      </select>

      <span class="form__error"><?php if (!empty($errors['lot_category'])) : ?><?=$errors['lot_category'] ?><?php endif; ?></span>
    </div>
  </div>

  <div class="form__item form__item--wide <?php if (!empty($errors['lot_description'])) : ?>form__item--invalid<?php endif; ?>">

    <label for="<?= $lot_description['name'] ?>"><?= $lot_description['title'] ?></label>
    <textarea id="<?= $lot_description['name'] ?>"
              name="<?= $lot_description['name'] ?>"
              placeholder="<?= $lot_description['placeholder'] ?>"
              ><?= htmlspecialchars($lot_description['input']) ?></textarea>
    <span class="form__error"><?php if (!empty($errors['lot_description'])) : ?><?=$errors['lot_description'] ?><?php endif; ?></span>
  </div>

  <div class="form__item form__item--file <?php if (!empty($upload_error)) :?>form__item--invalid<?php endif; ?>"> <!-- form__item--uploaded -->
    <label><?= $lot_img['title'] ?></label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="<?=$lot_img['lot_img_alt'] ?>">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" id="photo2" name="lot_img">
      <span class="form_error"><?php if (!empty($upload_error)) : ?><?= $upload_error ?><?php endif; ?></span>
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
  </div>

  <div class="form__container-three">
    <div class="form__item form__item--small <?php if (!empty($errors['lot_value'])) : ?>form__item--invalid<?php endif; ?>">
      <label for="<?=$lot_value['name'] ?>"><?=$lot_value['title'] ?></label>
      <input id="<?=$lot_value['name'] ?>"
             type="text"
             name="<?=$lot_value['name'] ?>"
             placeholder="0"
             step="0.00001"
             value="<?=htmlspecialchars($lot_value['input']) ?>">
      <span class="form__error"><?php if(!empty($errors['lot_value'])) : ?><?=$errors['lot_value'] ?><?php endif; ?></span>
    </div>

    <div class="form__item form__item--small <?php if (!empty($errors['lot_step'])) : ?>form__item--invalid<?php endif; ?>">
      <label for="<?=$lot_step['name'] ?>"><?=$lot_step['title'] ?></label>
      <input id="<?=$lot_step['name'] ?>"
             type="text"
             name="<?=$lot_step['name'] ?>"
             placeholder="0"
             step="0.00001"
             value="<?=htmlspecialchars($lot_step['input']) ?>">
      <span class="form__error"><?php if (!empty($errors['lot_step'])) : ?><?=$errors['lot_step'] ?><?php endif; ?></span>
    </div>

    <div class="form__item <?php if (!empty($errors['lot_date_end'])) : ?>form__item--invalid<?php endif; ?>">
      <label for="<?=$lot_date_end['name'] ?>"><?=$lot_date_end['title'] ?></label>
      <input class="form__input-date"
             id="<?=$lot_date_end['name'] ?>"
             type="text"
             name="<?=$lot_date_end['name'] ?>"
             value="<?=$lot_date_end['input'] ?>">
      <span class="form__error"><?php if (!empty($errors['lot_date_end'])) : ?><?=$errors['lot_date_end'] ?><?php endif; ?></span>
    </div>
  </div>

  <input type="hidden" name="lot_add" value="">
  <span class="form__error form__error--bottom"><?php if (!empty($errors)) : ?><?php print "Пожалуйста, исправьте ошибки в форме" ?><?php endif; ?></span>
  <button type="submit" class="button">Добавить лот</button>
</form>
