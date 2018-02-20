<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
        снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $category => $index) : ?>
            <li class="promo__item promo__item--<?= htmlspecialchars($category) ?>">
                <a class="promo__link"
                   href="all-lots.html"><?= htmlspecialchars($index) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($lots as $lot => $index) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= htmlspecialchars($index['lot_img_url']) ?>"
                         width="350"
                         height="260"
                         alt="<?= htmlspecialchars($index['lot_img_alt']) ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $index['lot_category'] ?></span>
                    <h3 class="lot__title">
                        <a class="text-link"
                           href="index.php?id=<?= $lot_id ?>"><?= htmlspecialchars($index['lot_name']); ?>
                        </a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost">
                                <?= convertNum(htmlspecialchars($index['lot_value'])); ?>
                                <b class="rub">р</b>
                            </span>
                        </div>
                        <div class="lot__timer timer"><?= $time_left ?></div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
