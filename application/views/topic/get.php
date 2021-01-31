<div class="span10">
    <article>
        <h1><?= $topic->title ?></h1>
        <div>
            <div>
                <?php
                //echo date('o년 n월 j일, G시 i분 s초', $topic->created); 
                echo kdate($topic->created);
                ?></div>
            <?php
            // $topic->description 
            echo auto_link($topic->description);
            ?>
        </div>
    </article>
    <div>
        <a class="btn" href="/ci_opentutorials/index.php/topic/add">추가</a>

    </div>
</div>