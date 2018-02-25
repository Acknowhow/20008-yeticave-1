<?=$nav?>
<form class="form form--add-lot container <?if (!empty($errors)) : ?>form--invalid<? endif; ?>"
      action="/add.php" method="POST" enctype="multipart/form-data">
  <h2>Добавление лота</h2>

  <div class="form__container-two">
    <div class="form__item <?if (!empty($errors['lot_name'])) : ?>form__item--invalid<? endif; ?>">
      <label for="<?=$lot_name['name']; ?>"><?=$lot_name['title']; ?></label>
      <input id="<?=$lot_name['name']; ?>"
             type="text"
             name="<?=$lot_name['name']; ?>"
             placeholder="<?=$lot_name['placeholder']; ?>"
             value="<?=htmlspecialchars($lot_name['input_data']); ?>">
      <span class="form__error"<?if (isset($errors['lot_name']['error_message'])) : ?>><?=$errors['lot_name']['error_message']; ?><? endif; ?></span>
    </div>

    <div class="form__item <?if (!empty($errors['category'])) : ?>form__item--invalid<? endif; ?>">
      <label for="<?=$category['name']; ?>"><?=$category['title']; ?></label>
      <select id="<?=$category['name']; ?>"
              name="<?=$category['name']; ?>">
        <option><?=$category['input_data']; ?></option><? foreach ($categories as $category => $value) :?>
        <option><?=$value; ?></option><? endforeach; ?>
      </select>

      <span class="form__error"<?if (isset($errors['category']['error_message'])) : ?>><?=$errors['category']['error_message']; ?><? endif; ?></span>
    </div>
  </div>

  <div class="form__item form__item--wide <?if (!empty($errors['message'])) : ?>form__item--invalid<? endif; ?>">

    <label for="<?=$message['name']; ?>"><?=$message['title']; ?></label>
    <textarea id="<?=$message['name']; ?>"
              name="<?=$message['name']; ?>"
              placeholder="<?=$message['placeholder']; ?>"
              ><?=htmlspecialchars($message['input_data']); ?></textarea>
    <span class="form__error"<?if (isset($errors['message']['error_message'])) : ?>><?=$errors['message']['error_message']; ?><? endif; ?></span>
  </div>

  <div class="form__item form__item--file"> <!-- form__item--uploaded -->
    <label><?=$file['title']; ?></label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="<?=$file['alt']; ?>">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" id="photo2" name="photo">
      <span class="form_error"<?if (isset($errors['file']['error_message'])) : ?>><?=$errors['file']['error_message']; ?><? endif; ?></span>
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
  </div>

  <div class="form__container-three">
    <div class="form__item form__item--small <?if (!empty($errors['lot_rate'])) : ?>form__item--invalid<? endif; ?>">
      <label for="<?=$lot_rate['name']; ?>"><?=$lot_rate['title']; ?></label>
      <input id="<?=$lot_rate['name']; ?>"
             type="number"
             name="<?=$lot_rate['name']; ?>"
             placeholder="0"
             step="0.00001"
             value="<?=htmlspecialchars($lot_rate['input_data']); ?>">
      <span class="form__error"<? if(isset($errors['lot_rate']['error_message'])) : ?>><?=$errors['lot_rate']['error_message']; ?><? endif; ?></span>
    </div>

    <div class="form__item form__item--small <?if (!empty($errors['lot_step'])) : ?>form__item--invalid<? endif; ?>">
      <label for="<?=$lot_step['name']; ?>"><?=$lot_step['title']; ?></label>
      <input id="<?=$lot_step['name']; ?>"
             type="number"
             name="<?=$lot_step['name']; ?>"
             placeholder="0"
             step="0.00001"
             value="<?=htmlspecialchars($lot_step['input_data']); ?>">
      <span class="form__error"<?if (isset($errors['lot_step']['error_message'])) : ?>><?=$errors['lot_step']['error_message']; ?><? endif; ?></span>
    </div>

    <div class="form__item <?if (!empty($errors['lot_date'])) : ?>form__item--invalid<? endif; ?>">
      <label for="<?=$lot_date['name']; ?>"><?=$lot_date['title']; ?></label>
      <input class="form__input-date"
             id="<?=$lot_date['name']; ?>"
             type="date"
             name="<?=$lot_date['name']; ?>"
             value="<?=$lot_date['input_data']; ?>">
      <span class="form__error"<?if (isset($errors['lot_date']['error_message'])) : ?>><?=$errors['lot_date']['error_message']; ?><? endif; ?></span>
    </div>
  </div>

  <span class="form__error form__error--bottom"><?if (!empty($errors)) : ?><?=$all['error_message']; ?><? endif; ?></span>
  <button type="submit" class="button">Добавить лот</button>
</form>
