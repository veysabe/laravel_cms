<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div data-controller="radiobutton">
        <div class="btn-group btn-group-toggle p-0" data-toggle="buttons">

            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="btn btn-default <?php if($active($key, $value)): ?> active <?php endif; ?>"
                       data-action="click->radiobutton#checked"
                >
                    <input <?php echo e($attributes); ?>

                           <?php if($active($key, $value)): ?> checked <?php endif; ?>
                            value="<?php echo e($key); ?>"
                    ><?php echo e($option); ?></label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php if (isset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d)): ?>
<?php $component = $__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d; ?>
<?php unset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH D:\work\afisha\vendor\orchid\platform\resources\views/fields/radiobutton.blade.php ENDPATH**/ ?>