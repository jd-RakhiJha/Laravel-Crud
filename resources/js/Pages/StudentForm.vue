<template>
  <div class="student-form">
    <h2>Add New Student</h2>
    <form @submit.prevent="submitForm">
      <div class="form-row">
        <div class="form-group">
          <label>Name <span class="required">*</span></label>
          <input v-model="form.name" type="text" placeholder="Student name" required>
          <span class="error" v-if="errors.name">{{ errors.name }}</span>
        </div>
        <div class="form-group">
          <label>Email <span class="required">*</span></label>
          <input v-model="form.email" type="email" placeholder="Student email" required>
          <span class="error" v-if="errors.email">{{ errors.email }}</span>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Phone</label>
          <input v-model="form.phone" type="tel" placeholder="Phone number">
          <span class="error" v-if="errors.phone">{{ errors.phone }}</span>
        </div>
        <div class="form-group">
          <label>Date of Birth</label>
          <input v-model="form.dob" type="date">
          <span class="error" v-if="errors.dob">{{ errors.dob }}</span>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Class <span class="required">*</span></label>
          <select v-model="form.class_id" @change="fetchSections" required>
            <option value="">Select Class</option>
            <option v-for="classItem in classes" :value="classItem.id">
              {{ classItem.name }}
            </option>
          </select>
          <span class="error" v-if="errors.class_id">{{ errors.class_id }}</span>
        </div>
        <div class="form-group">
          <label>Section <span class="required">*</span></label>
          <select v-model="form.section_id" :disabled="!form.class_id" required>
            <option value="">Select Section</option>
            <option v-for="section in sections" :value="section.id">
              {{ section.name }}
            </option>
          </select>
          <span class="error" v-if="errors.section_id">{{ errors.section_id }}</span>
        </div>
      </div>

      <div class="form-group">
        <label>Address</label>
        <textarea v-model="form.address" placeholder="Student address"></textarea>
      </div>

      <div class="form-actions">
        <button type="button" @click="resetForm">Cancel</button>
        <button type="submit" :disabled="isSubmitting">
          {{ isSubmitting ? 'Saving...' : 'Save' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { route } from 'ziggy-js'

interface FormData {
  name: string
  email: string
  phone: string
  dob: string
  address: string
  class_id: string | number
  section_id: string | number
}

interface ClassItem {
  id: number
  name: string
  sections: SectionItem[]
}

interface SectionItem {
  id: number
  name: string
}

interface FormErrors {
  name?: string
  email?: string
  phone?: string
  dob?: string
  class_id?: string
  section_id?: string
}

// Reactive state
const form = ref<FormData>({
  name: '',
  email: '',
  phone: '',
  dob: '',
  address: '',
  class_id: '',
  section_id: ''
})

const classes = ref<ClassItem[]>([])
const sections = ref<SectionItem[]>([])
const errors = ref<FormErrors>({})
const isSubmitting = ref(false)

// Methods
const validateForm = (): boolean => {
  errors.value = {}
  let isValid = true

  if (!form.value.name) {
    errors.value.name = 'Name is required'
    isValid = false
  }

  if (!form.value.email) {
    errors.value.email = 'Email is required'
    isValid = false
  } else if (!/^\S+@\S+\.\S+$/.test(form.value.email)) {
    errors.value.email = 'Email is invalid'
    isValid = false
  }

  if (!form.value.class_id) {
    errors.value.class_id = 'Class is required'
    isValid = false
  }

  if (!form.value.section_id) {
    errors.value.section_id = 'Section is required'
    isValid = false
  }

  return isValid
}

const fetchClasses = async () => {
  try {
    const response = await axios.get(route('classes-with-sections'))
    classes.value = response.data
  } catch (error) {
    console.error('Error fetching classes:', error)
    alert('Failed to load classes. Please try again.')
  }
}

const fetchSections = () => {
  if (!form.value.class_id) {
    sections.value = []
    form.value.section_id = ''
    return
  }
  
  const selectedClass = classes.value.find(c => c.id == form.value.class_id)
  sections.value = selectedClass ? selectedClass.sections : []
  form.value.section_id = ''
}

const submitForm = async () => {
  if (!validateForm()) return

  isSubmitting.value = true
  
  try {
    const response = await axios.post(route('students.store'), form.value)
    alert('Student created successfully!')
    resetForm()
  } catch (error: any) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
      alert('Please fix the form errors.')
    } else {
      alert('An error occurred while saving the student.')
      console.error('Error:', error)
    }
  } finally {
    isSubmitting.value = false
  }
}

const resetForm = () => {
  form.value = {
    name: '',
    email: '',
    phone: '',
    dob: '',
    address: '',
    class_id: '',
    section_id: ''
  }
  sections.value = []
  errors.value = {}
}

// Lifecycle hook
onMounted(async () => {
  await fetchClasses()
})
</script>

<style scoped>
.student-form {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h2 {
  margin-bottom: 20px;
  color: #333;
  text-align: center;
}

.form-row {
  display: flex;
  gap: 20px;
  margin-bottom: 15px;
}

.form-group {
  flex: 1;
  position: relative;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.required {
  color: #e53935;
}

input, select, textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
  font-family: inherit;
}

textarea {
  min-height: 80px;
  resize: vertical;
}

.error {
  color: #e53935;
  font-size: 0.8rem;
  display: block;
  margin-top: 4px;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
}

button {
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  transition: background-color 0.2s;
}

button[type="button"] {
  background: #f0f0f0;
}

button[type="button"]:hover {
  background: #e0e0e0;
}

button[type="submit"] {
  background: #4CAF50;
  color: white;
}

button[type="submit"]:hover {
  background: #43a047;
}

button[type="submit"]:disabled {
  background: #a5d6a7;
  cursor: not-allowed;
}
</style>