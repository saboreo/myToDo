<script setup lang="ts">
import { columns } from '@/components/tasks/columns';
import DataTable from '@/components/tasks/DataTable.vue';
import Tile from '@/components/ui/data-display/Tile.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    totalAllTasks: Number,
    totalInProgressTasks: Number,
    totalHighPriorityTasks: Number,
    tasks: Object,
    statuses: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Tile title="Total Tasks" :count="props.totalAllTasks" />
                <Tile title="In Progress" :count="props.totalInProgressTasks" />
                <Tile title="High Priority" :count="props.totalHighPriorityTasks" />
            </div>
            <div class="relative flex-1 rounded-xl border-sidebar-border/70 dark:border-sidebar-border">
                <div class="w-full">
                    <DataTable :columns="columns" :data="props.tasks" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
