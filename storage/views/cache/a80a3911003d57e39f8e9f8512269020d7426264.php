<?php
if (!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>


<?php $__env->startSection("content"); ?>
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <div style="margin: 20px auto; max-width: 1000px; text-align: center">
        <table>

            <tr>
                <th style="width: 20%">Gallery name</th>
                <th style="width: 20%">Gallery description</th>
            </tr>
            <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>

                    <td><a href="/profile/gallery/<?php echo e($row->id); ?>"><?php echo e($row->name); ?></a></td>
                    <td><p><?php echo e($row->description); ?></p></td>

            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//profile.blade.php ENDPATH**/ ?>