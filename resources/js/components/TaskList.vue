<script setup>
import { defineProps, defineEmits, ref } from 'vue'

const props = defineProps({
  tasks: {
    type: Array,
    required: true
  }
})

const emit = defineEmits(['edit', 'deleted', 'toggleComplete'])

const handleClick = (task) => emit('edit', task)
const handleDelete = (task) => {
  if (confirm(`Tem certeza que deseja excluir a tarefa "${task.nome}"?`)) {
    emit('deleted', task.id)
  }
}
const toggleComplete = (task) => emit('toggleComplete', task)

const getRelativeDateLabel = (dateStr) => {
  if (!dateStr) return '-'
  const today = new Date()
  const target = new Date(dateStr)

  today.setHours(0, 0, 0, 0)
  target.setHours(0, 0, 0, 0)

  const diffDays = Math.floor((target - today) / (1000 * 60 * 60 * 24))

  if (diffDays === -1) return 'Ontem'
  if (diffDays === 0) return 'Hoje'
  if (diffDays === 1) return 'Amanhã'

  const options = { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' }
  return target.toLocaleDateString('pt-BR', options)
    .replace(/^./, str => str.toUpperCase())
    .replace(',', ', dia')
}

const isOverdue = (task) => {
  if (!task.data_limite || task.finalizado) return false
  const today = new Date()
  const target = new Date(task.data_limite)
  today.setHours(0, 0, 0, 0)
  target.setHours(0, 0, 0, 0)
  return target < today
}
</script>

<template>
  <div class="tasks">
    <div class="form-fields no-space-top w-form">
      <form class="form">
        <div class="block-tasks">
          <div
            v-for="task in tasks"
            :key="task.id"
            class="task"
            @click="handleClick(task)"
          >
            <label class="w-checkbox checkbox-field" @click.stop>
              <div
                class="w-checkbox-input w-checkbox-input--inputType-custom checkbox margin-right-10"
                :class="{ 'w--redirected-checked': task.finalizado }"
              ></div>
              <input
                type="checkbox"
                style="opacity:0;position:absolute;z-index:-1"
                :checked="task.finalizado"
                @change="toggleComplete(task)"
              />
              <span class="checkbox-label w-form-label" :class="{ checked: task.finalizado }">
                {{ task.nome }}
              </span>
            </label>

            <div class="date-button margin-left-40">
              <div>
                {{ getRelativeDateLabel(task.data_limite) }}
                <span v-if="isOverdue(task)" class="error-message"> – Atrasada</span>
              </div>
            </div>

            <div class="remove-task" style="display: flex; opacity: 1;" @click.stop>
              <div class="button outlined rounded small" @click="handleDelete(task)">
                <div class="icon w-embed">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M16 6V5.2C16 4.08 16 3.52 15.78 3.09C15.59 2.71 15.28 2.41 14.91 2.22C14.48 2 13.92 2 12.8 2H11.2C10.08 2 9.52 2 9.09 2.22C8.71 2.41 8.41 2.71 8.22 3.09C8 3.52 8 4.08 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.88 19 19.72 18.67 20.36C18.38 20.93 17.93 21.39 17.36 21.67C16.72 22 15.88 22 14.2 22H9.8C8.12 22 7.28 22 6.64 21.67C6.07 21.39 5.61 20.93 5.33 20.36C5 19.72 5 18.88 5 17.2V6"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
