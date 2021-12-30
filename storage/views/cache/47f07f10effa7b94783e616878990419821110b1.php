<?php $__env->startSection("content"); ?>
<h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
<div >
    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="d-inline-block m-2">
            <img src=<?php echo e($row->file_name); ?>  alt="pictures" >
            <?php if($_SESSION["role"] === "admin"): ?>
                <?php if($row->userId ===$_SESSION["id"]): ?>
                    <form action ="/profile/galleries/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                <?php endif; ?>
                <?php if($row->userId !==$_SESSION["id"]): ?>
                    <form action ="/profile/users/<?php echo e($row->userId); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                <?php endif; ?>
                    <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                </form>
                <form action ="delete/image/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                    <input type="hidden" value="<?php echo e($row->imageId); ?>" name="delete">
                    <button class="btn btn-danger" type="submit">DELETE</button>
                </form>
            <?php endif; ?>
            <?php if($_SESSION["role"] === "moderator" && $row->userId === $_SESSION["id"]): ?>
                <div class="d-inline-block m-2">
                    <form action ="/profile/galleries/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                    <form action ="delete/image/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="delete">
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if($_SESSION["role"] === "moderator" && $row->userId !==$_SESSION["id"]): ?>
                <div >
                    <form action ="/profile/users/<?php echo e($row->userId); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if($_SESSION["role"] === "user" && $row->userId ===$_SESSION["id"]): ?>
                <div class="d-inline-block m-2">
                    <form action ="/profile/galleries/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                    <form action ="delete/image/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="delete">
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            <?php endif; ?>
        <div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//images.blade.php ENDPATH**/ ?>