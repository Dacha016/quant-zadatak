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
                    <?php if($row->user_id === $_SESSION["id"]): ?>
                    <td style="margin: 0 auto; border: 1px solid black"><a href="/profile/galleries/<?php echo e($row->galleryId); ?>"><?php echo e($row->name); ?></a></td>
                    <?php endif; ?>
                    <?php if($row->user_id !== $_SESSION["id"]): ?>
                        <td style="margin: 0 auto; border: 1px solid black"><a href="/profile/users/<?php echo e($row->user_id); ?>/<?php echo e($row->galleryId); ?>"><?php echo e($row->name); ?></a></td>
                    <?php endif; ?>
                    <?php if($_SESSION["role"] === "admin" ): ?>
                        <form action="/profile/update/gallery/<?php echo e($row->galleryId); ?>" method="post" >
                            <input type="hidden" name="galleryId" value="<?php echo e($row->galleryId); ?>">
                            <input type="hidden" name="user_id" value="<?php echo e($row->user_id); ?>">
                            <td style="text-align: center; border: 1px solid black ">
                                <input name="description" value="<?php echo e($row->description); ?>">
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <input name="slug" value="<?php echo e($row->slug); ?>">
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <?php if($row->hidden): ?>
                                    <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($row->hidden); ?> checked>
                                <?php endif; ?>
                                <?php if(!$row->hidden): ?>
                                    <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="<?php echo e($row->hidden); ?>">
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <?php if($row->nsfw): ?>
                                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($row->nsfw); ?> checked>
                                <?php endif; ?>
                                <?php if(!$row->nsfw): ?>
                                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="<?php echo e($row->nsfw); ?>">
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </td>
                            <td>
                                <button class="btn btn-danger d-inline-block" type="submit">DELETE</button>
                            </td>
                        </form>
                    <?php endif; ?>
                    <?php if($_SESSION["role"] === "moderator" ): ?>
                        <form action="/profile/update/gallery/<?php echo e($row->galleryId); ?>" method="post" >
                            <input type="hidden" name="galleryId" value="<?php echo e($row->galleryId); ?>">
                            <input type="hidden" name="user_id" value="<?php echo e($row->user_id); ?>">
                            <?php if($row->user_id === $_SESSION["id"]): ?>
                                <td style="text-align: center; border: 1px solid black ">
                                    <input name="description" value="<?php echo e($row->description); ?>">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <input name="slug" value="<?php echo e($row->slug); ?>">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <?php if($row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($row->hidden); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="<?php echo e($row->hidden); ?>">
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <?php if($row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($row->nsfw); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="<?php echo e($row->nsfw); ?>">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger d-inline-block" type="submit">DELETE</button>
                                </td>
                            <?php endif; ?>
                            <?php if($row->user_id != $_SESSION["id"]): ?>
                                <td style="text-align: center; border: 1px solid black ">
                                    <p><?php echo e($row->description); ?></p>
                                    <input type="hidden" name="description" value="<?php echo e($row->description); ?>">
                                </td>

                                <td style="text-align: center; border: 1px solid black ">
                                    <p><?php echo e($row->slug); ?></p>
                                    <input type="hidden" name="description" value="<?php echo e($row->slug); ?>">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <?php if($row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($row->hidden); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="<?php echo e($row->hidden); ?>">
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <?php if($row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($row->nsfw); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="<?php echo e($row->nsfw); ?>">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </td>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                    <?php if($_SESSION["role"] === "user"): ?>
                        <form action="/profile/update/gallery/<?php echo e($row->galleryId); ?>" method="post" >
                            <input type="hidden" name="galleryId" value="<?php echo e($row->galleryId); ?>">
                            <input type="hidden" name="user_id" value="<?php echo e($row->user_id); ?>">
                            <?php if($row->user_id === $_SESSION["id"]): ?>
                                <td style="text-align: center; border: 1px solid black ">
                                    <input name="description" value="<?php echo e($row->description); ?>">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <input name="slug" value="<?php echo e($row->slug); ?>">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <?php if($row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value=<?php echo e($row->hidden); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->hidden): ?>
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="{$row->hidden}}">
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <?php if($row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value=<?php echo e($row->nsfw); ?> checked>
                                    <?php endif; ?>
                                    <?php if(!$row->nsfw): ?>
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="<?php echo e($row->nsfw); ?>">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger d-inline-block" type="submit">DELETE</button>
                                </td>
                            <?php endif; ?>
                            <?php if($row->user_id != $_SESSION["id"]): ?>
                                <td style="text-align: center; border: 1px solid black ">
                                    <p><?php echo e($row->description); ?></p>
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <p><?php echo e($row->description); ?></p>
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <p><?php echo e($row->hidden); ?></p>
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <p><?php echo e($row->nsfw); ?></p>
                                </td>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/quant-zadatak/resources/views//galleries.blade.php ENDPATH**/ ?>