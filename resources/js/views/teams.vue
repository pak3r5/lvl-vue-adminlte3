<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Teams</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="../home">Home</router-link></li>
                            <li class="breadcrumb-item active">Teams</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                                <div class="card-tools">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: auto;">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>League</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="team in teams">
                                        <td>{{team.name}}</td>
                                        <td>{{team.name}}</td>
                                        <td>
                                            <a href="#" data-id="user.uuid" @click="editModalWindow(team)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            |
                                            <a href="#" @click="deleteTeam(team.uuid)">
                                                <i class="fa fa-trash red"></i>
                                            </a>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add New Team</h5>
                                    <h5 v-show="editMode" class="modal-title" id="addUpdateLabel">Update Team</h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editMode ? updateTeam() : createTeam()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input v-model="form.name" type="text" name="name"
                                                   placeholder="Name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                                        </div>

                                        <div class="form-group">
                                            <select class="custom-select" v-model="form.league_id">
                                                <option value="">Selecciona una liga</option>
                                                <option v-for="league in leagues" v-bind:value="league.id">
                                                    {{ league.name }}
                                                </option>
                                            </select>
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('league_id')" v-text="form.errors.get('league_id')"></span>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
                                        <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editMode: false,
                leagues: [],
                teams: [],
                form: new Form({
                    'name': '',
                    'league_id': '',
                })
            }

        },

        created() {
            this.loadTeams();

            Fire.$on('AfterCreatedCountryLoadIt',()=>{ //custom events fire on
                this.loadTeams();
            });
        },
        methods: {
            editModalWindow(team) {
                this.form.reset();
                this.editMode = true
                this.form.reset();
                $('#addNew').modal('show');
                this.form = new Form(team)
            },
            updateTeam() {
                this.form.put('/teams/' + this.form.uuid)
                    .then(() => {

                        Toast.fire({
                            icon: 'success',
                            title: 'User updated successfully'
                        })

                        Fire.$emit('AfterCreatedCountryLoadIt');

                        $('#addNew').modal('hide');
                    })
                    .catch(() => {
                        console.log("Error.....")
                    })
            },
            openModalWindow() {
                this.editMode = false
                this.form.reset();
                $('#addNew').modal('show');
            },
            loadTeams() {
                console.log("load information");
                axios.get("/teams")
                    .then(({data}) => {this.teams = data.teams; this.leagues = data.leagues;});
                //pick data from controller and push it into users object

            },

            createTeam() {

                this.$Progress.start()

                this.form.post('/teams')
                    .then(() => {

                        Fire.$emit('AfterCreatedCountryLoadIt'); //custom events

                        Toast.fire({
                            icon: 'success',
                            title: 'Team created successfully'
                        })

                        this.$Progress.finish()

                        $('#addNew').modal('hide');

                    })
                    .catch(() => {
                        console.log("Error......")
                    })


                //this.loadUsers();
            },
            deleteTeam(uuid) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.value) {
                        //Send Request to server
                        axios.delete('/teams/' + uuid)
                            .then((response) => {
                                Swal.fire(
                                    'Deleted!',
                                    'Team deleted successfully',
                                    'success'
                                )
                                this.loadTeams();

                            }).catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                footer: '<a href>Why do I have this issue?</a>'
                            })
                        })
                    }

                })
            }
        }
    }

</script>
