<ul>
    <?php
    foreach ($topics as $entry) {
    ?>
        <li><a href="/ci_opentutorials/index.php/topic/get/<?= $entry->id ?>"><?= $entry->title ?></a></li>
    <?php
    }
    ?>
</ul>

