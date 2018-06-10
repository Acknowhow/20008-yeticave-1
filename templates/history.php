<div class="container">
    <section class="lots">
        <h2>История просмотров</h2>
        <ul class="lots__list">
            <?php foreach ($lots as $lot) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $lot['lot_path'] ?>" width="350" height="260" alt="<?= $lot['name'] ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $lot['lot_category'] ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?lot_id=<?= $lot['id'] ?>"><?= $lot['name'] ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= $lot['value'] ?><b class="rub">&#8381</b></span>
                        </div>
                        <div class="lot__timer timer <?php if (is_array(convertLotTimeStamp($lot['UNIX_TIMESTAMP(l.date_end)']))) : ?> timer--finishing<?php endif;?>">
                            <?php if (is_array(convertLotTimeStamp($lot['UNIX_TIMESTAMP(l.date_end)']))) : ?><?= convertLotTimeStamp($lot['UNIX_TIMESTAMP(l.date_end)'])[0] ?>
                            <?php else : ?><?= convertLotTimeStamp($lot['UNIX_TIMESTAMP(l.date_end)']) ?><?php endif; ?>
                        </div>
                    </div>
                </div>
            </li><?php endforeach; ?>
        </ul>
    </section>
    <?= $pagination ?>
</div>
