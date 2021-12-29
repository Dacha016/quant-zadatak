<?php $__env->startSection("content"); ?>
    <h1 class="d-block " style="text-align:center">Users</h1>
    <div style="margin: 20px auto; max-width: 1000px; display: flex; flex-wrap: wrap; justify-content: space-between">
        <?php $role = $_SESSION["role"] ?>
            <?php if($role === "admin"): ?>
                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-inline-block m-2">
                        <p>
                            <a href="/admin/users/<?php echo e($row->id); ?>" > <?php echo e($row->username); ?></a>
                        </p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($role === "moderator"): ?>
                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-inline-block m-2">
                    <p>
                        <a href="/profile/moderator/users/<?php echo e($row->id); ?>" > <?php echo e($row->username); ?></a>
                    </p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($role === "user"): ?>
                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-inline-block m-2">
                        <p>
                            <a href="/profile/users/<?php echo e($row->id); ?>"  style="display: inline-block; padding: 10px; background: azure; justify-content: stretch" > <?php echo e($row->username); ?></a>
                        </p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//users.blade.php ENDPATH**/ ?>