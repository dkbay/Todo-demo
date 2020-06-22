<template>
  <div id="AddTodoContainer">
    <input v-model="todo" placeholder="Opgave titel" type="text">
    <button @click="createTodo" class="btn btn-info">
      Tilføj
    </button>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  name: 'AddTodo',

  data: () => ({
    todo: ''
  }),

  methods: {
    async createTodo () {
      let title = this.todo
      this.todo = ''
      await this.$parent.createTodo(title)
    }
  }
}
</script>

<style scoped>
  div#AddTodoContainer {
    display: grid;
    grid-template-columns: 9fr 1fr;
    grid-column-gap: 25px;
  }
  input {
    padding-left:15px;
    padding-right:15px;
  }
</style>
