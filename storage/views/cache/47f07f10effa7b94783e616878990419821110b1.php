<?php $__env->startSection("content"); ?>
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
        <?php
        $role = $_SESSION["role"]
        ?>
        <?php if($role === "admin"): ?>
            <div style="margin: 20px auto; max-width: 1000px; text-align: center">
                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-inline-block m-2">
                        <img src=<?php echo e($row->file_name); ?>  alt="pictures" >
                        <div>
                            <form action ="/profile/gallery/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="<?php echo e($row->slug); ?>" name="adminModeratorUpdate">
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </form>
                            <form action ="delete/image/<?php echo e($result->slug); ?>" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="<?php echo e($result->slug); ?>" name="delete">
                                <button class="btn btn-danger" type="submit">DELETE</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
            <?php if($role === "moderator"): ?>
                <div style="margin: 20px auto; max-width: 1000px; text-align: center">
                    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-inline-block m-2">
                            <img src=<?php echo e($row->file_name); ?>  alt="pictures" >
                            <div>
                                <form action ="/profile/gallery/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                                    <input type="hidden" value="<?php echo e($row->slug); ?>" name="adminModeratorUpdate">
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            <?php if($role === "user"): ?>
                <div style="margin: 20px auto; max-width: 1000px;">
                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($_SESSION["id"] ===$row->user_id): ?>
                        <div class="d-inline-block m-2">
                            <img src=<?php echo e($row->file_name); ?>  alt="pictures" >
                            <div>
                                <form action ="/profile/gallery/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                                    <input type="hidden" value="<?php echo e($row->slug); ?>" name="adminModeratorUpdate">
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </form>


                                    <button class="btn btn-danger" type="submit">DELETE</button>

                            </div>
                         </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//images.blade.php ENDPATH**/ ?>