<form action="/ci_opentutorials/index.php/topic/add" method="post" class="span10">
    <?php
    // ci library 인 form_validation 의 에러메시지 표출
    echo validation_errors();
    ?>

    <input type="text" name="title" placeholder="제목" class="span12">
    <textarea name="description" rows="12" placeholder="본문" class="span12"></textarea>

    <div class="form_control">
        <input class="btn" type="submit">
    </div>

</form>

<!-- ckeditor 추가 -->
<script src="/ci_opentutorials/static/lib/ckeditor/ckeditor.js"></script>

<script>
    CKEDITOR.replace('description', {
        'filebrowserUploadUrl': '/ci_opentutorials/index.php/topic/upload_receive_from_ck'
    });
</script>