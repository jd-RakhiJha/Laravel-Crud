<script setup lang="ts">
import { ref, h } from 'vue'
import {
  getCoreRowModel,
  useVueTable,
  FlexRender,
  type ColumnDef,
} from '@tanstack/vue-table'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

type Student = {
  id: string
  name: string
  email: string
  enrollmentDate: string
}

const students = ref<Student[]>([
  {
    id: '1',
    name: 'Alex Johnson',
    email: 'alex.johnson@example.com',
    enrollmentDate: '2023-09-15',
  },
  {
    id: '2',
    name: 'Maria Garcia',
    email: 'maria.garcia@example.com',
    enrollmentDate: '2023-08-22',
  },
  {
    id: '3',
    name: 'James Wilson',
    email: 'james.wilson@example.com',
    enrollmentDate: '2023-10-05',
  },
  {
    id: '4',
    name: 'Sarah Lee',
    email: 'sarah.lee@example.com',
    enrollmentDate: '2023-07-18',
  },
])

const columns: ColumnDef<Student>[] = [
  {
    accessorKey: 'name',
    header: 'Student Name',
    cell: ({ row }) => h('span', { class: 'font-medium' }, row.original.name),
  },
  {
    accessorKey: 'email',
    header: 'Email',
    cell: ({ row }) => h('a', { 
      href: `mailto:${row.original.email}`,
      class: 'text-blue-600 hover:underline'
    }, row.original.email),
  },
  {
    accessorKey: 'enrollmentDate',
    header: 'Enrollment Date',
    cell: ({ row }) => new Date(row.original.enrollmentDate).toLocaleDateString(),
  },
]

const table = useVueTable({
  data: students.value,
  columns,
  getCoreRowModel: getCoreRowModel(),
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="rounded-md border">
          <table class="w-full">
            <thead>
              <tr
                v-for="headerGroup in table.getHeaderGroups()"
                :key="headerGroup.id"
              >
                <th
                  v-for="header in headerGroup.headers"
                  :key="header.id"
                  class="h-10 px-4 text-left border-b font-medium text-gray-700 bg-gray-50"
                >
                  <div v-if="!header.isPlaceholder">
                    <FlexRender
                      :render="header.column.columnDef.header"
                      :props="header.getContext()"
                    />
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="row in table.getRowModel().rows"
                :key="row.id"
                class="border-b hover:bg-gray-50"
              >
                <td
                  v-for="cell in row.getVisibleCells()"
                  :key="cell.id"
                  class="p-4"
                >
                  <FlexRender
                    :render="cell.column.columnDef.cell"
                    :props="cell.getContext()"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
    </AuthenticatedLayout>
</template>