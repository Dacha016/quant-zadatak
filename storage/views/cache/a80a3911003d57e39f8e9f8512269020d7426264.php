<?php
if (!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>


<?php $__env->startSection("content"); ?>
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <div style="margin: 20px auto; max-width: 1000px; text-align: center">
        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="d-inline-block m-2">
                <img src=<?php echo e($row->file_name); ?>  alt="pictures" >
                <div>
                    <form action ="moderator/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->slug); ?>" name="update">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="1">
                            <label class="form-check-label" for="hidden">Hidden</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="1">
                            <label class="form-check-label" for="nsfw">Nsfw</label>
                        </div>
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                    <form action ="profile/image/delete/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="<?php echo e($row->slug); ?>" name="delete">
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//profile.blade.php ENDPATH**/ ?>