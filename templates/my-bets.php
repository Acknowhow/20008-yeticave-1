<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list"><?php foreach ($my_bets as $key => $value) : ?>
    <tr class="rates__item">
      <td class="rates__info">
        <div class="rates__img">
          <img src="<?= $value['lot_img_url']; ?>" width="54" height="40" alt="<?= $value['category_name'] ?>">
        </div>
        <h3 class="rates__title"><a href="lot.php?lot_id=<?= $lot['lot_id'] ?>"><?= $value['lot_name'] ?></a></h3>
      </td>
      <td class="rates__category"><?=$value['category_name']; ?>
      </td>
      <td class="rates__timer">
        <div class="timer timer--finishing">07:13:34</div>
      </td>
      <td class="rates__price"><?=$value['bet_value']; ?>
      </td>
      <td class="rates__time"><?print(convertTimeStamp($value['date_add'])); ?>
      </td>
      </tr><?php endforeach; ?>
  </table>
</section>
