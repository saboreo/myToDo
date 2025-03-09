<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Sheet, SheetClose, SheetContent, SheetDescription, SheetFooter, SheetHeader, SheetTitle } from '@/components/ui/sheet';
import { useToast } from '@/components/ui/toast/use-toast';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import Textarea from '../ui/textarea/Textarea.vue';

const props = defineProps<{
    task?: {
        id?: number;
        title?: string;
        description?: string;
        status?: string;
        priority?: string;
    };
    isOpen: boolean;
    isCreate?: boolean;
}>();

const emit = defineEmits(['close']);

// Create a reactive form state
const form = ref({
    id: props.task?.id || undefined,
    title: props.task?.title || '',
    description: props.task?.description || '',
    status: props.task?.status || '',
    priority: props.task?.priority || '',
});

// Watch for changes in props.task to update form
watch(
    () => props.task,
    (newTask) => {
        if (newTask) {
            form.value = {
                id: newTask.id || undefined,
                title: newTask.title || '',
                description: newTask.description || '',
                status: newTask.status || '',
                priority: newTask.priority || '',
            };
        }
    },
    { deep: true },
);

const internalOpen = computed({
    get: () => props.isOpen,
    set: (value: boolean) => {
        if (!value) emit('close');
    },
});

const page = usePage();
const statuses = page.props.statuses;

const capitalise = (str: string) => str.charAt(0).toUpperCase() + str.slice(1);

const { toast } = useToast();
const errors = ref<{ [key: string]: string[] }>({});

const validateForm = (): boolean => {
    errors.value = {};

    if (!form.value.title?.trim()) {
        errors.value.title = ['Title is required'];
    }
    if (!form.value.status) {
        errors.value.status = ['Status is required'];
    }
    if (!form.value.priority) {
        errors.value.priority = ['Priority is required'];
    }

    return Object.keys(errors.value).length === 0;
};

const handleSubmit = () => {
    if (!validateForm()) {
        toast({
            variant: 'destructive',
            description: 'Please fill in all required fields.',
        });
        return;
    }

    const options = {
        onSuccess: () => emit('close'),
        onError: (backendErrors: { [key: string]: string[] }) => {
            errors.value = backendErrors;
        },
    };

    if (props.isCreate) {
        Inertia.post(route('tasks.store'), form.value, options);
    } else {
        Inertia.patch(route('tasks.update', form.value.id), form.value, options);
    }
};

const activeDropdown = ref<'status' | 'priority' | null>(null);
</script>

<template>
    <Sheet v-model:open="internalOpen">
        <SheetContent>
            <SheetHeader>
                <SheetTitle>{{ isCreate ? 'Create Task' : 'Edit Task' }}</SheetTitle>
                <SheetDescription>
                    {{ isCreate ? 'Add a new task to your list.' : 'Make changes to your task.' }}
                </SheetDescription>
            </SheetHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 gap-4">
                    <Label for="title" class="self-start pt-2 text-right"> Title <span class="text-destructive">*</span> </Label>
                    <div class="col-span-3 space-y-1">
                        <Input id="title" v-model="form.title" :class="{ 'border-destructive': errors.title }" />
                        <p v-if="errors.title" class="text-xs text-destructive">
                            {{ errors.title[0] }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <Label for="description" class="self-start pt-2 text-right"> Description </Label>
                    <Textarea id="description" v-model="form.description" class="col-span-3 min-h-[150px]" />
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <Label for="status" class="self-start pt-2 text-right"> Status <span class="text-destructive">*</span> </Label>
                    <div class="col-span-3 space-y-1">
                        <Select
                            v-model="form.status"
                            :open="activeDropdown === 'status'"
                            @update:open="(open) => (activeDropdown = open ? 'status' : null)"
                        >
                            <SelectTrigger :class="{ 'border-destructive': errors.status }">
                                <SelectValue placeholder="Select status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem v-for="status in statuses" :key="status" :value="status">
                                        {{ capitalise(status) }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <p v-if="errors.status" class="text-xs text-destructive">
                            {{ errors.status[0] }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <Label for="priority" class="self-start pt-2 text-right"> Priority <span class="text-destructive">*</span> </Label>
                    <div class="col-span-3 space-y-1">
                        <Select
                            v-model="form.priority"
                            :open="activeDropdown === 'priority'"
                            @update:open="(open) => (activeDropdown = open ? 'priority' : null)"
                        >
                            <SelectTrigger :class="{ 'border-destructive': errors.priority }">
                                <SelectValue placeholder="Select priority" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem value="low">Low</SelectItem>
                                    <SelectItem value="medium">Medium</SelectItem>
                                    <SelectItem value="high">High</SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <p v-if="errors.priority" class="text-xs text-destructive">
                            {{ errors.priority[0] }}
                        </p>
                    </div>
                </div>
            </div>
            <SheetFooter class="flex-col gap-2 sm:flex-row">
                <SheetClose asChild>
                    <Button variant="outline" @click="emit('close')">Cancel</Button>
                </SheetClose>
                <Button type="submit" @click="handleSubmit">
                    {{ isCreate ? 'Create' : 'Save changes' }}
                </Button>
            </SheetFooter>
        </SheetContent>
    </Sheet>
</template>
