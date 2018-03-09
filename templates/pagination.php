<? if ($pages_count > 1) : ?>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a href="<?if($curr_page > 1 && $curr_page <= 3)  : ?>index.php?page=<?=$curr_page - 1;?><?endif;?>">Назад</a></li>
        <? foreach ($pages as $page) : ?>
        <li class="pagination-item <? if($page == $curr_page) : ?>pagination-item-active<? endif; ?>">
            <a href="index.php?page=<?=$page;?>"><?=$page; ?></a>
        </li>
        <? endforeach; ?><!-- pagination-item-active -->

        <li class="pagination-item pagination-item-next">
            <a href="<?if($curr_page >= 1 && $curr_page !== 3)  : ?>index.php?page=<?=$curr_page + 1;?><?endif;?>">Вперед</a></li>
    </ul>
<? endif; ?>
