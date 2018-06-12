<nav class="nav">
    <ul class="nav__list container">
<?php foreach ($categories as $category => $value) : ?>
        <li class="nav__item">
            <a href="index.php?category_id=<?= $value['id'] ?>"><?= $value['name'] ?></a>
        </li>
<?php endforeach; ?>
    </ul>
</nav>
