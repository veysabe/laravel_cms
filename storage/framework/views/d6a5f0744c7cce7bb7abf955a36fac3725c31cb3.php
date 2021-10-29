<div
    data-controller="tabs"
    data-tabs-slug="<?php echo e($templateSlug); ?>"
>
    <div class="nav-tabs-alt">
        <ul class="nav nav-tabs" role="tablist">
            <?php $__currentLoopData = $manyForms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item">
                    <a class="nav-link <?php if($loop->first): ?> active <?php endif; ?>"
                       data-action="tabs#setActiveTab"
                       data-bs-target="#tab-<?php echo e(\Illuminate\Support\Str::slug($name)); ?>"
                       id="button-tab-<?php echo e(\Illuminate\Support\Str::slug($name)); ?>"
                       role="tablist"
                       data-bs-toggle="tab">
                        <?php echo $name; ?>

                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!-- main content -->
    <section class="mb-3">
        <div class="no-border-xs">
            <div class="tab-content">
                <?php $__currentLoopData = $manyForms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $forms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div role="tabpanel" class="tab-pane <?php if($loop->first): ?> active <?php endif; ?>"
                         id="tab-<?php echo e(\Illuminate\Support\Str::slug($name)); ?>">
                            <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $form; ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <!-- / main content -->
</div>
<?php /**PATH D:\work\afisha\vendor\orchid\platform\resources\views/layouts/tabs.blade.php ENDPATH**/ ?>