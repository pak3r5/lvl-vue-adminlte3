<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">MAtches</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="../home">Home</router-link></li>
                            <li class="breadcrumb-item active">MAtches</li>
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
                                        <th>Local</th>
                                        <th>Visitant</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="match in matches">
                                        <td>{{match.result}}</td>
                                        <td>{{match.result}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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
                matches: [],
            }
        },
        created() {
            this.loadMatches();

            Fire.$on('AfterCreatedMatchesLoadIt',()=>{ //custom events fire on
                this.loadMatches();
            });
        },
        methods: {
            loadMatches() {
                axios.get("/matches")
                    .then(({data}) => this.matches = data);
                //pick data from controller and push it into users object

            }
        }
    }

</script>
