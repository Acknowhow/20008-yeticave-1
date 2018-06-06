<section class="lots">
    <h2><?php if (empty($result)) : ?>По вашему запросу ничего не найдено<?php else : ?>Результаты поиска по запросу «<span><?= $search ?></span>»<?php endif;?></h2>
<?php if(!empty($result)): ?>
    <ul class="lots__list">
<?php foreach ($result as $result_query) : ?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?= $result_query['lot_path'] ?>" width="350" height="260" alt="<?= $result_query['name'] ?>">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?= $result_query['category_name'] ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?lot_id=<?= $result_query['id'] ?>"><?= $result_query['name'] ?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost"><?= $result_query['value'] ?><b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer">
                        16:54:12
                    </div>
                </div>
            </div>
        </li>
<?php endforeach; ?>
    </ul>
<?php endif; ?>

<?=$pagination_search ?>
