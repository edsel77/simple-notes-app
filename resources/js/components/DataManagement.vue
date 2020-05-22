<template>
    <div class="container">
      <div class="ui items" v-for="(post, index) in notes" :key="post.id">
        <div class="item">
          <div class="content">
            <a class="header">{{ 'Note #' + (index + 1)  }}</a>
            <div class="description mb-1">
              <p v-if="!is_edit || post.id != edit_id">{{ post.note }}</p>
              <textarea v-model="form.note" rows="2" v-else></textarea>
            </div>
            <button class="mini ui toggle button" @click="editNote(post.id, post.note)" v-if="!is_edit || post.id != edit_id">
              Edit
            </button>
            <button class="mini ui toggle button" @click="updateNote(post.id)" v-else>
              Update
            </button>
            <button class="mini negative ui button" @click="deleteNote(post.id)">
              Delete
            </button>
          </div>
        </div>
      </div>
      <button class="positive ui button" @click="downloadCSV">
        Download CSV
      </button>
      <hr>
      <div class="ui form mb-3" v-show="!is_edit">
        <div class="field">
          <label>Post Note</label>
          <textarea v-model="form.note" rows="2"></textarea>
        </div>
      </div>
      <button class="ui primary button" @click="postNote">
        Post
      </button>
    </div>
</template>

<script>
  export default {
    name: 'DataManagement',
    data(){
      return {
        form: new Form({
          note: '',
        }),
        notes: [],
        is_edit: false,
        edit_id: 0,
      }
    },
    methods: {
      postNote(){
        this.form.post('/api/notes')
        .then((res) => {
          this.getNotes();
          this.form.note = '';
          alert('Note posted successfully');
        })
        .catch((error) => {
          alert('error encuntered');
        });
      },
      getNotes(){
        axios.get('/api/notes')
        .then((res) => {
          this.notes = res.data;
        })
        .catch((error) => {
          console.error(error)
        });
      },
      editNote(id, note){
        this.is_edit = true;
        this.edit_id = id;
        this.form.note = note;
      },
      updateNote(id){
        this.form.put('/api/notes/'+id)
        .then((res) => {
          this.getNotes();
          this.is_edit = false;
          this.edit_id = 0;
          this.form.note = '';
          alert('Note updated successfully');
        })
        .catch((error) => {
          alert('error encuntered');
        });
      },
      deleteNote(id){
        axios.delete('/api/notes/'+id)
        .then((res) => {
          this.getNotes();
          alert('Note deleted');
        })
        .catch((error) => {
          alert('error encuntered');
        });
      },
      downloadCSV(){
        // axios.get('/api/download-file')
        window.open('/api/download-file')
      }
    },
    created(){
      this.getNotes();
    }
  };
</script>