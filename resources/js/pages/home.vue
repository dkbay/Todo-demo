<template>
  <div>
    <h1>
      Din todo liste
    </h1>

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

export default {
  middleware: 'auth',

  components: {
    AddTodo
  },

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    form: new Form({
      title: ''
    }),
    todos: []
  }),

  mounted () {
    axios.get('/api/todos')
      .then(response => {
        let todos = response.data
        todos.forEach((todo) => todo.editing = false)
        this.todos = todos
      })
  },

  methods: {
    async deleteTodo (id) {
      axios.post('/api/todos/' + id, {
        _method: 'delete'
      })
      let i = this.todos.map(todo => todo.id).indexOf(id)
      this.todos.splice(i, 1)
    },
    async updateTodos () {
      axios.get('/api/todos')
        .then(response => {
          let todos = response.data
          todos.forEach((todo) => todo.editing = false)
          this.todos = todos
        })
    },
    async createTodo (title) {
      axios.post('/api/todos', {
        title: title
      })
        .then(response => this.updateTodos())
    },
    async editTodo (id) {
      let i = this.todos.map(todo => todo.id).indexOf(id)
      console.log(i)
      if (this.todos[i].editing === false) {
        this.todos[i].editing = true
      } else {
        console.log($('#' + id).val())
        this.todos[i].title = $('#' + id).val()
        axios.post('/api/todos/' + id, {
          _method: 'put',
          title: this.todos[i].title
        })
        this.todos[i].editing = false
      }
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
      padding-left:16px;
    }

    input {
        padding-left: 10px;
        padding-right: 10px;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 35px;
        outline: none;
    }
</style>
