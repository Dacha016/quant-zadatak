<?php $__env->startSection("content"); ?>
    <form action="/profile/updateAccount" method="post" class="p-2 align-self-center" style="margin:10px auto; margin-top:20Vh; border:black 1px solid;
   width:500px; background:white; border-radius: 15px; overflow:hidden">
        <h2 class="mb-5 pt-4" style="text-align:center">Update account</h2>
        <?php
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {?>
        <div class="mb-3 mt-3 b">
            <p><?php echo e($error); ?></p>
            <?php }?>
        </div>
        <div class="mb-3 mt-3 b">
            <label for="username" class="form-label" style="font-size:18px; margin-left:15px;">Username:</label>
            <input type="text" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="username" name="username" value="">
        </div>

        <div class="mb-3 mt-3">
            <label for="email" class="form-label" style="font-size:18px; margin-left:15px;">Email:</label>
            <input type="email" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="email" name="email" value="">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label" style="font-size:18px; margin-left:15px;">Password:</label>
            <input type="password" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" name="password" value="{">
        </div>

        <div class="mb-3">
            <label for="rPassword" class="form-label" style="font-size:18px; margin-left:15px;">Retype password:</label>
            <input type="password" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" name="rPassword">
        </div>

        <button type="submit" class="btn btn-primary" style="border-radius:10px; width:20%;float:right; margin-right:15px">Update</button>

    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//updateAccount.blade.php ENDPATH**/ ?>