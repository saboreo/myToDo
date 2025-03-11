<script setup lang="ts" generic="TData, TValue">
import Sheet from '@/components/tasks/Sheet.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ChevronLeftIcon, EllipsisHorizontalIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import { Inertia } from '@inertiajs/inertia';
import { FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table';
import { h, ref, watch } from 'vue';
import { columns } from './columns';

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[];
    data: {
        data: TData[];
        links: any[];
        current_page: number;
        per_page: number;
        last_page: number;
        total: number;
    };
}>();

const pageIndex = ref(props.data.current_page - 1);
const pageSize = ref(props.data.per_page);

watch(
    () => props.data.current_page,
    (newPage) => {
        pageIndex.value = newPage - 1;
    },
);

const showCreateSheet = ref(false);
const handleCreate = () => {
    showCreateSheet.value = true;
};

const showSheet = ref(false);
const selectedTask = ref(null);

const handleEdit = (task) => {
    selectedTask.value = task;
    showSheet.value = true;
};

const showSheetDelete = ref(false);

const handleDelete = (task) => {
    selectedTask.value = task;
    showSheetDelete.value = true;
};

const deleteTask = () => {
    if (selectedTask.value) {
        Inertia.delete(route('tasks.destroy', selectedTask.value.id), {
            preserveState: true,
            onSuccess: () => {
                showSheetDelete.value = false;
                selectedTask.value = null;
            },
        });
    }
};

// Structure the columns with handlers for actions.
const columnsWithHandlers = props.columns.map((column) => {
    if (column.accessorKey === 'actions') {
        return {
            ...column,
            cell: ({ row }: any) => {
                return h(
                    DropdownMenu,
                    {},
                    {
                        default: () => [
                            h(
                                DropdownMenuTrigger,
                                {},
                                {
                                    default: () => h(EllipsisHorizontalIcon, { class: 'w-5 h-5 text-gray-500 cursor-pointer' }),
                                },
                            ),
                            h(
                                DropdownMenuContent,
                                {},
                                {
                                    default: () => [
                                        h(DropdownMenuItem, { onClick: () => handleEdit(row.original) }, { default: () => 'Edit' }),
                                        h(DropdownMenuSeparator),
                                        h(DropdownMenuItem, { onClick: () => handleDelete(row.original) }, { default: () => 'Delete' }),
                                    ],
                                },
                            ),
                        ],
                    },
                );
            },
        };
    }
    return column;
});

const table = useVueTable({
    get data() {
        return props.data.data;
    },
    get columns() {
        return columnsWithHandlers;
    },
    getCoreRowModel: getCoreRowModel(),
    state: {
        pagination: {
            pageIndex: pageIndex.value,
            pageSize: pageSize.value,
        },
    },
});

const handlePagination = (newPage: number) => {
    if (newPage !== pageIndex.value) {
        pageIndex.value = newPage;
        Inertia.get(route(route().current()), { page: newPage + 1, per_page: pageSize.value }, { preserveState: true });
    }
};
</script>

<template>
    <div class="flex h-full flex-1 flex-col gap-4">
        <div>
            <div class="mb-4 flex justify-end">
                <Button variant="outline" @click="handleCreate" class="text-sm"> <PlusCircleIcon class="mr-1 h-4 w-4" /> Add </Button>
            </div>

            <!-- Table wrapper with responsive classes -->
            <div class="overflow-x-auto rounded-md border shadow-sm">
                <Table class="w-full min-w-[400px]">
                    <TableHeader>
                        <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                            <TableHead
                                v-for="header in headerGroup.headers"
                                :key="header.id"
                                :class="[header.column.columnDef.meta?.className, 'px-2 py-2 text-sm']"
                            >
                                <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="table.getRowModel().rows?.length">
                            <TableRow v-for="row in table.getRowModel().rows" :key="row.id">
                                <TableCell
                                    v-for="cell in row.getVisibleCells()"
                                    :key="cell.id"
                                    :class="[cell.column.columnDef.meta?.className, 'px-2 py-2 text-sm']"
                                >
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                        </template>
                        <template v-else>
                            <TableRow>
                                <TableCell :colspan="columns.length" class="h-24 text-center"> No results. </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </div>
        </div>
        <div>
            <div class="flex items-center justify-between space-x-2 p-3 text-sm">
                <div class="flex items-center space-x-2 text-gray-500">
                    <span>{{ Math.min((pageIndex + 1) * pageSize, props.data.total) }} of {{ props.data.total }} results</span>
                    <span>|</span>
                    <span>Page {{ pageIndex + 1 }} of {{ props.data.last_page }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <Button variant="outline" size="sm" :disabled="pageIndex === 0" @click="handlePagination(pageIndex - 1)">
                        <ChevronLeftIcon />
                    </Button>
                    <Button variant="outline" size="sm" :disabled="pageIndex + 1 === props.data.last_page" @click="handlePagination(pageIndex + 1)">
                        <ChevronLeftIcon class="rotate-180 transform" />
                    </Button>
                </div>
            </div>

            <!-- Create task -->
            <Sheet :isOpen="showCreateSheet" :isCreate="true" @close="showCreateSheet = false" />

            <!-- View/Edit task -->
            <Sheet :task="selectedTask" :isOpen="showSheet" :isCreate="false" @close="showSheet = false" />

            <!-- Delete task -->
            <Dialog v-model:open="showSheetDelete" @close="showSheetDelete = false">
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Delete task</DialogTitle>
                        <DialogDescription> Are you sure you want to delete this task? </DialogDescription>
                    </DialogHeader>

                    <DialogFooter class="flex-col gap-2 sm:flex-row">
                        <Button variant="outline" @click="showSheetDelete = false"> Cancel </Button>
                        <Button @click="deleteTask"> Delete </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    </div>
</template>
