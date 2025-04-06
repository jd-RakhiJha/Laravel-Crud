<script setup lang="ts">
import { ref, onMounted, h, computed } from 'vue'
import axios from 'axios'
import {
  getCoreRowModel,
  useVueTable,
  FlexRender,
  type ColumnDef,
} from '@tanstack/vue-table'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

type FilterCondition = {
  field: string
  operator: string
  value: string | number | boolean
}

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
const showFilterModal = ref(false)
const showStudentModal = ref(false)
const isEditing = ref(false)
const currentStudent = ref<Partial<Student>>({})
const filters = ref<FilterCondition[]>([])
const newFilter = ref<FilterCondition>({
  field: 'name',
  operator: '$eq',
  value: ''
})
const pagination = ref<Pagination>({
  current_page: 1,
  last_page: 1,
  per_page: 5,
  total: 0,
  links: []
})

// Available fields for filtering
const filterableFields = [
  { value: 'name', label: 'Name' },
  { value: 'email', label: 'Email' },
  { value: 'class.id', label: 'Class ID' },
  { value: 'section.id', label: 'Section ID' },
  { value: 'class.name', label: 'Class Name' },
  { value: 'section.name', label: 'Section Name' },
]

// Available operators
const filterOperators = [
  { value: '$eq', label: 'Equals' },
  { value: '$ne', label: 'Not Equals' },
  { value: '$contains', label: 'Contains' },
  { value: '$in', label: 'In (comma separated)' },
  { value: '$notIn', label: 'Not In (comma separated)' },
  { value: '$gt', label: 'Greater Than' },
  { value: '$lt', label: 'Less Than' },
]

const fetchStudents = async (page = 1) => {
  isLoading.value = true
  try {
    const params = {
      ...buildFilterParams(),
      page: page,
      per_page: pagination.value.per_page
    }
    
    const response = await axios.get(route('students.index'), {
      params,
      paramsSerializer: {
        indexes: null
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

const buildFilterParams = () => {
  const params: any = {}
  
  filters.value.forEach((filter, index) => {
    const fieldPath = `filters[${filter.field}]`
    const operatorPath = `${fieldPath}[${filter.operator}]`
    
    if (filter.operator === '$in' || filter.operator === '$notIn') {
      params[operatorPath] = filter.value.toString().split(',').map(item => item.trim())
    } else {
      params[operatorPath] = filter.value
    }
  })

  return params
}

const addFilter = () => {
  if (newFilter.value.field && newFilter.value.value) {
    filters.value.push({ ...newFilter.value })
    newFilter.value = {
      field: 'name',
      operator: '$eq',
      value: ''
    }
  }
}

const removeFilter = (index: number) => {
  filters.value.splice(index, 1)
}

const applyFilters = () => {
  fetchStudents()
  showFilterModal.value = false
}

const resetFilters = () => {
  filters.value = []
  fetchStudents()
  showFilterModal.value = false
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

const saveStudent = async () => {
  try {
    if (isEditing.value) {
      await axios.put(route('students.update', currentStudent.value.id), currentStudent.value)
    } else {
      await axios.post(route('students.store'), currentStudent.value)
    }
    showStudentModal.value = false
    fetchStudents(pagination.value.current_page)
  } catch (error) {
    console.error('Error saving student:', error)
  }
}

const deleteStudent = async (id: number) => {
  if (confirm('Are you sure you want to delete this student?')) {
    try {
      await axios.delete(route('students.destroy', id))
      fetchStudents(pagination.value.current_page)
    } catch (error) {
      console.error('Error deleting student:', error)
    }
  }
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
        onClick: () => deleteStudent(row.original.id),
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
              <button 
                @click="showFilterModal = true"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
              >
                Filter Students
              </button>
            </div>
          </div>

          <!-- Filter Modal -->
          <div v-if="showFilterModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
              <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                  <h3 class="text-lg font-medium">Filter Students</h3>
                  <button @click="showFilterModal = false" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>

                <div class="space-y-4">
                  <!-- Current Filters -->
                  <div v-if="filters.length > 0" class="space-y-2">
                    <div v-for="(filter, index) in filters" :key="index" class="flex items-center space-x-2 p-2 bg-gray-50 rounded">
                      <span class="font-medium">{{ filterableFields.find(f => f.value === filter.field)?.label || filter.field }}</span>
                      <span class="text-gray-600">{{ filterOperators.find(op => op.value === filter.operator)?.label || filter.operator }}</span>
                      <span class="font-semibold">{{ filter.value }}</span>
                      <button 
                        @click="removeFilter(index)"
                        class="ml-auto text-red-500 hover:text-red-700"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Add New Filter -->
                  <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-5">
                      <label class="block text-sm font-medium text-gray-700 mb-1">Field</label>
                      <select 
                        v-model="newFilter.field"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      >
                        <option v-for="field in filterableFields" :key="field.value" :value="field.value">
                          {{ field.label }}
                        </option>
                      </select>
                    </div>
                    <div class="col-span-3">
                      <label class="block text-sm font-medium text-gray-700 mb-1">Operator</label>
                      <select 
                        v-model="newFilter.operator"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      >
                        <option v-for="op in filterOperators" :key="op.value" :value="op.value">
                          {{ op.label }}
                        </option>
                      </select>
                    </div>
                    <div class="col-span-3">
                      <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                      <input
                        v-model="newFilter.value"
                        type="text"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter value"
                      >
                    </div>
                    <div class="col-span-1 flex items-end">
                      <button
                        @click="addFilter"
                        class="px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                      >
                        Add
                      </button>
                    </div>
                  </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                  <button
                    @click="resetFilters"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                  >
                    Reset All
                  </button>
                  <button
                    @click="applyFilters"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                  >
                    Apply Filters
                  </button>
                </div>
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input
                      v-model="currentStudent.name"
                      type="text"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      placeholder="Student name"
                    >
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                      v-model="currentStudent.email"
                      type="email"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      placeholder="Student email"
                    >
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input
                      v-model="currentStudent.phone"
                      type="text"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      placeholder="Phone number"
                    >
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input
                      v-model="currentStudent.dob"
                      type="date"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Class ID</label>
                    <input
                      v-model="currentStudent.class_id"
                      type="number"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      placeholder="Class ID"
                    >
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Section ID</label>
                    <input
                      v-model="currentStudent.section_id"
                      type="number"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      placeholder="Section ID"
                    >
                  </div>
                  <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea
                      v-model="currentStudent.address"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      placeholder="Student address"
                      rows="3"
                    ></textarea>
                  </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                  <button
                    @click="showStudentModal = false"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                  >
                    Cancel
                  </button>
                  <button
                    @click="saveStudent"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                  >
                    {{ isEditing ? 'Update' : 'Save' }}
                  </button>
                </div>
              </div>
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
                Showing page {{ pagination.current_page }} of {{ pagination.last_page }} (Total {{ pagination.total }} records)
              </div>
              <div class="flex space-x-2">
                <button
                  @click="changePage(1)"
                  :disabled="pagination.current_page === 1"
                  class="px-3 py-1 border rounded"
                  :class="{'opacity-50 cursor-not-allowed': pagination.current_page === 1}"
                >
                  First
                </button>
                <button
                  @click="changePage(pagination.current_page - 1)"
                  :disabled="pagination.current_page === 1"
                  class="px-3 py-1 border rounded"
                  :class="{'opacity-50 cursor-not-allowed': pagination.current_page === 1}"
                >
                  Previous
                </button>
                <template v-for="(link, index) in pagination.links" :key="index">
                  <button
                    v-if="link.label && !['&laquo; Previous', 'Next &raquo;'].includes(link.label)"
                    @click="changePage(parseInt(link.label))"
                    :disabled="link.active || !link.url"
                    class="px-3 py-1 border rounded"
                    :class="{
                      'bg-blue-500 text-white': link.active,
                      'opacity-50 cursor-not-allowed': !link.url
                    }"
                  >
                    {{ link.label }}
                  </button>
                </template>
                <button
                  @click="changePage(pagination.current_page + 1)"
                  :disabled="pagination.current_page === pagination.last_page"
                  class="px-3 py-1 border rounded"
                  :class="{'opacity-50 cursor-not-allowed': pagination.current_page === pagination.last_page}"
                >
                  Next
                </button>
                <button
                  @click="changePage(pagination.last_page)"
                  :disabled="pagination.current_page === pagination.last_page"
                  class="px-3 py-1 border rounded"
                  :class="{'opacity-50 cursor-not-allowed': pagination.current_page === pagination.last_page}"
                >
                  Last
                </button>
              </div>
            </div>
          </div>
        </div>
    </AuthenticatedLayout>
</template>