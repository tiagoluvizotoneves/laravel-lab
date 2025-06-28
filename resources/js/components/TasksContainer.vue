<script setup>
import { ref, onMounted, defineExpose } from 'vue'
import TaskModal from './TaskModal.vue'
import TaskList from './TaskList.vue'
import { useTaskStore } from '../stores/taskStore'

const showModal = ref(false)
const selectedTask = ref(null)
const taskStore = useTaskStore()

function openModal(task = null) {
  console.log('openModal chamado') // Testa se chegou aqui
  selectedTask.value = task
  showModal.value = true
}

function closeModal() {
  selectedTask.value = null
  showModal.value = false
}

async function saveTask(payload) {
  if (payload.id) {
    await taskStore.updateTask(payload.id, payload)
  } else {
    await taskStore.createTask(payload)
  }
}

defineExpose({ openModal })

onMounted(() => {
  taskStore.fetchTasks()
})
</script>

<template>
  <TaskList
    :tasks="taskStore.tasks"
    @edit="openModal"
    @deleted="taskStore.fetchTasks"
  />

  <TaskModal
    :show="showModal"
    :task="selectedTask"
    @close="closeModal"
    @save="saveTask"
  />
</template>
