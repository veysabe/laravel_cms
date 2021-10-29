<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div
        data-controller="code"
        data-code-language="<?php echo e($language); ?>"
        data-code-line-numbers="<?php echo e($lineNumbers); ?>"
        data-code-default-Theme="<?php echo e($defaultTheme); ?>"
    >
        <div class="code border position-relative w-100" style="min-height: <?php echo e($attributes['height']); ?>"></div>
        <input type="hidden" <?php echo e($attributes); ?>>
    </div>
<?php if (isset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d)): ?>
<?php $component = $__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d; ?>
<?php unset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH D:\work\afisha\vendor\orchid\platform\resources\views/fields/code.blade.php ENDPATH**/ ?>