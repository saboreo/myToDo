<script setup lang="ts">
import { Toaster, useToast } from '@/components/ui/toast'; // Ensure the import is correct
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';

const page = usePage();
const { toast } = useToast();

const showToast = (type: 'success' | 'error', message: string) => {
    toast({
        description: message,
    });
};

interface Flash {
    success?: string;
    error?: string;
}

// Watch flash messages.
watch(
    () => page.props.flash as Flash,
    (flash) => {
        if (flash.success) {
            showToast('success', flash.success);
        }

        if (flash.error) {
            showToast('error', flash.error);
        }
    },
    { immediate: true },
);

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Toaster />
        <slot />
    </AppLayout>
</template>
