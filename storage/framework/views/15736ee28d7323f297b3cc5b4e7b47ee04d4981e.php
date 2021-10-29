<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div class="simplemde-wrapper" data-controller="simplemde"
         data-simplemde-text-value='<?php echo json_encode($attributes['value'], 15, 512) ?>'>
        <textarea <?php echo e($attributes); ?>></textarea>
        <input class="d-none upload" type="file" data-action="simplemde#upload">
    </div>
<?php if (isset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d)): ?>
<?php $component = $__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d; ?>
<?php unset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH D:\work\afisha\vendor\orchid\platform\resources\views/fields/simplemde.blade.php ENDPATH**/ ?>