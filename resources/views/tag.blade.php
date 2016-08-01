@extends('layouts.app')

@section('content')

    <div id="TagController">

        <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Add Tags</button>
        <br><br>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Tags Form</h4>
                    </div>
                    <div class="modal-body">

                        <form action="#" @submit.prevent="AddNewUser" method="POST">

                            <div class="alert alert-danger" v-if="!isValid">
                                <ul>
                                    <li v-show="!validation.name">Please Fill Name</li>
                                    <li v-show="!validation.title">Please Fill Title</li>
                                    <li v-show="!validation.description">Please Fill Description</li>
                                </ul>

                            </div>
                            <div class="sortable">
                                <div class="form-group">
                                    <label for="title">Name:</label>
                                    <input v-model="newTag.name" type="text" id="name" name="name" placeholder="Tag Name" class="form-control" autofocus="">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input v-model="newTag.title" type="text" id="title" name="title" placeholder="Tags Title" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <input v-model="newTag.description" type="text" id="description" name="description" placeholder="Tags description" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <button :disabled="!isValid" class="btn btn-success" type="submit" v-if="!edit">Add Tag</button>
                                <button :disabled="!isValid" class="btn btn-danger" type="submit" v-if="edit" @click="EditTag(newTag.id)">Update Tag</button>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="alert alert-success" transition="success" v-if="success">Add new Tag success
                </div>

                <div class="alert alert-danger" transition="succ" v-if="succ"> Edit Tag success
                </div>

                <div class="alert alert-danger" transition="remove" v-if="remove"> Delete Tag success
                </div>
            </div>
        </div>
        <!-- Vue Table -->
        <div class="row">
            <div class="col-md-7 form-inline">
                <div class="form-inline form-group">
                    <label>Search:</label>
                    <input v-model="searchFor" class="form-control" @keyup.enter="setFilter">
                    <button class="btn btn-primary" @click="setFilter">Go</button>
                    <button class="btn btn-default" @click="resetFilter">Reset</button>
                </div>
            </div>

            <div class="col-md-5">
                <div class="dropdown form-inline pull-right">
                    <label>Per Page:</label>
                    <select class="form-control" v-model="perPage">
                        <option value=10>10</option>
                        <option value=15>15</option>
                        <option value=20>20</option>
                        <option value=25>25</option>
                    </select>
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-cog"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li v-for="field in fields">
                            <span class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="field.visible">
                                    @{{ field.title == '' ? field.name.replace('__', '') : field.title | capitalize }}
                                </label>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <vuetable v-ref:vuetable
                      api-url="http://localhost:8000/api/tagAll/"
                      pagination-path=""
                      :fields="fields"
                      :sort-order="sortOrder"
                      table-class="table table-bordered table-striped table-hover"
                      ascending-icon="glyphicon glyphicon-chevron-up"
                      descending-icon="glyphicon glyphicon-chevron-down"
                      pagination-class=""
                      pagination-info-class=""
                      pagination-component-class=""
                      :pagination-component="paginationComponent"
                      :item-actions="itemActions"
                      :append-params="moreParams"
                      :per-page="perPage"
                      wrapper-class="vuetable-wrapper"
                      table-wrapper=".vuetable-wrapper"
                      loading-class="loading"
                      {{--detail-row="makeDetailRow"--}}
                      detail-row-id="id"
                      detail-row-transition="expand"
                      row-class-callback="rowClassCB"
            ></vuetable>
        </div>
    </div>

@endsection

@push('scripts')

{!! Html::script('/js/tag.js')!!}

@endpush