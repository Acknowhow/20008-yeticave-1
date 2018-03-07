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
                        Мин. ставка <span><?= htmlspecialchars($lot_step) ?> &#8381</span>
                    </div>
                </div>
                <form class="lot-item__form" action="my-bets.php" method="post">
                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text"
                               name="cost"
                               placeholder="<?= htmlspecialchars($lot_value + $lot_step) ?>">
                        <input type="hidden" name="lot_id" value="<?= $lot_id ?>">
                        <input type="hidden" name="lot_value" value="<?= htmlspecialchars($lot_value) ?>">
                        <input type="hidden" name="lot_step" value="<?= htmlspecialchars($lot_step) ?>">
                        <br>
                    </p>
                    <?php if (!$my_lot === true) :?><button type="submit" class="button">Сделать ставку</button><?php endif;?>
                </form>
            </div><?php endif;?>
            <div class="history">
                <h3>История ставок (<span>4</span>)</h3>
                <table class="history__list">

                    <?php foreach ($bets as $bet) : ?>
                        <tr class="history__item">
                            <td class="history__name"><?= $index['user_name'] ?></td>
                            <td class="history__price"><?= $index['bet_value'] ?> р</td>
                            <td class="history__time"><?= $index['bet_ts'] ?></td>
                        </tr>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>
    </div>
</section>
