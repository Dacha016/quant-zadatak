<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
<?php $__env->startSection("content"); ?>
<div style="width: 1200px; margin: 10px auto">
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(($_SESSION["role"] === "admin" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "moderator" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "user" && $row->userId ===$_SESSION["id"])): ?>
            <div class="d-inline-block m-3" >
                <div>
                    <img src=<?php echo e($row->file_name); ?> class="mt-2" alt="<?php echo e($row->file_name); ?>">
                </div>
                <div class="text-center">
                    <a href="/imageComment" class="btn btn-info d-inline-block" style="padding: 10px"><i class=" d-block fas fa-comment"></i></a>
                    <form action ="http://localhost/profile/galleries/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                    <form action ="http://localhost/delete/image/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->galleryId); ?>" name="galleryId">
                        <input type="hidden" value="<?php echo e($row->userId); ?>" name="userId">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="imageId">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php if($_SESSION["role"] === "admin" && $row->userId !==$_SESSION["id"]): ?>
            <div class="d-inline-block" >
                <div>
                    <img src=<?php echo e($row->file_name); ?> class="mt-2" alt="<?php echo e($row->file_name); ?>">
                </div>
                <div>
                    <a href="/comments/users/<?php echo e($row->userId); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px"><i class=" d-block fas fa-comment"></i></a>
                    <form action ="http://localhost/profile/galleries/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                    <form action ="http://localhost/delete/image/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->galleryId); ?>" name="galleryId">
                        <input type="hidden" value="<?php echo e($row->userId); ?>" name="userId">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="imageId">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php if($_SESSION["role"] === "moderator" && $row->userId !==$_SESSION["id"]): ?>
                <div class="d-inline-block" >
                <div>
                    <img src=<?php echo e($row->file_name); ?> class="mt-2" alt="<?php echo e($row->file_name); ?>">
                </div>
                <div>
                    <a href="/comments/users/<?php echo e($row->userId); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px"><i class=" d-block fas fa-comment"></i></a>
                    <form action ="http://localhost/profile/galleries/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
            <?php if($_SESSION["role"] === "user" && $row->userId !==$_SESSION["id"]): ?>
                <div class="d-inline-block" >
                    <img src=<?php echo e($row->file_name); ?> class="mt-2" alt="<?php echo e($row->file_name); ?>">
                    <div class="text-center">
                        <a href="/comments/users/<?php echo e($row->userId); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block text-center" style="padding: 10px"><i class=" d-block fas fa-comment"></i></a>
                    </div>
                </div>
            <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//images.blade.php ENDPATH**/ ?>