<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list"><?php foreach ($my_bets as $key => $value) : ?>
    <tr class="rates__item">
      <td class="rates__info">
        <div class="rates__img">
          <img src="<?= $value['lot_img_url']; ?>" width="54" height="40" alt="<?= $value['lot_category'] ?>">
        </div>
        <h3 class="rates__title"><a href="lot.php?lot_id=<?= $value['lot_id'] ?>"><?= $value['lot_name'] ?></a></h3>
        <?php if (!empty($value['user_contacts'])) : ?><p><?= $value['user_contacts'] ?></p><?php endif; ?>
      </td>
      <td class="rates__category"><?=$value['lot_category']; ?>
      </td>
      <td class="rates__timer">
        <div class="timer timer--finishing">Ставка выиграла</div>
      </td>
      <td class="rates__price"><?=$value['bet_value']; ?>
      </td>
      <td class="rates__time"><?= convertBetTimeStamp($value['UNIX_TIMESTAMP(b.bet_date_add)']) ?></td>
      </tr><?php endforeach; ?>
  </table>
</section>
