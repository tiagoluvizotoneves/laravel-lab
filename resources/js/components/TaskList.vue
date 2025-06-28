<script setup>
import { defineProps, defineEmits } from 'vue'
import { format } from 'date-fns'

const props = defineProps({
  tasks: Array
})

const emit = defineEmits(['edit', 'deleted'])

function formatDate(date) {
  if (!date) return 'Sem data'
  try {
    return format(new Date(date), 'dd/MM/yyyy')
  } catch {
    return 'Data inválida'
  }
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
          >
            <label class="w-checkbox checkbox-field">
              <input
                type="checkbox"
                class="w-checkbox-input w-checkbox-input--inputType-custom checkbox margin-right-10"
                :checked="task.finalizado"
                disabled
              />
              <span class="checkbox-label w-form-label">
                {{ task.nome }}
              </span>
            </label>

            <div class="date-button margin-left-40">
              <div>{{ formatDate(task.data_limite) }}</div>
            </div>

            <div class="task-details" v-if="task.descricao">
              <div>{{ task.descricao }}</div>
            </div>

            <div class="remove-task" style="display: flex; gap: 8px;">
              <!-- Botão editar -->
              <div class="button outlined rounded small" @click="emit('edit', task)">
                <div class="icon w-embed">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5Z"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </div>
              </div>

              <!-- Botão deletar -->
              <div class="button outlined rounded small" @click="emit('deleted', task)">
                <div class="icon w-embed">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 6V5.2C16 4.08 16 3.52 15.78 3.09C15.59 2.71 15.28 2.41 14.91 2.22C14.48 2 13.92 2 12.8 2H11.2C10.08 2 9.52 2 9.09 2.22C8.71 2.41 8.41 2.71 8.22 3.09C8 3.52 8 4.08 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.88 19 19.72 18.67 20.36C18.38 20.93 17.93 21.39 17.36 21.67C16.72 22 15.88 22 14.2 22H9.8C8.12 22 7.28 22 6.64 21.67C6.07 21.39 5.61 20.93 5.33 20.36C5 19.72 5 18.88 5 17.2V6"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
