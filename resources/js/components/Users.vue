<template>
  <div class="container" >
    <div v-if="$gate.isAdmin()">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Users Page</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Users Page</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="row" >
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users Table</h3>

              <div class="card-tools">
                <button
                  class="btn btn-success"
                  @click="newModal"
                >
                  Add New
                  <i class="fas fa-user-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>EMail</th>
                    <th>Type</th>
                    <th>Registered At</th>
                    <th>Modify</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users.data" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.type | upText }}</td>
                    <td>{{ user.created_at | dateFormatted }}</td>
                    <td>
                      <a href="#" class="btn" @click="editModal(user)">
                        <i class="fa fa-edit text-green"></i
                      ></a>
                      /
                      <a href="#" class="btn" @click="deleteUser(user.id)">
                        <i class="fa fa-trash text-red"></i
                      ></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination :data="users" @pagination-change-page="getResults"></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
   </div>
   <div v-if="!$gate.isAdmin()">
    <not-found></not-found>
   </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="userModal"
      tabindex="-1"
      aria-labelledby="addNewUserModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userModalLabel">
              {{editMode ? "Update User's info" : "Add Users Form" }}
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateUser() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <label for="Name">Name</label>
                <input
                  v-model="form.name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                  type="text"
                  name="name"
                  placeholder="Name"
                />
                <div
                  :class="{ 'invalid-feedback': form.errors.has('name') }"
                  v-if="form.errors.has('name')"
                  v-html="form.errors.get('name')"
                />
              </div>

              <div class="form-group">
                <label for="Name">Email</label>
                <input
                  v-model="form.email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                  type="email"
                  name="email"
                  placeholder="Email"
                />
                <div
                  :class="{ 'invalid-feedback': form.errors.has('email') }"
                  v-if="form.errors.has('email')"
                  v-html="form.errors.get('email')"
                />
              </div>

              <div class="form-group">
                <label for="Bio">Bio</label>
                <textarea
                  v-model="form.bio"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('bio') }"
                  type="text"
                  name="bio"
                  placeholder="Please enter a small Bio (optional)"
                  cols="10"
                  rows="3"
                ></textarea>
                <div
                  v-if="form.errors.has('bio')"
                  v-html="form.errors.get('bio')"
                />
              </div>

              <div class="form-group">
                <label for="role">Role</label>
                <select
                  v-model="form.type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                  type="text"
                  name="type"
                >
                  <option value="">Select User Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">Standard User</option>
                  <option value="author">Auther</option>
                </select>
                <div
                  v-if="form.errors.has('type')"
                  v-html="form.errors.get('type')"
                />
              </div>

              <div class="form-group">
                <label for="Name">password</label>
                <input
                  v-model="form.password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                  type="password"
                  name="password"
                  placeholder="password"
                />
                <div
                  :class="{ 'invalid-feedback': form.errors.has('password') }"
                  v-if="form.errors.has('password')"
                  v-html="form.errors.get('password')"
                />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                Close
              </button>
              <button type="submit" class="btn btn-success">{{ editMode ? 'Update' : 'Create'}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      editMode: true,
      users: {},
      form: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: "",
      }),
    };
  },
  methods: {
    getResults(page = 1) {
			axios.get('api/user?page=' + page)
				.then(response => {
					this.users = response.data;
				});
		},
    newModal(){
      this.editMode = false;
      this.form.reset();
      $("#userModal").modal("show");
    },

    editModal(user){
      this.editMode = true;
      this.form.reset();
      this.form.clear();
      $("#userModal").modal("show");
      this.form.fill(user);
    },

    loadUsers() {
      if(this.$gate.isAdmin()) {
        axios.get("api/user").then(({ data }) => (this.users = data));
      }
    },

    createUser() {
      this.$Progress.start();
      this.form.post("api/user")
        .then(() => {
          $("#userModal").modal("hide");
          Fire.$emit("DataChange");
          Toast.fire({
            icon: "success",
            title: data.data.message,
          });

          this.$Progress.finish();
        })
        .catch((error) => {
          this.$Progress.fail();
          console.log(error);
        });
    },

  updateUser() {
      this.$Progress.start();
      this.form.put('api/user/'+this.form.id)
      .then((result)=>{
        $("#userModal").modal("hide");
        Swal.fire(
          'Updated!',
           result.data.message,
          'success'
        );
        this.$Progress.finish();
        Fire.$emit("DataChange");
      })
      .catch((error)=>{
        console.log(error);
        this.$Progress.fail();
      })
  },

  deleteUser(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      //Send request to server
      if(result.value) {
        this.form.delete('api/user/'+id).then((result)=>{
        Swal.fire(
          'Deleted!',
          result.data.message,
          'success'
        );
        Fire.$emit("DataChange");
        }).catch(()=>{
            Swal('Failed','There was something wrong.','warning')
        })
      }
    })
    }
  },

  created() {
    this.loadUsers();
    Fire.$on("DataChange", () => {
      this.loadUsers();
    });
  },
};
</script>
