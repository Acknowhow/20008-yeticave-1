<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
        снаряжение.</p>
    <ul class="promo__list">
<?php foreach ($categories as $category => $value) : ?>
        <li class="promo__item promo__item--<?= htmlspecialchars($category) ?>">
            <a class="promo__link" href="all-lots.html"><?= htmlspecialchars($value) ?></a>
        </li>
<?php endforeach; ?>
    </ul>
</section>

<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>

    <ul class="lots__list">
<?php if (empty($lots)) : ?><?= 'На данный момент нет открытых лотов' ?><?php else: ?><?php foreach ($lots as $lot) : ?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?= htmlspecialchars($lot['lot_path']) ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['name']) ?>">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?= $lot['lot_category'] ?></span>
                <h3 class="lot__title">
                    <a class="text-link" href="lot.php?lot_id=<?= $lot['id'] ?>"><?= htmlspecialchars($lot['name']); ?></a>
                </h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost"><?= convertNum(htmlspecialchars($lot['value'])); ?></span>
                    </div>
                    <div class="lot__timer timer <?php if (is_array(convertLotTimeStamp($lot['UNIX_TIMESTAMP(l.date_end)'])) === true) : ?> timer--finishing<?php endif;?>">
<?php if (is_array(convertLotTimeStamp($lot['UNIX_TIMESTAMP(l.date_end)']))) : ?><?= convertLotTimeStamp($lot['UNIX_TIMESTAMP(l.date_end)'])[0] ?>
<?php else : ?><?= convertLotTimeStamp($lot['UNIX_TIMESTAMP(l.date_end)']) ?><?php endif; ?>
                    </div>
                </div>
            </div>
        </li>
<?php endforeach; ?><?php endif; ?>
    </ul>
</section>

<?=$pagination ?>
