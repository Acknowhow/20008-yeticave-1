<section class="lot-item container">
    <h2><?= $lot_name ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $lot_img_url ?>" width="730" height="548" alt="<?= $lot_img_alt ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot_category ?></span></p>
            <p class="lot-item__description"><?= $lot_description ?></p>
        </div>
        <div class="lot-item__right"><?php if ($is_auth === true) : ?>
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    10:54:12
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= $lot_value ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span>12 000 р</span>
                    </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="cost" placeholder="12 000">
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div><?php endif;?>
            <div class="history">
                <h3>История ставок (<span>4</span>)</h3>
                <table class="history__list">

                    <?php foreach ($bets as $bet => $index) : ?>
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
