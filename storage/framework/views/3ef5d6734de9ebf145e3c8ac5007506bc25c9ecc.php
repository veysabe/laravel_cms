<?php $__env->startSection('title', '404'); ?>
<?php $__env->startSection('description', __("You requested a page that doesn't exist.")); ?>

<?php $__env->startSection('content'); ?>

    <div class="container p-md-5 layout">
        <div class="display-1 text-muted mb-5 mt-sm-5 mt-0">
            <?php if (isset($component)) { $__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc = $component; } ?>
<?php $component = $__env->getContainer()->make(Orchid\Icons\IconComponent::class, ['path' => 'bug']); ?>
<?php $component->withName('orchid-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc)): ?>
<?php $component = $__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc; ?>
<?php unset($__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
            404
        </div>
        <h1 class="h2 mb-3"><?php echo e(__("You requested a page that doesn't exist.")); ?></h1>
        <p class="h4 text-muted font-weight-normal mb-7"><?php echo e(__("You may have' entered an address that doesn't exist or that the link you have requested doesn't work (anymore).")); ?></p>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('platform::dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\afisha\vendor\orchid\platform\resources\views/errors/404.blade.php ENDPATH**/ ?>