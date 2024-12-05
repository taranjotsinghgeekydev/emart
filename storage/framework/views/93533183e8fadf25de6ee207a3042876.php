<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'isActive' => true,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'isActive' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'border-b border-zinc-200'])); ?>>
    <v-accordion
        is-active="<?php echo e($isActive); ?>"
        <?php echo e($attributes->except('class')); ?>

    >
        <?php if(isset($header)): ?>
            <template v-slot:header="{ toggle, isOpen }">
                <div
                    <?php echo e($header->attributes->merge(['class' => 'flex cursor-pointer select-none items-center justify-between p-4'])); ?>

                    role="button"
                    tabindex="0"
                    @click="toggle"
                >
                    <?php echo e($header); ?>


                    <span
                        :class="`${isOpen ? 'icon-arrow-up' : 'icon-arrow-down'} text-2xl`"
                        role="button"
                        aria-label="Toggle accordion"
                        tabindex="0"
                    ></span>
                </div>
            </template>
        <?php endif; ?>

        <?php if(isset($content)): ?>
            <template v-slot:content="{ isOpen }">
                <div
                    <?php echo e($content->attributes->merge(['class' => 'z-10 rounded-lg bg-white p-1.5'])); ?>

                    v-show="isOpen"
                >
                    <?php echo e($content); ?>

                </div>
            </template>
        <?php endif; ?>
    </v-accordion>
</div>

<?php if (! $__env->hasRenderedOnce('f8e0ddde-c66a-4ce0-acb7-67c5d92d773c')): $__env->markAsRenderedOnce('f8e0ddde-c66a-4ce0-acb7-67c5d92d773c');
$__env->startPush('scripts'); ?>
    <script
        type="text/x-template"
        id="v-accordion-template"
    >
        <div>
            <slot
                name="header"
                :toggle="toggle"
                :isOpen="isOpen"
            >
                <?php echo app('translator')->get('admin::app.components.accordion.default-content'); ?>
            </slot>

            <slot
                name="content"
                :isOpen="isOpen"
            >
                <?php echo app('translator')->get('admin::app.components.accordion.default-content'); ?>
            </slot>
        </div>
    </script>

    <script type="module">
        app.component('v-accordion', {
            template: '#v-accordion-template',

            props: [
                'isActive',
            ],

            data() {
                return {
                    isOpen: this.isActive,
                };
            },

            methods: {
                toggle() {
                    this.isOpen = ! this.isOpen;

                    this.$emit('toggle', { isActive: this.isOpen });
                },
            },
        });
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH /var/www/html/emart/packages/Webkul/Shop/src/Providers/../Resources/views/components/accordion/index.blade.php ENDPATH**/ ?>