<?php
if(!isset($_SESSION["id"])) {
header("Location: http://localhost/home");
}
?>
<?php $__env->startSection("content"); ?>
    <h1 class="d-block " style="text-align:center">Galleries</h1>
    <div style="margin: 20px auto; max-width: 1000px;" >
        <table style="text-align: center;">
            <tr>
                <th style=" border: 1px solid black ">Name</th>
                <th style="border: 1px solid black">Description</th>
                <th style="border: 1px solid black">Slug</th>
                <th style="border: 1px solid black">Hidden</th>
                <th style="border: 1px solid black">Nsfw</th>
            </tr>
            <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php if($_SESSION["role"] === "admin"): ?>

                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/galleries/<?php echo e($row->galleryId); ?>"><?php echo e($row->name); ?></a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->description); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->slug); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->hidden); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->nsfw); ?></p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/profile/update/gallery/<?php echo e($row->galleryId); ?>?page=<?php echo e($_GET['page']); ?>"><i class="fas fa-pen"></i></a>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/delete/gallery/<?php echo e($row->galleryId); ?>?page=<?php echo e($_GET['page']); ?>"><i class="fas fa-trash"></i></a>
                            </button>
                        </td>
                    <?php endif; ?>
                    <?php if($row->userId === $_SESSION["id"] && $_SESSION["role"] === "moderator"): ?>

                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/galleries/<?php echo e($row->galleryId); ?>"><?php echo e($row->name); ?></a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->description); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->slug); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->hidden); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->nsfw); ?></p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/profile/update/gallery/<?php echo e($row->galleryId); ?>?page=<?php echo e($_GET['page']); ?>"><i class="fas fa-pen"></i></a>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/delete/gallery/<?php echo e($row->galleryId); ?>?page=<?php echo e($_GET['page']); ?>"><i class="fas fa-trash"></i></a>
                            </button>
                        </td>
                    <?php endif; ?>
                    <?php if($row->userId !== $_SESSION["id"] && $_SESSION["role"] === "moderator"): ?>
                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/users/<?php echo e($row->userId); ?>/<?php echo e($row->galleryId); ?>?page=0"><?php echo e($row->name); ?></a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->description); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->slug); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->hidden); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->nsfw); ?></p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/profile/update/gallery/<?php echo e($row->galleryId); ?>?page=<?php echo e($_GET['page']); ?>"><i class="fas fa-pen"></i></a>
                            </button>
                        </td>

                    <?php endif; ?>
                    <?php if($row->userId === $_SESSION["id"] && $_SESSION["role"] === "user"): ?>

                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/galleries/<?php echo e($row->galleryId); ?>"><?php echo e($row->name); ?></a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->description); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->slug); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->hidden); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->nsfw); ?></p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/profile/update/gallery/<?php echo e($row->galleryId); ?>?page=<?php echo e($_GET['page']); ?>"><i class="fas fa-pen"></i></a>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/delete/gallery/<?php echo e($row->galleryId); ?>?page=<?php echo e($_GET['page']); ?>"><i class="fas fa-trash"></i></a>
                            </button>
                        </td>
                    <?php endif; ?>
                    <?php if($row->userId !== $_SESSION["id"] && $_SESSION["role"] === "user"): ?>
                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/users/<?php echo e($row->userId); ?>/<?php echo e($row->galleryId); ?>"><?php echo e($row->name); ?></a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->description); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->slug); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->hidden); ?></p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p><?php echo e($row->nsfw); ?></p>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if($_GET["page"] > 0): ?>
                    <li class="page-item" >
                        <a class="page-link" href="?page=0" > << </a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] === 0): ?>
                    <li class="page-item" disabled>
                        <a class="page-link" href="?page=0" > << </a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] < 0): ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="?page=0">Previous</a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] > 0): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page= <?php echo e($_GET["page"] - 1); ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] > $pages): ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="?page= <?php echo e($_GET["page"]=$pages); ?>">Next</a>
                    </li>
                <?php endif; ?>
                <?php if($_GET["page"] < $pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page= <?php echo e($_GET["page"] + 1); ?>">Next</a>
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

<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//galleries.blade.php ENDPATH**/ ?>