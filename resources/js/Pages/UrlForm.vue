<template>
  <div class="min-h-screen bg-gray-100 flex flex-col justify-center items-center p-4">
    <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-6">
      <h1 class="text-center text-3xl font-bold text-gray-800 mb-6">URL Shortener</h1>
      <form @submit.prevent="submitUrl" class="space-y-4">
        <div>
          <input
            type="text"
            v-model="form.original_url"
            placeholder="Paste your long URL here"
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500 transition-colors"
            required
          />
          <div v-if="errors.original_url" class="text-red-500 text-sm">
            {{ errors.original_url }}
          </div>
        </div>
        <button
          type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded focus:outline-none shadow-lg transition-colors"
        >
          Shorten URL
        </button>
      </form>
      <ul v-if="urls.length > 0" class="mt-6">
        <li v-for="url in urls" :key="url.id" class="bg-gray-50 rounded-lg p-3 shadow mb-4">
          <a :href="'/default/' + url.short_url" target="_blank" class="block text-blue-500 hover:text-blue-700 truncate"  :title="domain + '/default/' + url.short_url">
            Shortened: {{ domain + '/default/' + url.short_url }}
          </a>
          <div class="text-sm text-gray-600 mt-2 truncate" :title="url.original_url">
            Original: {{ url.original_url }}
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { ref, reactive, watchEffect } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    urls: Array,
    domain: String,
    errors: Object,
  },
  setup(props) {
    const form = reactive({ original_url: '' });
    const errors = reactive({ original_url: null });

    watchEffect(() => {
      if (props.errors && props.errors.original_url) {
        errors.original_url = props.errors.original_url;
      }
    });

    function submitUrl() {
      Inertia.post('/urls', form, {
        onSuccess: () => {
          form.original_url = ''; // Reset form after submission
        },
        onError: error => {
          if (error.response && error.response.data && error.response.data.errors) {
            Object.assign(errors, error.response.data.errors);
          }
        }
      });
    }

    return {
      form,
      submitUrl,
      errors
    };
  }
}
</script>
