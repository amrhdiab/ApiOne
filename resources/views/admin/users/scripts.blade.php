@section('vendors')
    <!-- Datatables -->
    <script src="{{asset('app/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app/datatables/DataTables-1.10.18/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('app/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app/datatables/Responsive-2.2.2/js/responsive.bootstrap.min.js')}}"></script>
@endsection

@section('scripts')
    {{--Setup ajax--}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#users_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": true,
                responsive: true,
                "ajax": "{{route('users.fetch')}}",
                "columns": [
                    {"data": "checkboxes", orderable: false, searchable: false},
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "phone"},
                    {"data": "is_verified"},
                    {"data": "created_at", orderable: false, searchable: false},
                    {"data": "actions", orderable: false, searchable: false}
                ],
                order: [[5, 'desc']]
            });

            $('#add_data').on('click', function () {
                $('#user_modal').modal('show');
                $('#password_group').html('<div class="form-group" id="password_group"><label for="password">User password:</label><input type="password" name="password" id="password" class="form-control" required autocomplete="new-password"></div>');
                $('#password_c_group').html('<div class="form-group" id="password_c_group"><label for="confirm_password">Confirm password:</label><input type="password" name="c_password" id="c_password" class="form-control" required></div>');
                $('#user_form')[0].reset();
                $('#form_output').html('');
                $('.modal-title').text('Add New User');
                $('#form_action').val('insert');
                $('#submit').val('Submit');
            });

            $('#user_form').on('submit', function (event) {
                event.preventDefault();
                var action = $('#form_action').val();
                var form_data = new FormData($('#user_form')[0]);
                $.ajax({
                    url: '{{route('users.store')}}',
                    type: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.error.length > 0) {
                            var error_html = '';
                            data.error.forEach(function (error) {
                                error_html += "<div class='alert alert-danger'>" + error + "</div>";
                            });
                            $('#form_output').html(error_html);
                            toastr.error('Validation error', 'Error!', {timeOut: 1500});
                        } else {
                            $('#form_output').html('');
                            $('#user_form')[0].reset();
                            $('.modal-title').text('Add New User');
                            $('#form_action').val('insert');
                            $('#submit').val('Submit');
                            $('#user_modal').modal('hide');
                            $('#users_table').DataTable().ajax.reload();
                            if (action == 'insert') {
                                toastr.success('Created new user successfully.', 'Success!', {timeOut: 1500});
                            }
                            if (action == 'update') {
                                toastr.success('Updated user successfully.', 'Success!', {timeOut: 1500});
                            }
                        }
                    }
                });
            });

            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');
                $('#form_output').html('');
                $.ajax({
                    url: '{{route('users.fetch.single')}}',
                    type: 'GET',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                        $('#phone').val(data.phone);
                        $('#password_group').html('');
                        $('#password_c_group').html('');
                        $('#user_id').val(id);
                        $('#form_action').val('update');
                        $('.modal-title').text('Edit User');
                        $('#submit').val('Update');
                        $('#user_modal').modal('show');
                    }
                });
            });

            $(document).on('click', '.delete', function () {
                var id = $(this).attr('id');
                if (confirm('Are you sure you want to delete the user?')) {
                    $.ajax({
                        url: '{{route('users.remove')}}',
                        type: 'DELETE',
                        data: {id: id},
                        success: function (data) {
                            toastr.success('Deleted user successfully.', 'Success!', {timeOut: 1500})
                            $('#users_table').DataTable().ajax.reload();
                        }
                    });
                } else {
                    return false;
                }
            });

            $(document).on('click', '#bulk_delete', function () {
                var id = [];
                $('.user_checkbox:checked').each(function () {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    if (confirm('Are you sure you want to delete selected data?')) {

                        $.ajax({
                            url: '{{route('users.remove.bulk')}}',
                            type: 'DELETE',
                            data: {id: id},
                            success: function (data) {
                                toastr.success('Deleted data successfully.', 'Success!', {timeOut: 1500})
                                $('#users_table').DataTable().ajax.reload();
                            }
                        });
                    } else {
                        return false;
                    }
                } else {
                    alert('Please select data to delete.');
                }
            });

            $(document).on('click', '.view', function () {
                var id = $(this).attr('id');
                $.ajax({
                    url: '{{route('users.view')}}',
                    data: {id: id},
                    type: 'GET',
                    success: function (data) {
                        $('#user_view_modal').modal('show');
                        $('.modal-title').text('View User');
                        $('#user_data_container').html(data);
                    }
                });
            });

        });
    </script>
@endsection