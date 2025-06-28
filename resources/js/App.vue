<template>
  <div class="content-tasks">
    <Appbar @open="openModal" />
    <TasksContainer ref="taskContainer" />
    <Footer />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Appbar from '@/components/Appbar.vue'
import Footer from '@/components/Footer.vue'
import TasksContainer from '@/components/TasksContainer.vue'

const taskContainer = ref()

function openModal() {
  taskContainer.value?.openModal()
}
</script>
