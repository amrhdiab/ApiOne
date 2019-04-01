@extends('admin.layouts.app')
@section('title','Users')
@section('styles')
    <link href="{{asset('app/datatables/DataTables-1.10.18/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('app/datatables/Responsive-2.2.2/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading" style="height: 50px">
            <h4 class="pull-left">Users</h4>
            <button type="button" name="add_data" id="add_data" class="btn btn-success btn-sm pull-right" style="margin-bottom: 10px">Add New</button>
            <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-sm pull-right" style="margin-right: 5px">
                <i class="glyphicon glyphicon-remove"></i> Bulk Delete
            </button>
        </div>
        <div class="panel-body">
            <table id="users_table"
                   class="table table-bordered table-hover table-striped responsive nowrap"
                   cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Verification</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
            {{--Store & Update modal--}}
            <div class="modal fade" role="dialog" id="user_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" id="user_form">
                            <div class="modal-header">
                                <button type="button" class="close"
                                        data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add New User</h4>
                            </div>
                            <div class="modal-body">
                                <span id="form_output" class="toastr"></span>
                                <div class="form-group">
                                    <label for="name">User name:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           required autocomplete="username">
                                </div>
                                <div class="form-group">
                                    <label for="email">User email:</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                           required autocomplete="email">
                                </div>
                                <div class="form-group">
                                    <label for="phone">User phone:</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                           required autocomplete="phone">
                                </div>
                                <div class="form-group" id="password_group">
                                    <label for="password">User password:</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                           required autocomplete="new-password">
                                </div>
                                <div class="form-group" id="password_c_group">
                                    <label for="confirm_password">Confirm password:</label>
                                    <input type="password" name="c_password" id="c_password" class="form-control"
                                           required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_action" id="form_action" value="insert">
                                <input type="hidden" name="user_id" id="user_id" value="">
                                <input type="submit" name="submit" id="submit" value="Submit"
                                       class="btn btn-success">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{--View Modal--}}
            <div class="modal fade" role="dialog" id="user_view_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"
                                    data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">View User</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th>Name:</th>
                                    <th>Email:</th>
                                    <th>Phone:</th>
                                    <th>Verification:</th>
                                </tr>
                                </thead>
                                <tbody id="user_data_container"></tbody>
                            </table>
                            <div id="user_data_container"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.users.scripts')