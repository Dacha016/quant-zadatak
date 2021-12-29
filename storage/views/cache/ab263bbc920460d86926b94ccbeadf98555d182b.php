<?php
if (!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>

<?php $__env->startSection("content"); ?>
    <h1 class="d-block " style="text-align:center">Galleries</h1>
    <div style="margin: 20px auto; max-width: 1000px;" >
        <table style="text-align: center;">
            <tr >
                <th style="width: 33%; border: 1px solid black ">Gallery name</th>
                <th style="width: 33%; border: 1px solid black">Gallery description</th>
            </tr>
            <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="margin: 0 auto; border: 1px solid black"><a href="/gallery/<?php echo e($row->slug); ?>"><?php echo e($row->name); ?></a></td>
                    <td style="text-align: center; border: 1px solid black "><p><?php echo e($row->description); ?></p></td>
                    <?php if($row->user_id === $_SESSION["id"] || $_SESSION["role"] !== "user"): ?>
                        <td style="border: 1px solid black">
                            <form action ="#" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="<?php echo e($row->slug); ?>" name="adminModeratorUpdate">
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//gallery.blade.php ENDPATH**/ ?>