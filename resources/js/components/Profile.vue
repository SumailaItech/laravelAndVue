<template>
  <main class="container-fluid">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img
                    class="profile-user-img img-fluid img-circle"
                    :src="getProfilePhoto()"
                    alt="User profile picture"
                  />
                </div>
                <h3 class="profile-username text-center">{{form.name}}</h3>
                <p class="text-muted text-center">Software Engineer</p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>
                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
            </div>
          </div>

          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a
                      class="nav-link active"
                      href="#activity"
                      data-toggle="tab"
                      >Activity</a
                    >
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#timeline" data-toggle="tab"
                      >Timeline</a
                    >
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#settings" data-toggle="tab"
                      >Settings</a
                    >
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="activity">
                    <div class="post">
                      <div class="user-block">
                        <img
                          class="img-circle img-bordered-sm"
                          src="../../../public/img/user6-128x128.jpg"
                          alt="User Image"
                        />
                        <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"
                            ><i class="fas fa-times"></i
                          ></a>
                        </span>
                        <span class="description"
                          >Posted 5 photos - 5 days ago</span
                        >
                      </div>

                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img
                            class="img-fluid"
                            src="../../../public/img/photo1.jpg"
                            alt="Photo"
                          />
                        </div>

                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <img
                                class="img-fluid mb-3"
                                src="../../../public/img/photo2.jpg"
                                alt="Photo"
                              />
                              <img
                                class="img-fluid"
                                src="../../../public/img/photo3.jpg"
                                alt="Photo"
                              />
                            </div>

                            <div class="col-sm-6">
                              <img
                                class="img-fluid mb-3"
                                src="../../../public/img/photo4.jpg"
                                alt="Photo"
                              />
                              <img
                                class="img-fluid"
                                src="../../../public/img/photo1.jpg"
                                alt="Photo"
                              />
                            </div>
                          </div>
                        </div>
                      </div>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"
                          ><i class="fas fa-share mr-1"></i> Share</a
                        >
                        <a href="#" class="link-black text-sm"
                          ><i class="far fa-thumbs-up mr-1"></i> Like</a
                        >
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>
                      <input
                        class="form-control form-control-sm"
                        type="text"
                        placeholder="Type a comment"
                      />
                    </div>
                  </div>

                  <div class="tab-pane" id="timeline">
                    <div class="timeline timeline-inverse">
                      <div class="time-label">
                        <span class="bg-danger"> 10 Feb. 2014 </span>
                      </div>

                      <div>
                        <i class="fas fa-envelope bg-primary"></i>
                        <div class="timeline-item">
                          <span class="time"
                            ><i class="far fa-clock"></i> 12:05</span
                          >
                          <h3 class="timeline-header">
                            <a href="#">Support Team</a> sent you an email
                          </h3>
                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj
                            voxy zoodles, weebly ning heekya handango imeem
                            plugg dopplr jibjab, movity jajah plickers sifteo
                            edmodo ifttt zimbra. Babblely odeo kaboodle quora
                            plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm"
                              >Read more</a
                            >
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" @submit.prevent="updateInfo()">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label"
                          >Name</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="text"
                            v-model="form.name"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('name') }"
                            id="inputName"
                            name="name"
                            placeholder="Name"
                          />
                          <div
                            :class="{ 'invalid-feedback': form.errors.has('name') }"
                            v-if="form.errors.has('name')"
                            v-html="form.errors.get('name')"
                            />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label"
                          >Email</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="email"
                            v-model="form.email"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('email') }"
                            id="inputEmail"
                            name="email"
                            placeholder="Email"
                          />
                          <div
                        :class="{ 'invalid-feedback': form.errors.has('email') }"
                        v-if="form.errors.has('email')"
                        v-html="form.errors.get('email')"
                        />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="inputExperience"
                          class="col-sm-2 col-form-label"
                          >Bio</label
                        >
                        <div class="col-sm-10">
                          <textarea
                            class="form-control"
                            v-model="form.bio"
                            :class="{ 'is-invalid': form.errors.has('bio') }"
                            id="inputExperience"
                            name="bio"
                            placeholder="Experience"
                          ></textarea>
                          <div
                        :class="{ 'invalid-feedback': form.errors.has('bio') }"
                        v-if="form.errors.has('bio')"
                        v-html="form.errors.get('bio')"
                        />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label"
                          >Profile Photo</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="file"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('photo') }"
                            name="photo"
                            @change="updateProfile"
                            id="profilePhoto"
                          />
                          <div
                        :class="{ 'invalid-feedback': form.errors.has('experience') }"
                        v-if="form.errors.has('experience')"
                        v-html="form.errors.get('experience')"
                        />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label"
                          >Password (leave empty if not change)</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="password"
                            v-model="form.password"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('password') }"
                            name="password"
                            id="password"
                          />
                          <div
                        :class="{ 'invalid-feedback': form.errors.has('password') }"
                        v-if="form.errors.has('password')"
                        v-html="form.errors.get('password')"
                        />
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success" >
                            Submit
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<style>
.widget-user-header {
  background-position: center center;
  background-size: cover;
  height: 350px !important;
}
</style>
<script>

export default {
   data() {
     return {
        form: new Form({
            id: "",
            name: "",
            email: "",
            password: "",
            type: "",
            bio: "",
            photo: "",
      }),
     }
   },
   methods: {
    loadProfile() {
        this.form.reset();
        axios.get("api/profile").then(({data})=>(this.form.fill(data)))
    },
    getProfilePhoto(){
        let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo;
        return photo;
    },
    updateInfo() {
        this.$Progress.start();
        this.form.put('api/profile')
        .then((data)=>{
            Fire.$emit("DataChange");
            Toast.fire({
                icon: "success",
                title: data.data.message,
          });
            this.$Progress.finish();
        })
        .catch(()=>{
            this.$Progress.fail();
        });
    },
    updateProfile(e) {
        let file = e.target.files[0];
        let reader = new FileReader();

        if(file['size'] < 2111775){
            reader.onloadend = (file) => {
                this.form.photo = reader.result;
            }
            reader.readAsDataURL(file);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You are uploading a larger file it should be less than 2M!',
            })
        }
    }
   },
  mounted() {
    console.log("Component mounted.");
  },

  created() {
   this.loadProfile();
   Fire.$on("DataChange", () => {
      this.getProfilePhoto();
      this.loadProfile();
    });
  }
};
</script>
