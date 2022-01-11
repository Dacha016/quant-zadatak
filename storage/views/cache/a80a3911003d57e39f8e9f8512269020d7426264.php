<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
<?php $__env->startSection("content"); ?>
    <div style="margin: 20px auto; max-width: 1200px;">
        <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="d-inline-block m-3" >
                <div>
                    <img src=<?php echo e($row->file_name); ?> class="mt-2" alt="<?php echo e($row->file_name); ?>">
                </div>
                <div class="text-center">
                    <a href="/comment" class="btn btn-info d-inline-block" style="padding: 10px"><i class=" d-block fas fa-comment"></i></a>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//profile.blade.php ENDPATH**/ ?>