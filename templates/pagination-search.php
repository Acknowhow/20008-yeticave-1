<?php if ($pages_count > 1) : ?>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a href="<?php if($curr_page > 1 && $curr_page <= 3)  : ?>search.php?page=<?=$curr_page - 1;?>&search=<?= $search ?><?php endif;?>">Назад</a>
        </li>
        <?php foreach ($pages as $page) : ?>
            <li class="pagination-item <?php if($page == $curr_page) : ?>pagination-item-active<?php endif; ?>">
                <a href="search.php?page=<?= $page ?>&search=<?= $search ?>"><?= $page ?></a>
            </li>
        <?php endforeach; ?> <!-- pagination-item-active -->
        <li class="pagination-item pagination-item-next">
            <a href="<?php if($curr_page >= 1 && $curr_page !== 3)  : ?>search.php?page=<?=$curr_page + 1;?>&search=<?= $search ?><?php endif;?>">Вперед</a>
        </li>
    </ul>
<?php endif; ?>