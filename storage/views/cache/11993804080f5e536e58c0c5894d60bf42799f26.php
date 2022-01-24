<?php $__env->startSection("content"); ?>
    <div style="margin: 20px auto; max-width: 1200px;">
        <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="d-inline-block m-3" >
                <a href="/home/images/<?php echo e($row->imageId); ?>" class="btn btn-info d-inline-block" style="padding: 10px">
                    <img class="mt-2" alt="<?php echo e($row->file_name); ?>" src=<?php echo e($row->file_name); ?> >
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//home.blade.php ENDPATH**/ ?>