<section class="rates container">
  <h2>Мои ставки</h2>
    <?php if(isset($my_bets)) : ?>
    <style>
        .rates__timer .timer {
            width: 97px
        }
    </style><?php endif; ?>
  <table class="rates__list"><?php foreach ($my_bets as $bet) : ?>
    <tr class="rates__item<?php if (convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.lot_date_end)']) === 'lot_end') : ?> rates__item--end<?php endif; ?>">
      <td class="rates__info">
        <div class="rates__img">
          <img src="<?= $bet['lot_img_url']; ?>" width="54" height="40" alt="<?= $bet['lot_category'] ?>">
        </div>
        <h3 class="rates__title"><a href="lot.php?lot_id=<?= $bet['lot_id'] ?>"></a><?= $bet['lot_name'] ?></h3>
        <?php if (!empty($bet['user_contacts'])) : ?><p><?= $bet['user_contacts'] ?></p><?php endif; ?>
      </td>
      <td class="rates__category"><?=$bet['lot_category']; ?>
      </td>
      <td class="rates__timer">
        <div class="timer timer--finishing">
            <?php if (convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.lot_date_end)']) === 'lot_end' && !$bet['bet_wins']) : ?>Торги окончены
            <?php elseif ($bet['bet_wins'] === 1) : ?>Ставка выиграла
            <?php else : ?><?= convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.lot_date_end)'])?>
            <?php endif; ?>
        </div>
      </td>
      <td class="rates__price"><?=$bet['bet_value']; ?>
      </td>
      <td class="rates__time"><?= convertBetTimeStamp($bet['UNIX_TIMESTAMP(b.bet_date_add)']) ?></td>
      </tr><?php endforeach; ?>
  </table>
</section>
