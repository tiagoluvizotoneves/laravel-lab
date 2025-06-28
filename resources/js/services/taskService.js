import axios from 'axios';

const API_URL = '/api/tasks';

export default {
  getAll() {
    return axios.get(API_URL);
  },
  get(id) {
    return axios.get(`${API_URL}/${id}`);
  },
  create(data) {
    return axios.post(API_URL, data);
  },
  update(id, data) {
    return axios.put(`${API_URL}/${id}`, data);
  },
  toggle(id) {
    return axios.patch(`${API_URL}/${id}/toggle`);
  },
  remove(id) {
    return axios.delete(`${API_URL}/${id}`);
  }
};
