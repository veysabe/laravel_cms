<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <table class="matrix table table-bordered border-right-0"
           data-controller="matrix"
           data-matrix-index="<?php echo e($index); ?>"
           data-matrix-rows="<?php echo e($maxRows); ?>"
           data-matrix-key-value="<?php echo e(var_export($keyValue)); ?>"
    >
        <thead>
        <tr>
            <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th scope="col" class="text-capitalize">
                    <?php echo e(is_int($key) ? $column : $key); ?>

                </th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
        </thead>
        <tbody>

        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('platform::partials.fields.matrixRow',['row' => $row, 'key' => $key], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <tr class="add-row">
            <th colspan="<?php echo e(count($columns)); ?>" class="text-center p-0">
                <a href="#" data-action="matrix#addRow" class="btn btn-block small text-muted">
                    <?php if (isset($component)) { $__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc = $component; } ?>
<?php $component = $__env->getContainer()->make(Orchid\Icons\IconComponent::class, ['path' => 'plus-alt']); ?>
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

                    <span><?php echo e(__('Add row')); ?></span>
                </a>
            </th>
        </tr>

        <template>
            <?php echo $__env->make('platform::partials.fields.matrixRow',['row' => [], 'key' => '{index}'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </template>
        </tbody>
    </table>
<?php if (isset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d)): ?>
<?php $component = $__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d; ?>
<?php unset($__componentOriginal022c3adc7a3ddf487615f02d89190e3aa95e3b2d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH D:\work\afisha\vendor\orchid\platform\resources\views/fields/matrix.blade.php ENDPATH**/ ?>