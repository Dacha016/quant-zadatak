<?php
if(!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
<?php $__env->startSection("content"); ?>
    <div style="margin: 20px auto; width: 1200px;">
        <h1 style="text-align:center; margin: 0 auto">Galleries</h1>
        <?php if($_SESSION["role"] === "user" ): ?>
            <table class="justify-content-center" style="text-align: center;">
                <tr>
                    <th style=" border: 1px solid black ">Username</th>
                    <th style="border: 1px solid black">Email</th>
                </tr>
                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="text-align: center; border: 1px solid black ">
                            <a href="/profile/users/<?php echo e($row->username); ?>?page=1"> <?php echo e($row->username); ?></a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->email); ?></p>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        <?php endif; ?>
        <?php if($_SESSION["role"] === "admin" || $_SESSION["role"] === "moderator"): ?>
            <table style="text-align: center; margin: 0 auto">
                <tr>
                    <th style=" border: 1px solid black ">Username</th>
                    <th style="border: 1px solid black">Email</th>
                    <th style="border: 1px solid black">Role</th>
                    <?php if($_SESSION["role"] === "admin"): ?>
                        <th style="border: 1px solid black ">Subscription</th>
                    <?php endif; ?>
                    <th style="border: 1px solid black">Nsfw</th>
                    <th style="border: 1px solid black">Active</th>
                </tr>
                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="text-align: center; border: 1px solid black ">
                            <a href="/profile/users/<?php echo e($row->username); ?>?page=1"> <?php echo e($row->username); ?></a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->email); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->role); ?></p>
                        </td>
                        <?php if($_SESSION["role"] === "admin"): ?>
                            <td style="text-align: center; border: 1px solid black ">
                                <a href="/subscription/<?php echo e($row->username); ?>">Subscription</a>
                            </td>
                        <?php endif; ?>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->nsfw); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->active); ?></p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit"><a style="color: white" href="/profile/update/users/<?php echo e($row->username); ?>?page=<?php echo e($_GET['page']); ?>"><i class="fas fa-pen"></i></a></button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        <?php endif; ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if($_GET["page"] > 1): ?>
                    <li class="page-item" >
                        <a class="page-link" href="?page=1" > << </a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] === 1): ?>
                        <a class="page-link" href="?page=1" disabled> << </a>
                    <?php endif; ?>
                <?php if($_GET["page"] < 1): ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="?page=1">Previous</a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo e($_GET["page"] - 1); ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] > $pages): ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="?page=<?php echo e($_GET["page"]=$pages); ?>">Next</a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] < $pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo e($_GET["page"] + 1); ?>">Next</a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] < $pages): ?>
                    <li class="page-item" >
                        <a class="page-link" href="?page=<?php echo e($pages); ?>" > >> </a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] === $pages): ?>
                    <li class="page-item" disabled>
                        <a class="page-link" href="?page=<?php echo e($pages); ?>" > >> </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//users.blade.php ENDPATH**/ ?>