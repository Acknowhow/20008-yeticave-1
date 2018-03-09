<section class="lot-item container">
    <h2><?= htmlspecialchars($lot_name) ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $lot_img_url ?>"
                     width="730"
                     height="548" alt="<?= htmlspecialchars($lot_name) ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot_category ?></span></p>
            <p class="lot-item__description"><?= htmlspecialchars($lot_description) ?></p>
        </div>
        <div class="lot-item__right"><?php if ($is_auth === true) : ?>
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    10:54:12
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= htmlspecialchars($lot_value) ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= htmlspecialchars($lot_value + $lot_step) ?> &#8381</span>
                    </div>
                </div>
                <form class="lot-item__form" action="my-bets.php" method="post">
                    <?php if (isset($bet_author)) : ?><!-- fixing button position -->
                        <style>
                            .lot-item__form {
                                position: relative
                            }
                            .lot-item__form .button {
                                position: absolute;
                                top: 21px;
                                right: 0;
                            }
                            .form__error {
                                width: 130px;
                            }
                        </style><?php endif; ?>
                    <p class="lot-item__form-item<?php if (!empty($bet_error)) : ?> form__item--invalid<?php endif; ?>">
                        <label for="bet_value">Ваша ставка</label>
                        <input <?php if($bet_author === true) : ?>disabled<?php endif; ?>
                               id="bet_value" type="text"
                               name="bet_value"
                               placeholder="<?= htmlspecialchars($lot_value + $lot_step) ?>">
                        <input type="hidden" name="lot_id" value="<?= $lot_id ?>">
                        <input type="hidden" name="lot_value" value="<?= htmlspecialchars($lot_value) ?>">
                        <input type="hidden" name="lot_step" value="<?= htmlspecialchars($lot_step) ?>">
                        <span class="form__error"><?php if (!empty($bet_error)) : ?><?= $bet_error ?><?php endif; ?></span>
                    </p>
                    <?php if ($my_lot === false && $bet_author === false) : ?><button type="submit" class="button">Сделать ставку</button><?php endif;?>
                </form>
            </div><?php endif; ?>
            <div class="history">
                <h3>История ставок (<span>4</span>)</h3>
                <table class="history__list">

                    <?php if(!empty($bets)) : ?><?php foreach ($bets as $bet) : ?>
                        <tr class="history__item">
                            <td class="history__name"><?= $bet['bet_author'] ?></td>
                            <td class="history__price"><?= $bet['bet_value'] ?> р</td>
                            <td class="history__time"><?= convertTimeStamp($bet['UNIX_TIMESTAMP(b.bet_date_add)']) ?></td>
                        </tr>
                    <?php endforeach; ?><?php endif; ?>

                </table>
            </div>
        </div>
    </div>
</section>
