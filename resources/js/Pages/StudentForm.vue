
<template>
    <div class="student-form">
      <h2>Add New Student</h2>
      <form @submit.prevent="submitForm">
        <div class="form-row">
          <div class="form-group">
            <label>Name</label>
            <input v-model="form.name" type="text" placeholder="Student name">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input v-model="form.email" type="email" placeholder="Student email">
          </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label>Phone</label>
            <input v-model="form.phone" type="text" placeholder="Phone number">
          </div>
          <div class="form-group">
            <label>Date of Birth</label>
            <input v-model="form.dob" type="text" placeholder="dd-mm-yyyy">
          </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label>Class</label>
            <select v-model="form.class_id" @change="fetchSections">
              <option value="">Select Class</option>
              <option v-for="classItem in classes" :value="classItem.id">
                {{ classItem.name }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <label>Section</label>
            <select v-model="form.section_id" :disabled="!form.class_id">
              <option value="">Select Section</option>
              <option v-for="section in sections" :value="section.id">
                {{ section.name }}
              </option>
            </select>
          </div>
        </div>
  
        <div class="form-group">
          <label>Address</label>
          <textarea v-model="form.address" placeholder="Student address"></textarea>
        </div>
  
        <div class="form-actions">
          <button type="button" @click="resetForm">Cancel</button>
          <button type="submit">Save</button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
import { route } from '../../../vendor/tightenco/ziggy/src/js';

  export default {
    data() {
      return {
        form: {
          name: '',
          email: '',
          phone: '',
          dob: '',
          address: '',
          class_id: '',
          section_id: '',
        },
        classes: [],
        sections: [],
      }
    },
    async created() {
      await this.fetchClasses();
    },
    methods: {
      async fetchClasses() {
        try {
          const response = await axios.get(route('classes-with-sections'));
          this.classes = response.data;
        } catch (error) {
          console.error('Error fetching classes:', error);
        }
      },
      async fetchSections() {
        if (!this.form.class_id) {
          this.sections = [];
          return;
        }
        
        try {
          const selectedClass = this.classes.find(c => c.id == this.form.class_id);
          this.sections = selectedClass ? selectedClass.sections : [];
          this.form.section_id = ''; // Reset section when class changes
        } catch (error) {
          console.error('Error fetching sections:', error);
        }
      },
      async submitForm() {
        try {
          const response = await axios.post('/api/students', this.form);
          alert('Student created successfully!');
          this.resetForm();
        } catch (error) {
          if (error.response && error.response.data.errors) {
            alert('Please fix the errors in the form.');
            console.error('Validation errors:', error.response.data.errors);
          } else {
            alert('An error occurred while saving the student.');
            console.error('Error saving student:', error);
          }
        }
      },
      resetForm() {
        this.form = {
          name: '',
          email: '',
          phone: '',
          dob: '',
          address: '',
          class_id: '',
          section_id: '',
        };
        this.sections = [];
      },
    },
  }
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
  }
  
  .form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
  }
  
  .form-group {
    flex: 1;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  input, select, textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
  }
  
  textarea {
    min-height: 80px;
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
  }
  
  button[type="button"] {
    background: #f0f0f0;
  }
  
  button[type="submit"] {
    background: #4CAF50;
    color: white;
  }
  </style>