<!-- Students.vue -->
<script setup lang="ts">
import { ref, onMounted, h } from 'vue'
import axios from 'axios'
import {
  getCoreRowModel,
  useVueTable,
  FlexRender,
  type ColumnDef,
} from '@tanstack/vue-table'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StudentForm from '@/Pages/StudentForm.vue';
import DeleteConfirmation from '@/Pages/DeleteConfirmation.vue';
import { Head } from '@inertiajs/vue3';
import { route } from 'vendor/tightenco/ziggy/src/js';

type Student = {
  id: number
  name: string
  email: string
  phone: string
  address: string
  dob: string         
  class_id: number
  section_id: number
  class: {
    id: number
    name: string
  }
  section: {
    id: number
    name: string
  }
}

type Pagination = {
  current_page: number
  last_page: number
  per_page: number
  total: number
  links: Array<{
    url: string | null
    label: string    
    active: boolean
  }>
}

const students = ref<Student[]>([])
const isLoading = ref(false)
const showStudentModal = ref(false)
const showDeleteModal = ref(false)
const isEditing = ref(false)
const currentStudent = ref<Partial<Student>>({})
const pagination = ref<Pagination>({
  current_page: 1,
  last_page: 1,
  per_page: 5,
  total: 0,
  links: []
})

const fetchStudents = async (page = 1) => {
  isLoading.value = true
  try {
    const response = await axios.get(route('students.index'), {
      params: {
        page,
        per_page: pagination.value.per_page
      }
    })
    
    students.value = response.data.data
    pagination.value = {
      current_page: response.data.current_page,
      last_page: response.data.last_page,
      per_page: response.data.per_page,
      total: response.data.total,
      links: response.data.links
    }
  } catch (error) {
    console.error('Error fetching students:', error)
  } finally {
    isLoading.value = false
  }
}

const openAddStudent = () => {
  currentStudent.value = {
    name: '',
    email: '',
    phone: '',
    address: '',
    dob: '',
    class_id: null,
    section_id: null
  }
  isEditing.value = false
  showStudentModal.value = true
}

const openEditStudent = (student: Student) => {
  currentStudent.value = { ...student }
  isEditing.value = true
  showStudentModal.value = true
}

const saveStudent = async (formData: any) => {
  try {
    if (isEditing.value) {
      await axios.put(route('students.update', currentStudent.value.id), formData)
    } else {
      await axios.post(route('students.store'), formData)
    }
    showStudentModal.value = false
    fetchStudents(pagination.value.current_page)
  } catch (error) {
    console.error('Error saving student:', error)
  }
}

const confirmDelete = async () => {
  try {
    await axios.delete(route('students.destroy', currentStudent.value.id))
    showDeleteModal.value = false
    fetchStudents(pagination.value.current_page)
  } catch (error) {
    console.error('Error deleting student:', error)
  }
}

const deleteStudent = (student: Student) => {
  currentStudent.value = { ...student }
  showDeleteModal.value = true
}

const changePage = (page: number) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    fetchStudents(page)
  }
}

onMounted(() => {
  fetchStudents()
})

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
    accessorKey: 'phone',
    header: 'Phone',
  },
  {
    accessorKey: 'class.name',
    header: 'Class',
  },
  {
    accessorKey: 'section.name',
    header: 'Section',
  },
  {
    accessorKey: 'dob',
    header: 'Date of Birth',
    cell: ({ row }) => new Date(row.original.dob).toLocaleDateString(),
  },
  {
    id: 'actions',
    header: 'Actions',
    cell: ({ row }) => h('div', { class: 'flex space-x-2' }, [
      h('button', {
        onClick: () => openEditStudent(row.original),
        class: 'px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600'
      }, 'Edit'),
      h('button', {
        onClick: () => deleteStudent(row.original),
        class: 'px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600'
      }, 'Delete')
    ]),
  },
]

const table = useVueTable({
  get data() {
    return students.value
  },
  columns,
  getCoreRowModel: getCoreRowModel(),
})
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Students" />
    
    <div class="p-4">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Students</h2>
        <div class="flex space-x-2">
          <button 
            @click="openAddStudent"
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
          >
            Add Student
          </button>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="flex justify-center items-center p-8">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
      </div>

      <!-- Table -->
      <div v-else class="rounded-md border">
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

        <!-- Pagination -->
        <div class="flex items-center justify-between p-4 border-t">
          <div class="text-sm text-gray-700">
            Showing {{ (pagination.current_page - 1) * pagination.per_page + 1 }} to
            {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }}
            of {{ pagination.total }} records
          </div>
          
          <div class="flex items-center space-x-2">
            <button
              @click="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="px-3 py-1 border rounded hover:bg-gray-100"
              :class="{'opacity-50 cursor-not-allowed': pagination.current_page === 1}"
            >
              Previous
            </button>

            <select
              v-model="pagination.current_page"
              @change="changePage(pagination.current_page)"
              class="px-2 py-1 border rounded focus:ring-blue-500 focus:border-blue-500"
            >
              <option 
                v-for="page in Math.min(10, pagination.last_page)" 
                :key="page" 
                :value="page"
              >
                Page {{ page }}
              </option>
              <option 
                v-if="pagination.last_page > 10" 
                :value="pagination.last_page"
              >
                Page {{ pagination.last_page }} (Last)
              </option>
            </select>

            <button
              @click="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="px-3 py-1 border rounded hover:bg-gray-100"
              :class="{'opacity-50 cursor-not-allowed': pagination.current_page === pagination.last_page}"
            >
              Next
            </button>
          </div>
        </div>
      </div>

      <!-- Student Modal -->
      <div v-if="showStudentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
          <div class="p-6">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-medium">{{ isEditing ? 'Edit Student' : 'Add New Student' }}</h3>
              <button @click="showStudentModal = false" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <StudentForm 
              :student="currentStudent" 
              :isEditing="isEditing"
              @save="saveStudent"
              @cancel="showStudentModal = false"
            />
          </div>
        </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
          <DeleteConfirmation 
            @confirm="confirmDelete"
            @cancel="showDeleteModal = false"
          />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>