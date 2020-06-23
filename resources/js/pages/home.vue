<template>
  <div>
    <h1>
      Din todo liste
    </h1>

    <Spinner :loading="isLoading" />
    <AddTodo />

    <ul class="list-group mt-4">
      <li v-for="todo in todos" :key="todo.id"
          class="list-group-item d-flex justify-content-between align-items-center"
      >
        <input v-if="todo.editing" :id="todo.id" :value="todo.title" maxlength="255" type="text">
        <p v-else class="mb-0">
          {{ todo.title }}
        </p>
        <div>
          <a v-if="todo.editing" href="#" @click="editTodo(todo.id)">
            <fa size="lg" :style="{color: '#0ea389'}" :icon="['fa', 'save']" />
          </a>
          <a v-else href="#" @click="editTodo(todo.id)">
            <fa size="lg" :style="{color: '#0ea389'}" :icon="['fa', 'edit']" />
          </a>
          <a class="ml-3" href="#" @click="deleteTodo(todo.id)">
            <fa size="lg" :style="{color: '#cc4141'}" :icon="['fas', 'trash-alt']" />
          </a>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'
import $ from 'jquery'
import AddTodo from '~/components/AddTodo'
import Spinner from '~/components/Spinner'

export default {
  middleware: 'auth',

  components: {
    AddTodo,
    Spinner
  },

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    form: new Form({
      title: ''
    }),
    todos: [],
    isLoading: true
  }),

  mounted () {
    axios.get('/api/todos')
      .then(response => {
        let todos = response.data
        todos.forEach((todo) => todo.editing = false)
        this.todos = todos
      })
    this.isLoading = false
  },

  methods: {
    async deleteTodo (id) {
      this.isLoading = true
      let i = this.todos.map(todo => todo.id).indexOf(id)
      this.todos.splice(i, 1)
      axios.post('/api/todos/' + id, {
        _method: 'delete'
      })
      this.isLoading = false
    },
    async updateTodos () {
      this.isLoading = true
      axios.get('/api/todos')
        .then(response => {
          let todos = response.data
          todos.forEach((todo) => todo.editing = false)
          this.todos = todos
        })
      this.isLoading = false
    },
    async createTodo (title) {
      this.isLoading = true
      axios.post('/api/todos', {
        title: title
      })
        .then(response => {
          this.updateTodos()
          this.isLoading = false
        })
    },
    async editTodo (id) {
      this.isLoading = true
      let i = this.todos.map(todo => todo.id).indexOf(id)
      if (this.todos[i].editing === false) {
        this.todos[i].editing = true
      } else {
        this.todos[i].title = $('#' + id).val()
        axios.post('/api/todos/' + id, {
          _method: 'put',
          title: this.todos[i].title
        })
        this.todos[i].editing = false
      }
      this.isLoading = false
    }
  }
}
</script>

<style scoped>
    h1 {
      color: #415459;
    }

    p {
      max-width: 85%;
      display: block;
      word-wrap: break-word;
      color: #415459;
      line-height: 28px;
      padding-left:11px;
    }

    input {
      display: block;
      width: 85%;
      padding-left: 10px;
      padding-right: 10px;
      border: 1px solid rgba(0, 0, 0, 0.125);
      border-radius: 35px;
      outline: none;
    }
</style>
