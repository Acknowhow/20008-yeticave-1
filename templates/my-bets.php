<section class="rates container">
  <h2>Мои ставки</h2>
<?php if(isset($my_bets)) : ?>
  <style>
      .rates__timer .timer {
          width: 97px
      }
  </style>
<?php endif; ?>

  <table class="rates__list">
<?php foreach ($my_bets as $bet) : ?>
    <tr class="rates__item<?php if (convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.date_end)']) === 'lot_end' && !$bet['bet_wins']) : ?> rates__item--end<?php elseif ($bet['bet_wins'] === 1) : ?> rates__item--win<?php endif; ?>">
      <td class="rates__info">
        <div class="rates__img">
          <img src="<?= $bet['lot_path']; ?>" width="54" height="40" alt="<?= $bet['lot_category'] ?>">
        </div>
        <div>
          <h3 class="rates__title"><a href="lot.php?lot_id=<?= $bet['lot_id'] ?>"><?= $bet['lot_name'] ?></a></h3>
<?php if (!empty($bet['contacts'])) : ?>
          <p><?= $bet['contacts'] ?></p>
<?php endif; ?>
        </div>
      </td>
      <td class="rates__category"><?=$bet['lot_category']; ?></td>

      <td class="rates__timer">
        <div class="timer<?php if (convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.date_end)']) === 'lot_end' && !$bet['bet_wins']) : ?> timer--end<?php elseif ($bet['bet_wins'] === 1) : ?> timer--win<?php elseif (is_array(convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.date_end)'])) === true) : ?> timer--finishing<?php endif;?>">
<?php if (convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.date_end)']) === 'lot_end' && !$bet['bet_wins']) : ?>Торги окончены
<?php elseif ($bet['bet_wins'] === 1) : ?>Ставка выиграла
<?php elseif (is_array(convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.date_end)']))) : ?><?= convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.date_end)'])[0]?>
<?php else :?><?= convertLotTimeStamp($bet['UNIX_TIMESTAMP(l.date_end)'])?>
<?php endif; ?>
        </div>
      </td>

      <td class="rates__price"><?=$bet['value']; ?></td>
      <td class="rates__time"><?= convertDailyTimeStamp($bet['UNIX_TIMESTAMP(b.date_add)']) ?></td>
      </tr><?php endforeach; ?>
  </table>
</section>
