<div class="mb-3">
    <?php if(isset($title)): ?>
        <legend class="text-black px-4 mb-0">
            <?php echo e(__($title)); ?>

        </legend>
    <?php endif; ?>
    <div class="row mb-2 g-3 g-mb-4">
        <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <small class="text-muted d-block mb-1"><?php echo e(__($key)); ?></small>
                    <p class="h3 text-black fw-light"><?php echo e($metric['keyValue']); ?>

                        <?php if(isset($metric['keyDiff']) && (float)$metric['keyDiff'] !== 0.0): ?>
                            <small class="small <?php echo e((float)$metric['keyDiff'] < 0 ? 'text-danger': 'text-success'); ?>">
                                <?php echo e($metric['keyDiff']); ?> %
                            </small>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH D:\work\afisha\vendor\orchid\platform\resources\views/layouts/metric.blade.php ENDPATH**/ ?>