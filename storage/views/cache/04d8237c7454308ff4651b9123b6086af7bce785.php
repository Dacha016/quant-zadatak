<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
<?php $__env->startSection("content"); ?>
<h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
<div style="margin: 20px auto; max-width: 1000px; text-align: center">
    <img src=<?php echo e($result->file_name); ?> alt="pictures" >
    <div>
        <form action ="/update/<?php echo e($result->galleryId); ?>/<?php echo e($result->imageId); ?>" method="post" class="d-inline-block m-1">
            <input type="hidden" value="<?php echo e($result->userId); ?>" name="userId">
            <input type="hidden" value="<?php echo e($result->username); ?>" name="userUsername">
            <input type="hidden" value="<?php echo e($result->galleryId); ?>" name="galleryId">
            <input type="hidden" value="<?php echo e($result->imageId); ?>" name="imageId">
            <input type="hidden" value="<?php echo e($result->file_name); ?>" name="imageName">
            <div class="form-check">
                <?php if($result->hidden): ?>
                    <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($result->hidden); ?> checked>
                <?php endif; ?>
                <?php if(!$result->hidden): ?>
                    <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="0">
                <?php endif; ?>
                <label class="form-check-label" for="hidden">Hidden</label>
            </div>
            <div class="form-check">
                <?php if($result->nsfw): ?>
                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($result->nsfw); ?> checked>
                <?php endif; ?>
                <?php if(!$result->nsfw): ?>
                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="0">
                <?php endif; ?>
                <label class="form-check-label" for="nsfw">Nsfw</label>
            </div>
            <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//image.blade.php ENDPATH**/ ?>