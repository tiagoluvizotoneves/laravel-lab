<template>
  <div
    class="modal-task"
    :style="{
      display: show ? 'flex' : 'none',
      opacity: show ? '1' : '0'
    }"
  >
    <div class="container-modal regular">
      <!-- Cabeçalho do modal -->
      <div class="top-modal">
        <h3>{{ task?.id ? 'Editar Tarefa' : 'Nova Tarefa' }}</h3>
        <div class="close-modal" @click="$emit('close')">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </div>
      </div>

      <!-- Conteúdo -->
      <div class="content-modal">
        <div class="form-group">
          <label for="nome">Nome</label>
          <input id="nome" v-model="form.nome" type="text" class="input" />
        </div>

        <div class="form-group">
          <label for="descricao">Descrição</label>
          <textarea id="descricao" v-model="form.descricao" rows="4" class="input"></textarea>
        </div>

        <div class="form-group">
          <label for="data_limite">Data Limite</label>
          <input id="data_limite" v-model="form.data_limite" type="date" class="input" />
        </div>

        <div class="form-group">
          <label class="checkbox-field">
            <input type="checkbox" v-model="form.finalizado" class="checkbox" />
            <span class="checkbox-label">Finalizado</span>
          </label>
        </div>
      </div>

      <!-- Rodapé -->
      <div class="bottom-modal flex-block-horizontal-right-align">
        <button class="button outlined margin-right-10" @click="$emit('close')">Cancelar</button>
        <button class="button" @click="save">Salvar</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { watch, reactive } from 'vue'

const props = defineProps({
  show: Boolean,
  task: Object
})

const emit = defineEmits(['close', 'save'])

const form = reactive({
  nome: '',
  descricao: '',
  data_limite: '',
  finalizado: false
})

watch(
  () => props.task,
  (newTask) => {
    form.nome = newTask?.nome || ''
    form.descricao = newTask?.descricao || ''
    form.data_limite = newTask?.data_limite || ''
    form.finalizado = newTask?.finalizado || false
  },
  { immediate: true }
)

function save() {
  const payload = {
    ...props.task,
    ...form
  }
  emit('save', payload)
}
</script>
