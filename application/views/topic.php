(view/topic.php) 토픽 페이지

<?php
//var_dump($topics);
?>

<ul>
<?php
foreach($topics as $entry) {
?>
    <li><a href="/ci_opentutorials/index.php/topic/get/<?= $entry->id ?>"><?= $entry->title ?></a></li>
<?php
}
?>
</ul>