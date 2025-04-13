<template>
    <div class="register-container">
      <h2>Create Your Account</h2>
      
      <form @submit.prevent="handleSubmit" class="register-form">
        <div class="form-group">
          <label for="name">Full Name</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            :class="{ 'error': errors.name }"
          />
          <span class="error-message" v-if="errors.name">{{ errors.name }}</span>
        </div>
        
        <div class="form-group">
          <label for="email">Email Address</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            :class="{ 'error': errors.email }"
          />
          <span class="error-message" v-if="errors.email">{{ errors.email }}</span>
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            minlength="8"
            :class="{ 'error': errors.password }"
          />
          <span class="error-message" v-if="errors.password">{{ errors.password }}</span>
        </div>
        
        <div class="form-group">
          <label for="password_confirmation">Confirm Password</label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            required
            :class="{ 'error': errors.password_confirmation }"
          />
        </div>
        
        <button type="submit" :disabled="isSubmitting" class="submit-btn">
          {{ isSubmitting ? 'Registering...' : 'Register' }}
        </button>
        
        <div v-if="successMessage" class="success-message">
          {{ successMessage }}
          <p v-if="processingTasks">We're preparing your account. You'll receive a welcome email shortly.</p>
        </div>
        
        <div v-if="errorMessage" class="error-message">
          {{ errorMessage }}
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import axios from 'axios';
  
  export default {
    setup() {
      const form = ref({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      });
      
      const errors = ref({});
      const isSubmitting = ref(false);
      const successMessage = ref('');
      const errorMessage = ref('');
      const processingTasks = ref(false);
  
      const handleSubmit = async () => {
        isSubmitting.value = true;
        errors.value = {};
        errorMessage.value = '';
        
        try {
          const response = await axios.post('/api/register', form.value);
          
          successMessage.value = 'Registration successful!';
          processingTasks.value = true;
          
          // Reset form
          form.value = {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
          };
        } catch (error) {
          if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors || {};
            errorMessage.value = 'Please fix the errors in the form.';
          } else {
            errorMessage.value = 'An error occurred during registration. Please try again.';
          }
        } finally {
          isSubmitting.value = false;
        }
      };
  
      return {
        form,
        errors,
        isSubmitting,
        successMessage,
        errorMessage,
        processingTasks,
        handleSubmit
      };
    }
  };
  </script>
  
  <style scoped>
  .register-container {
    max-width: 500px;
    margin: 0 auto;
    padding: 2rem;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  
  h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: #2c3e50;
  }
  
  .register-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  .form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }
  
  label {
    font-weight: 600;
    color: #2c3e50;
  }
  
  input {
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
  }
  
  input.error {
    border-color: #e74c3c;
  }
  
  .error-message {
    color: #e74c3c;
    font-size: 0.875rem;
  }
  
  .submit-btn {
    padding: 0.75rem;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
  }
  
  .submit-btn:hover {
    background: #2980b9;
  }
  
  .submit-btn:disabled {
    background: #95a5a6;
    cursor: not-allowed;
  }
  
  .success-message {
    margin-top: 1rem;
    padding: 1rem;
    background: #e8f8f5;
    border: 1px solid #2ecc71;
    border-radius: 4px;
    color: #27ae60;
    text-align: center;
  }
  
  .error-message {
    margin-top: 1rem;
    padding: 1rem;
    background: #fdeded;
    border: 1px solid #e74c3c;
    border-radius: 4px;
    color: #c0392b;
    text-align: center;
  }
  </style>