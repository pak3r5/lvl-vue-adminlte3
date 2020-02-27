<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Countries</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="../home">Home</router-link></li>
                            <li class="breadcrumb-item active">Countries</li>
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
                                    <thead  class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Short Name</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="country in countries">
                                        <td>{{country.name}}</td>
                                        <td>{{country.short_name}}</td>
                                        <td>
                                            <a href="#" data-id="user.uuid" @click="editModalWindow(country)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            |
                                            <a href="#" @click="deleteCountry(country.uuid)">
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

                                    <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add New Country</h5>
                                    <h5 v-show="editMode" class="modal-title" id="addUpdateLabel">Update Country</h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editMode ? updateCountry() : createCountry()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input v-model="form.name" type="text" name="name"
                                                   placeholder="Name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                                        </div>

                                        <div class="form-group">
                                            <input v-model="form.short_name" type="text" name="short_name"
                                                   placeholder="Short Name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('short_name') }">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('short_name')" v-text="form.errors.get('short_name')"></span>
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
                countries: [],
                form: new Form({
                    'name': '',
                    'short_name': '',
                })
            }

        },

        created() {
            /*axios.get('/countries')
                .then(({data}) => this.countries = data);*/
            this.loadCountries();

            Fire.$on('AfterCreatedCountryLoadIt',()=>{ //custom events fire on
                this.loadCountries();
            });
        },
        methods: {
            editModalWindow(country) {
                this.form.reset();
                this.editMode = true
                this.form.reset();
                $('#addNew').modal('show');
                this.form = new Form(country)
            },
            updateCountry() {
                this.form.put('/countries/' + this.form.uuid)
                    .then(() => {

                        Toast.fire({
                            icon: 'success',
                            title: 'Country updated successfully'
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
            loadCountries() {
                axios.get("/countries")
                    .then(({data}) => this.countries = data);
                //pick data from controller and push it into users object

            },

            createCountry() {

                this.$Progress.start()

                this.form.post('/countries')
                    .then(() => {

                        Fire.$emit('AfterCreatedCountryLoadIt'); //custom events

                        Toast.fire({
                            icon: 'success',
                            title: 'Country created successfully'
                        })

                        this.$Progress.finish()

                        $('#addNew').modal('hide');

                    })
                    .catch(() => {
                        console.log("Error......")
                    })

                //this.loadUsers();
            },
            deleteCountry(uuid) {
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
                        axios.delete('/countries/' + uuid)
                            .then((response) => {
                                Swal.fire(
                                    'Deleted!',
                                    'Country deleted successfully',
                                    'success'
                                )
                                this.loadCountries();

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
