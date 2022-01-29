<?php
if(!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
<?php $__env->startSection("content"); ?>
<div style="width: 1200px; margin: 10px auto">
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <?php if($_SESSION["id"] == $gallery->userId): ?>
    <form id="imageForm" action ="/addImage/galleries/<?php echo e($gallery->galleryId); ?>" method="post" class="p-2 align-self-center" style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden" >
        <input type="file" id="fileName" name="fileName" />
        <input class="float-right" type="submit" id="submit" name="submit" value="Upload" />
    </form>
    <?php endif; ?>
    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(($_SESSION["role"] === "admin" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "moderator" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "user" && $row->userId ===$_SESSION["id"])): ?>
            <div class="d-inline-block m-1" >
                <div>
                    <a href="/profile/comments/galleries/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img class="mt-2" alt="<?php echo e($row->file_name); ?>" src=<?php echo e($row->file_name); ?> >
                    </a>
                </div>
                <div class="text-center">
                    <a href="/profile/galleries/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>
                    <form action ="/delete/image/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->galleryId); ?>" name="galleryId">
                        <input type="hidden" value="<?php echo e($row->userId); ?>" name="userId">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="imageId">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php if($_SESSION["role"] === "admin" && $row->userId !==$_SESSION["id"]): ?>
            <div class="d-inline-block m-1" >
                <div class="text-center">
                    <a href="/comments/users/<?php echo e($row->username); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img class="mt-2" alt="<?php echo e($row->file_name); ?>" src=<?php echo e($row->file_name); ?> >
                    </a>
                </div>
                <div>
                    <a href="/profile/users/<?php echo e($row->username); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>
                    <form action ="/delete/image/<?php echo e($row->imageId); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->galleryId); ?>" name="galleryId">
                        <input type="hidden" value="<?php echo e($row->userId); ?>" name="userId">
                        <input type="hidden" value="<?php echo e($row->imageId); ?>" name="imageId">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php if($_SESSION["role"] === "moderator" && $row->userId !==$_SESSION["id"]): ?>
            <div class="d-inline-block m-1" >
                <div >
                    <a href="/comments/users/<?php echo e($row->username); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img class="mt-2" alt="<?php echo e($row->file_name); ?>" src=<?php echo e($row->file_name); ?> >
                    </a>
                </div>
                <div class="text-center">
                    <a href="/profile/users/<?php echo e($row->username); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>
                </div>
            </div>
        <?php endif; ?>
            <?php if($_SESSION["role"] === "user" && $row->userId !==$_SESSION["id"]): ?>
                <div class="d-inline-block m-1" >
                    <a href="/comments/users/<?php echo e($row->username); ?>/<?php echo e($row->galleryId); ?>/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img class="mt-2" alt="<?php echo e($row->file_name); ?>" src=<?php echo e($row->file_name); ?> >
                    </a>
                </div>
            <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<script type="text/javascript" src="../js/index.js"></script>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//images.blade.php ENDPATH**/ ?>