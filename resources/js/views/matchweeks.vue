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
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
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
                        <div class="modal-dialog  modal-xl modal-dialog-centered" role="document" >
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
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="name">Jornada</label>
                                                    <input v-model="matchweek['name']" type="text" name="name" id="name"
                                                           placeholder="Name"
                                                           class="form-control" :class="{ 'is-invalid': matchweek.errors.has('name') }">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('name')" v-text="matchweek.errors.get('name')"></span>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="league_id">Liga</label>
                                                    <select class="custom-select form-control" v-model="matchweek.league_id" :class="{ 'is-invalid': matchweek.errors.has('league_id') }" name="league_id"  id="league_id">
                                                        <option value="">Selecciona una liga</option>
                                                        <option v-for="league in leagues" v-bind:value="league.id">
                                                            {{ league.name }}
                                                        </option>
                                                    </select>
                                                    <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('league_id')" v-text="matchweek.errors.get('league_id')"></span>
                                                </div>
                                            </div>
                                            <!--<div class="col-3">
                                                <div class="form-group">
                                                    <label for="start">Fecha de inicio:</label>
                                                    <input v-model="matchweek.start" type="datetime-local" name="start" id="start"
                                                           placeholder="start"
                                                           class="form-control" :class="{ 'is-invalid': matchweek.errors.has('start') }">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('start')" v-text="matchweek.errors.get('start')"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="end">Fecha Final</label>
                                                    <input v-model="matchweek.end" type="datetime-local" name="end" id="end"
                                                           placeholder="end"
                                                           class="form-control" :class="{ 'is-invalid': matchweek.errors.has('end') }">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('end')" v-text="matchweek.errors.get('end')"></span>
                                                </div>
                                            </div>-->
                                        </div>
                                        <div class="row" v-for="(value, index) in resultset">
                                            <div class="col-5">
                                                <label :for="'match.name.'+index">Partido {{index + 1}}</label>
                                                <input v-model="resultset[index].name" type="hidden" :name="'match.name['+index+']'" :id="'match.name.'+index"
                                                       placeholder="Partido" class="form-control" :class="{ 'is-invalid': matchweek.errors.has('match[index].name') }">
                                                <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('match[index].name')" v-text="matchweek.errors.get('match[index].name')"></span>
                                                <select class="custom-select form-control" :name="'match.local_id['+index+']'" :id="'match.local_id.'+index" :class="{ 'is-invalid': matchweek.errors.has('match[index].local_id') }" v-model="resultset[index].local_id">
                                                    <option value="">Selecciona un equipo</option>
                                                    <option v-for="team in teams" v-bind:value="team.id">
                                                        {{ team.name }}
                                                    </option>
                                                </select>
                                                <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('match[index].local_id')" v-text="matchweek.errors.get('match[index].local_id')"></span>
                                            </div>
                                            <div class="col-1">
                                                <label :for="'match.local.'+index">&nbsp;</label>
                                                <input v-model="resultset[index].local" type="text" :name="'match.local['+index+']'" :id="'match.local.'+index"
                                                       placeholder="Local" class="form-control" :class="{ 'is-invalid': matchweek.errors.has('match[index].local') }">
                                                <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('match[index].local')" v-text="matchweek.errors.get('match[index].local')"></span>
                                            </div>
                                            <div class="col-1">
                                                <label :for="'match.visitant.'+index">&nbsp;</label>
                                                <input v-model="resultset[index].visitant" type="text" :name="'match.visitant['+index+']'" :id="'match.visitant.'+index"
                                                       placeholder="Local" class="form-control" :class="{ 'is-invalid': matchweek.errors.has('match[index].visitant') }">
                                                <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('match[index].visitant')" v-text="matchweek.errors.get('match[index].visitant')"></span>
                                            </div>
                                            <div class="col-5">
                                                <label :for="'match.visitant_id.'+index">&nbsp;</label>
                                                <select class="custom-select form-control" :name="'match.visitant_id['+index+']'" :id="'match.visitant_id.'+index" :class="{ 'is-invalid': matchweek.errors.has('match[index].visitant_id') }" v-model="resultset[index].visitant_id">
                                                    <option value="">Selecciona un equipo</option>
                                                    <option v-for="team in teams" v-bind:value="team.id">
                                                        {{ team.name }}
                                                    </option>
                                                </select>
                                                <span class="invalid-feedback d-block" role="alert" v-if="matchweek.errors.has('match[index].visitant_id')" v-text="matchweek.errors.get('match[index].visitant_id')"></span>
                                            </div>
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
                teams:[],
                matchweeks: [],
                totalmatch:9,
                resultset:[],
                matchweek: new Form({
                    "name": '',
                    "league_id": '',
                    "match":[],
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
            editModalWindow(matchweek) {
                let aux = this;
                this.matchweek.reset();
                this.editMode = true
                this.matchweek.reset();
                $('#addNew').modal('show');
                this.matchweek = new Form(matchweek);
                matchweek.matches.forEach( function(value, index, array) {
                    aux.resultset[index].local_id = matchweek.matches[index].locals.id;
                    aux.resultset[index].local = matchweek.matches[index].local;
                    aux.resultset[index].visitant_id = matchweek.matches[index].visitants.id;
                    aux.resultset[index].visitant = matchweek.matches[index].visitant;
                });
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
                axios.get("/matchweeks")
                    .then(({data}) => {this.matchweeks = data.matchweeks; this.leagues = data.leagues;this.teams = data.teams;});
                for (let i = 0; i < this.totalmatch; i++) {
                    let test = JSON.parse(JSON.stringify({name: i,local_id:'',local:'0',visitant_id:'',visitant:'0'}));
                    this.matchweek.match.push(test);
                    this.resultset.push(test);
                }
            },
            createMatchweek() {
                this.$Progress.start();
                this.matchweek.originalData.name=this.matchweek.name;
                this.matchweek.originalData['league_id']=this.matchweek.league_id;
                this.matchweek.postArray('/matchweeks')
                    .then((response) => {
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
