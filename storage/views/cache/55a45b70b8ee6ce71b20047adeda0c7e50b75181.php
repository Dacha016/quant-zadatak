<?php $__env->startSection("content"); ?>
    <h1 class="d-block " style="text-align:center">Galleries</h1>
    <div style="margin: 20px auto; max-width: 1000px;" >
        <?php if($_SESSION["role"] === "user" ): ?>
            <table style="text-align: center;">
                <tr>
                    <th style=" border: 1px solid black ">Username</th>
                    <th style="border: 1px solid black">Email</th>
                </tr>
                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="text-align: center; border: 1px solid black ">
                            <a href="/profile/users/<?php echo e($row->id); ?>?page=0"> <?php echo e($row->username); ?></a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->username); ?></p>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        <?php endif; ?>
            <?php if($_SESSION["role"] === "admin" || $_SESSION["role"] === "moderator"): ?>
                <table style="text-align: center;">
                    <tr>
                        <th style=" border: 1px solid black ">Username</th>
                        <th style="border: 1px solid black">Email</th>
                        <th style="border: 1px solid black">Role</th>
                        <th style="border: 1px solid black">Nsfw</th>
                        <th style="border: 1px solid black">Actice</th>
                    </tr>
                    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="text-align: center; border: 1px solid black ">
                                <a href="/profile/update/users/<?php echo e($row->id); ?>?page=0"> <?php echo e($row->username); ?></a>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p><?php echo e($row->username); ?></p>
                            </td>
                            <form action="/profile/update/users/<?php echo e($row->id); ?>" method="post" >
                                <input type="hidden" name = "userId" value=<?php echo e($row->id); ?>>
                                <td style="text-align: center; border: 1px solid black ">
                                    <input name="role" value="<?php echo e($row->role); ?>">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <?php if($row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($row->nsfw); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="<?php echo e($row->nsfw); ?>">
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <?php if($row->active): ?>
                                        <input class="form-check-input" type="checkbox" id="active" name="active" value=<?php echo e($row->active); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->active): ?>
                                        <input class="form-check-input" type="checkbox" id="active" name="active" value="<?php echo e($row->active); ?>">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            <?php endif; ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item ">
                    <a class="page-link" href="?page= <?php echo e(abs($_GET["page"]-1)); ?>" tabindex="-1">Previous</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page= <?php echo e(abs($_GET["page"]+1)); ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//users.blade.php ENDPATH**/ ?>