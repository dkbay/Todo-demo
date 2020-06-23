<template>
  <div id="AddTodoContainer">
    <input v-model="todo" placeholder="Opgave titel" maxlength="255" type="text">
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
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 35px;
    outline: none;
  }
  button {
    border-radius: 35px;
    background-color: #0ea389;
  }
</style>
