<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
<?php $__env->startSection("content"); ?>
<h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
<div >
    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="d-inline-block m-2">
            <img src=<?php echo e($row->file_name); ?> class="mt-2" alt="<?php echo e($row->filename); ?>">
            <?php if(($_SESSION["role"] === "admin" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "moderator" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "user" && $row->userId ===$_SESSION["id"])): ?>
                <div class="d-inline-block m-2">
                    <form action ="http://localhost/profile/galleries/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                    <form action ="http://localhost/delete/image/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->galleryId); ?>" name="galleryId">
                        <input type="hidden" value="<?php echo e($row->userId); ?>" name="userId">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="imageId">
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if($_SESSION["role"] === "admin" && $row->userId !==$_SESSION["id"]): ?>
                <div class="d-inline-block m-2">
                    <form action ="http://localhost/profile/users/<?php echo e($row->userId); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                    <form action ="http://localhost/delete/image/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->galleryId); ?>" name="galleryId">
                        <input type="hidden" value="<?php echo e($row->userId); ?>" name="userId">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="imageId">
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if($_SESSION["role"] === "moderator" && $row->userId !==$_SESSION["id"]): ?>
                <div >
                    <form action ="http://localhost/profile/users/<?php echo e($row->userId); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                </div>
            <?php endif; ?>
        <div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//images.blade.php ENDPATH**/ ?>