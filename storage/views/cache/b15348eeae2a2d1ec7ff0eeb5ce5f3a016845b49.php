<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
<?php $__env->startSection("content"); ?>
    <form action="http://localhost/profile/update/users/<?php echo e($result->id); ?>" method="post" class="p-2 align-self-center" style="margin-left: 35vw; margin-top:20Vh; border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden"  >
        <h2 class="mb-2 pt-4" style="text-align:center">Update</h2>
        <h3 style="text-align:center"><?php echo e($result->username); ?></h3>
        <input type="hidden" name = "userId" value=<?php echo e($result->id); ?>>
        <input type="hidden" name = "username" value=<?php echo e($result->username); ?>>
        <input type="hidden" name = "page" value=<?php echo e($_GET["page"]); ?>>
        <div class="mb-3 pt-3 ">
            <label for="role" class="form-label" style="font-size:18px; margin-left:15px;">Role:</label>
            <input type="text" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="role" name="role" value="<?php echo e($result->role); ?>">
        </div>
        <div class="form-check mb-3 ml-3">
            <label class="form-check-label" for="nsfw">
                <?php if($result->nsfw): ?>
                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($result->nsfw); ?> checked>
                <?php endif; ?>
                <?php if(!$result->nsfw): ?>
                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="<?php echo e($result->nsfw); ?>">
                <?php endif; ?>
                    <label >Hidden</label>
            </label>
        </div>

        <div class="form-check ml-3 ">
            <label class="form-check-label" for="active">
                <?php if($result->active): ?>
                    <input class="form-check-input" type="checkbox" id="active" name="active" value=<?php echo e($result->active); ?> checked>
                <?php endif; ?>
                <?php if(!$result->active): ?>
                    <input class="form-check-input" type="checkbox" id="active" name="active" value="<?php echo e($result->active); ?>">
                <?php endif; ?>
                <label >Nsfw</label>
            </label>
        </div>
        <div class="m-3">
            <button class="btn btn-secondary d-inline-block" type="submit"><a style="color: white" href="http://localhost/profile/users?page=<?php echo e($_GET['page']); ?>">Cancel</a></button>
            <button class="btn btn-success d-inline-block float-right" type="submit">Update</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//updateUsers.blade.php ENDPATH**/ ?>