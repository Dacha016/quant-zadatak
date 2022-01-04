<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
<?php $__env->startSection("content"); ?>
    <?php if(($_SESSION["role"]==="moderator" && $result->userId === $_SESSION["id"]) || $_SESSION["role"]==="admin" || ($_SESSION["role"]==="user" && $result->userId === $_SESSION["id"]) ): ?>
        <form action="/profile/update/gallery/<?php echo e($result->galleryId); ?>" method="post" class="p-2 align-self-center" style="margin-left: 35vw; margin-top:20Vh; border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden"   >
            <h2 class="mb-2 pt-4" style="text-align:center">Update</h2>
            <h3 style="text-align:center"><?php echo e($result->name); ?></h3>
            <input type="hidden" name="galleryId" value="<?php echo e($result->galleryId); ?>">
            <input type="hidden" name="userId" value="<?php echo e($result->userId); ?>">
                <input type="hidden" name="userUsername" value="<?php echo e($result->userUsername); ?>">
            <input type="hidden" name = "page" value=<?php echo e($_GET["page"]); ?>>
            <div class="mb-3 pt-3 ">
                <label for="name" class="form-label" style="font-size:18px; margin-left:15px;">Name:</label>
                <input type="text" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="name" name="name" value="<?php echo e($result->name); ?>">
            </div>

            <div class="mb-3 pt-3 ">
                <label for="description" class="form-label" style="font-size:18px; margin-left:15px;">Description:</label>
                    <textarea type="text" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="description" name="description"><?php echo e($result->description); ?></textarea>
            </div>

            <div class="mb-3 pt-3 ">
                <label for="slug" class="form-label" style="font-size:18px; margin-left:15px;">Slug:</label>
                    <input type="text" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="slug" name="slug" value="<?php echo e($result->slug); ?>">
            </div>

            <div class="form-check mb-3 ml-3">
                <label class="form-check-label" for="hidden">
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
                <label class="form-check-label" for="hidden">
                    <?php if($result->hidden): ?>
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($result->hidden); ?> checked>
                    <?php endif; ?>
                    <?php if(!$result->hidden): ?>
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="<?php echo e($result->hidden); ?>">
                    <?php endif; ?>
                    <label >Nsfw</label>
                </label>
            </div>
            <div class="m-3">
                <button class="btn btn-secondary d-inline-block" type="submit"><a style="color: white" href="http://localhost/profile/users?page=<?php echo e($_GET['page']); ?>">Cancel</a></button>
                <button class="btn btn-success d-inline-block float-right" type="submit">Update</button>
            </div>
        </form>
    <?php endif; ?>
    <?php if(($_SESSION["role"]==="moderator" && $result->userId !== $_SESSION["id"])): ?>
        <form action="/profile/update/gallery/<?php echo e($result->galleryId); ?>" method="post" class="p-2 align-self-center" style="margin-left: 35vw; margin-top:20Vh; border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden"   >
            <h2 class="mb-2 pt-4" style="text-align:center">Update</h2>
            <h3 style="text-align:center"><?php echo e($result->name); ?></h3>
            <input type="hidden" name="galleryId" value="<?php echo e($result->galleryId); ?>">
            <input type="hidden" name="userId" value="<?php echo e($result->userId); ?>">
            <input type="hidden" name="userUsername" value="<?php echo e($result->userUsername); ?>">
            <input type="hidden" name="name" value="<?php echo e($result->name); ?>">
            <input type="hidden" name="description" value="<?php echo e($result->description); ?>">
            <input type="hidden" name="slug" value="<?php echo e($result->slug); ?>">
            <input type="hidden" name = "page" value=<?php echo e($_GET["page"]); ?>>
            <div class="form-check mb-3 ml-3">
                <label class="form-check-label" for="hidden">
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
                <label class="form-check-label" for="hidden">
                    <?php if($result->hidden): ?>
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($result->hidden); ?> checked>
                    <?php endif; ?>
                    <?php if(!$result->hidden): ?>
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="<?php echo e($result->hidden); ?>">
                    <?php endif; ?>
                    <label >Nsfw</label>
                </label>
            </div>
            <div class="m-3">
                <button class="btn btn-secondary d-inline-block" type="submit"><a style="color: white" href="http://localhost/profile/users?page=<?php echo e($_GET['page']); ?>">Cancel</a></button>
                <button class="btn btn-success d-inline-block float-right" type="submit">Update</button>
            </div>
        </form>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//updateGallery.blade.php ENDPATH**/ ?>