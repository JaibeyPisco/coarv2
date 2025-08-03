<script setup>
const props = defineProps({
  menu: String,
  title: String,
  items: Array,
  modelValue: Object,
})
const emit = defineEmits(['update:modelValue'])

const tipos = ['view', 'new', 'edit', 'delete']

function toggle(tipo, checked) {
  // Crear nuevo objeto desde cero para asegurar reactividad
  const nuevoValor = {
    view: false,
    new: false,
    edit: false,
    delete: false,
    ...props.modelValue,
    [tipo]: checked,
  }

  emit('update:modelValue', nuevoValor)
}
</script>

<template>
  <tr :data-menu="menu">
    <td>{{ title }}</td>
    <td v-for="tipo in tipos" :key="tipo" class="text-center">
      <input
        v-if="items.includes(tipo)"
        type="checkbox"
        :checked="modelValue?.[tipo] || false"
        @change="e => toggle(tipo, e.target.checked)"
      />
    </td>
  </tr>
</template>
