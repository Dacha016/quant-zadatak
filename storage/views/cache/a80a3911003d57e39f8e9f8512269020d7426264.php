<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
<?php $__env->startSection("content"); ?>
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <img src=<?php echo e($row->file_name); ?>  alt="pictures" >
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//profile.blade.php ENDPATH**/ ?>