<script setup>
import { ref, onMounted, defineExpose } from 'vue'
import TaskModal from './TaskModal.vue'
import TaskList from './TaskList.vue'
import { useTaskStore } from '../stores/taskStore'

const showModal = ref(false)
const selectedTask = ref(null)
const taskStore = useTaskStore()

function openModal(task = null) {
  selectedTask.value = task ? { ...task } : null // evita reatividade residual
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
  closeModal()
}

async function handleDeleteTask(taskId) {
  try {
    taskStore.loading = true
    await taskStore.deleteTask(taskId)
    await taskStore.fetchTasks()
  } catch (err) {
    alert('Erro ao excluir a tarefa. Tente novamente.')
    console.error(err)
  } finally {
    taskStore.loading = false
  }
}

async function handleToggleComplete(task) {
  await taskStore.toggleTask(task.id)
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
    @deleted="handleDeleteTask"
    @toggleComplete="handleToggleComplete"
  />

  <TaskModal
    :show="showModal"
    :task="selectedTask"
    @close="closeModal"
    @save="saveTask"
  />
</template>
