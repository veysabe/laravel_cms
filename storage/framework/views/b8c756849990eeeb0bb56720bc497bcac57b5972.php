<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div data-controller="checkbox"
         data-checkbox-indeterminate="<?php echo e($indeterminate); ?>">
        <?php if(isset($sendTrueOrFalse)): ?>
            <input hidden name="<?php echo e($attributes['name']); ?>" value="<?php echo e($attributes['novalue']); ?>">
            <div class="form-check">
                <input value="<?php echo e($attributes['yesvalue']); ?>"
                       <?php echo e($attributes); ?>

                       <?php if(isset($attributes['value']) && $attributes['value']): ?> checked <?php endif; ?>
                >
                <label class="form-check-label" for="<?php echo e($id); ?>"><?php echo e($placeholder ?? ''); ?></label>
            </div>
        <?php else: ?>
            <div class="form-check">
                <input <?php echo e($attributes); ?>

                       <?php if(isset($attributes['value']) && $attributes['value'] && (!isset($attributes['checked']) || $attributes['checked'] !== false)): ?> checked <?php endif; ?>
                >
                <label class="form-check-label" for="<?php echo e($id); ?>"><?php echo e($placeholder ?? ''); ?></label>
            </div>
        <?php endif; ?>
    </div>
<?php if (isset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d)): ?>
<?php $component = $__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d; ?>
<?php unset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH D:\work\afisha\vendor\orchid\platform\resources\views/fields/checkbox.blade.php ENDPATH**/ ?>