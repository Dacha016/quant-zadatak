<?php $__env->startSection("content"); ?>
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <div style="margin: 20px auto; max-width: 1000px; text-align: center">
        <?php $role = $_SESSION["role"]?>
        <?php if($role === "admin"): ?>
                <div style="margin: 20px auto; max-width: 1000px; text-align: center">
                    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src=<?php echo e($row->file_name); ?>  alt="pictures" >
                        <div>
                            <form action ="admin/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="<?php echo e($row->slug); ?>" name="update">
                                <div class="form-check">
                                    <?php if($row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($row->hidden); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($row->hidden); ?>>
                                    <?php endif; ?>
                                    <label class="form-check-label" for="hidden">Hidden</label>
                                </div>
                                <div class="form-check">
                                    <?php if($row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($row->nsfw); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($row->nsfw); ?>>
                                    <?php endif; ?>
                                    <label class="form-check-label" for="nsfw">Nsfw</label>
                                </div>
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </form>
                            <form action ="delete/image/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="<?php echo e($row->slug); ?>" name="delete">
                                <button class="btn btn-danger" type="submit">DELETE</button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            <?php if($role === "moderator"): ?>
                <div style="margin: 20px auto; max-width: 1000px; text-align: center">
                    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src=<?php echo e($row->file_name); ?>  alt="pictures" >
                        <div>
                            <form action ="moderator/<?php echo e($row->slug); ?>" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="<?php echo e($row->slug); ?>" name="update">
                                <div class="form-check">
                                    <?php if($row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($row->hidden); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($row->hidden); ?>>
                                    <?php endif; ?>
                                    <label class="form-check-label" for="hidden">Hidden</label>
                                </div>
                                <div class="form-check">
                                    <?php if($row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($row->nsfw); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($row->nsfw); ?>>
                                    <?php endif; ?>
                                    <label class="form-check-label" for="nsfw">Nsfw</label>
                                </div>
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            <?php if($role === "user"): ?>
                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src=<?php echo e($row->file_name); ?>  alt="pictures" >
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//user.blade.php ENDPATH**/ ?>