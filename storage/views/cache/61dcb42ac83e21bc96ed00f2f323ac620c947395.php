<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
<?php $__env->startSection("content"); ?>
    <form action ="/delete/gallery/<?php echo e($result->galleryId); ?>" method="post" class="p-2 align-self-center" style="margin-left: 35vw; margin-top:20Vh; border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden" >
        <h2 class="mb-2 pt-4" style="text-align:center">Do you want to delete the </h2>
        <h3 style="text-align:center"><?php echo e($result->name); ?></h3>
        <input type="hidden" value="<?php echo e($result->galleryId); ?>" name="galleryId">
        <input type="hidden" value="<?php echo e($result->userId); ?>" name="userId">
        <input type="hidden" name = "page" value=<?php echo e($_GET["page"]); ?>>
        <button class="btn btn-danger float-right" type="submit">Delete</button>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//deleteGallery.blade.php ENDPATH**/ ?>