import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';

// window.axios.defaults.baseURL = 'https://integral-lemming-lately.ngrok-free.app';
window.axios.defaults.baseURL = 'http://localhost:8000';

window.axios.interceptors.response.use(response => {
    if (response.status === 401 || response.status === 403 || response.status === 500) {
        window.location.href = '/login';
    }

   return response;
}, error => {
  if (error.response.status === 401 || error.response.status === 403 || error.response.status === 500) {
    window.location.href = '/login';
  }

  return error;
});
