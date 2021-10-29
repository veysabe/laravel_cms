<div class="d-flex m-0 align-items-center p-3">
    <div class="dropdown w-75">
        <a href="#" class="nav-link p-0 d-flex align-items-center" data-bs-toggle="dropdown">
            <?php if($image = Auth::user()->presenter()->image()): ?>
                <span class="thumb-sm avatar me-3">
                        <img src="<?php echo e($image); ?>" class="b">
                </span>
            <?php endif; ?>
            <span class="d-block small">
                <span class="text-ellipsis text-white" style="max-width: 12em;"><?php echo e(Auth::user()->presenter()->title()); ?></span>
                <span class="text-muted d-block text-ellipsis"><?php echo e(Auth::user()->presenter()->subTitle()); ?></span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow bg-white">

            <?php if (! (Dashboard::isEmptyMenu(\Orchid\Platform\Dashboard::MENU_PROFILE))): ?>
                <?php echo Dashboard::renderMenu(\Orchid\Platform\Dashboard::MENU_PROFILE); ?>

                <div class="dropdown-divider"></div>
            <?php endif; ?>

            <?php if(\Orchid\Access\UserSwitch::isSwitch()): ?>
                <a href="#"
                   class="dropdown-item"
                   data-controller="form"
                   data-action="form#submitByForm"
                   data-form-id="return-original-user"
                >
                    <?php if (isset($component)) { $__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc = $component; } ?>
<?php $component = $__env->getContainer()->make(Orchid\Icons\IconComponent::class, ['path' => 'people','class' => 'me-2']); ?>
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
                    <span><?php echo e(__('Back to my account')); ?></span>
                </a>
                <form id="return-original-user"
                      class="hidden"
                      data-controller="form"
                      data-action="form#submit"
                      action="<?php echo e(route('platform.switch.logout')); ?>"
                      method="POST">
                    <?php echo csrf_field(); ?>
                </form>
            <?php endif; ?>

            <a href="<?php echo e(route('platform.logout')); ?>"
               class="dropdown-item"
               data-controller="form"
               data-action="form#submitByForm"
               data-form-id="logout-form"
               dusk="logout-button">
                <?php if (isset($component)) { $__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc = $component; } ?>
<?php $component = $__env->getContainer()->make(Orchid\Icons\IconComponent::class, ['path' => 'logout','class' => 'me-2']); ?>
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

                <span><?php echo e(__('Sign out')); ?></span>
            </a>
            <form id="logout-form"
                  class="hidden"
                  action="<?php echo e(route('platform.logout')); ?>"
                  method="POST"
                  data-controller="form"
                  data-action="form#submit"
            >
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalf4093eda0bf0de35dd0a10392941081555cf9d74 = $component; } ?>
<?php $component = $__env->getContainer()->make(Orchid\Platform\Components\Notification::class, []); ?>
<?php $component->withName('orchid-notification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalf4093eda0bf0de35dd0a10392941081555cf9d74)): ?>
<?php $component = $__componentOriginalf4093eda0bf0de35dd0a10392941081555cf9d74; ?>
<?php unset($__componentOriginalf4093eda0bf0de35dd0a10392941081555cf9d74); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
</div>
<?php /**PATH D:\work\afisha\vendor\orchid\platform\resources\views/partials/profile.blade.php ENDPATH**/ ?>