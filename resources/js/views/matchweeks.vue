<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Matchweeks</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="../home">Home</router-link></li>
                            <li class="breadcrumb-item active">Matchweeks</li>
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
                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>League</th>
                                        <th>Name</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="matchweek in matchweeks">
                                        <td>{{matchweek.league.name}}</td>
                                        <td>{{matchweek.name}}</td>
                                        <td>
                                            <a href="#" data-id="user.uuid" @click="editModalWindow(matchweek)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            |
                                            <a href="#" @click="deleteMatchweek(matchweek.uuid)">
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

                                    <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add New Matchweek</h5>
                                    <h5 v-show="editMode" class="modal-title" id="addUpdateLabel">Update Matchweek</h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editMode ? updateMatchweek() : createMatchweek()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input v-model="matchweek.name" type="text" name="name"
                                                   placeholder="Name"
                                                   class="form-control" :class="{ 'is-invalid': matchweek.errors.has('name') }">
                                            <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('name')" v-text="matchweek.errors.get('name')"></span>
                                        </div>
                                        <div class="form-group">
                                            <select class="custom-select form-control" v-model="matchweek.league_id" :class="{ 'is-invalid': matchweek.errors.has('league_id') }" name="league_id">
                                                <option value="">Selecciona una liga</option>
                                                <option v-for="league in leagues" v-bind:value="league.id">
                                                    {{ league.name }}
                                                </option>
                                            </select>
                                            <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('league_id')" v-text="matchweek.errors.get('league_id')"></span>
                                        </div>
                                        <div class="form-group">
                                            <input v-model="matchweek.start" type="datetime-local" name="start"
                                                   placeholder="start"
                                                   class="form-control" :class="{ 'is-invalid': matchweek.errors.has('start') }">
                                            <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('start')" v-text="matchweek.errors.get('start')"></span>
                                        </div>
                                        <div class="form-group">
                                            <input v-model="matchweek.end" type="datetime-local" name="end"
                                                   placeholder="end"
                                                   class="form-control" :class="{ 'is-invalid': matchweek.errors.has('end') }">
                                            <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('end')" v-text="matchweek.errors.get('end')"></span>
                                        </div>

                                        <div class="form-group">
                                            <input v-model="matchweek.matchname" type="text" name="match[name]"
                                                   placeholder="Name"
                                                   class="form-control" :class="{ 'is-invalid': matchweek.errors.has('matchname') }">
                                            <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('matchname')" v-text="matchweek.errors.get('matchname')"></span>
                                        </div>

                                        <div class="form-group">
                                            <input v-model="matchweek.matchstart" type="datetime-local" name="match[start]"
                                                   placeholder="start"
                                                   class="form-control" >

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
                matchweeks: [],
                matchweek: new Form({
                    'name': '',
                    'league_id': '',
                    'start': '',
                    'end': '',
                    'matchname': '',
                    'matchstart': '',
                    'local': [],
                    'visitant':[],
                })
            }
        },
        created() {
            this.loadMatchweek();
            Fire.$on('AfterCreatedMatchweekLoadIt',()=>{ //custom events fire on
                this.loadMatchweek();
            });
        },
        methods: {
            onSubmit() {
                this.form
                    .post('/matchweeks')
                    .then(matchweek => this.matchweeks.push(matchweek));
            },
            editModalWindow(matchweek) {
                this.matchweek.reset();
                this.editMode = true
                this.matchweek.reset();
                $('#addNew').modal('show');
                this.form = new Form(matchweek)
            },
            updateMatchweek() {
                this.matchweek.put('/matchweeks/' + this.matchweek.uuid)
                    .then(() => {

                        Toast.fire({
                            icon: 'success',
                            title: 'Matchweek updated successfully'
                        })

                        Fire.$emit('AfterCreatedMatchweekLoadIt');

                        $('#addNew').modal('hide');
                    })
                    .catch(() => {
                        console.log("Error.....")
                    })
            },
            openModalWindow() {
                this.editMode = false
                this.matchweek.reset();
                $('#addNew').modal('show');
            },
            loadMatchweek() {
                console.log("load information");
                axios.get("/matchweeks")
                    .then(({data}) => {this.matchweeks = data.matchweeks; this.leagues = data.leagues;});
            },
            createMatchweek() {
                this.$Progress.start()
                this.matchweek.post('/matchweeks')
                    .then(() => {
                        Fire.$emit('AfterCreatedMatchweekLoadIt'); //custom events
                        Toast.fire({
                            icon: 'success',
                            title: 'Matchweek created successfully'
                        })
                        this.$Progress.finish()
                        $('#addNew').modal('hide');
                    })
                    .catch(() => {
                        console.log("Error......")
                    })
                //this.loadUsers();
            },
            deleteMatchweek(uuid) {
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
                        axios.delete('/matchweeks/' + uuid)
                            .then((response) => {
                                Swal.fire(
                                    'Deleted!',
                                    'Matchweek deleted successfully',
                                    'success'
                                )
                                this.loadMatchweek();
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
