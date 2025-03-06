import { CheckCircleIcon, ClockIcon, PlayCircleIcon, QuestionMarkCircleIcon, XCircleIcon } from '@heroicons/vue/24/outline';
import { h } from 'vue';

export const columns: ColumnDef<Payment>[] = [
    {
        accessorKey: 'title',
        header: () => h('div', { class: 'text-left' }, 'Title'),
        cell: ({ row }: any) => {
            const title = row.getValue('title');
            return h('div', { class: 'text-left font-medium' }, title);
        },
    },
    {
        accessorKey: 'description',
        header: () => h('div', { class: 'text-left' }, 'Description'),
        cell: ({ row }: any) => {
            const description = row.getValue('description') || '. . .';
            return h('div', { class: 'text-left font-medium' }, description);
        },
        meta: {
            className: 'hidden md:table-cell',
        },
    },
    {
        accessorKey: 'status',
        header: () => h('div', { class: 'text-left' }, 'Status'),
        cell: ({ row }: any) => {
            const status = row.getValue('status');
            const capitalisedStatus = status[0].toUpperCase() + status.slice(1);
            let icon;

            switch (status) {
                case 'done':
                    icon = h(CheckCircleIcon, { class: 'w-5 h-5 text-gray-500' });
                    break;
                case 'in progress':
                    icon = h(ClockIcon, { class: 'w-5 h-5 text-gray-500' });
                    break;
                case 'todo':
                    icon = h(PlayCircleIcon, { class: 'w-5 h-5 text-gray-500' });
                    break;
                case 'cancelled':
                    icon = h(XCircleIcon, { class: 'w-5 h-5 text-gray-500' });
                    break;
                default:
                    icon = h(QuestionMarkCircleIcon, { class: 'w-5 h-5 text-gray-500' });
                    break;
            }

            return h('div', { class: 'flex items-center space-x-2' }, [icon, h('span', { class: 'text-left font-medium' }, capitalisedStatus)]);
        },
    },
    {
        accessorKey: 'priority',
        header: () => h('div', { class: 'text-left' }, 'Priority'),
        cell: ({ row }: any) => {
            const priority = row.getValue('priority');
            const capitalisedPriority = priority[0].toUpperCase() + priority.slice(1);
            return h('div', { class: 'text-left font-medium' }, capitalisedPriority);
        },
        meta: {
            className: 'hidden md:table-cell',
        },
    },
    {
        accessorKey: 'actions',
        header: () => h('div', { class: 'text-left' }, 'Actions'),
    },
];
