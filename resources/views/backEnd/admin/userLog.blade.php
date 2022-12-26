@extends('backEnd.masterPage')
@section('mainPart')
<div class="page-body">
    <div class="card">
        <div class="card-header">
            <h5>User Login History</h5>
        </div>
        <div class="card-body">
            <div class="dt-plugin-buttons"></div>
                <div class="dt-responsive table-responsive">
                    <table id="users-history" class="table table-striped table-bordered nowrap">
                        <thead class="bg-success">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>IP</th>
                                <th>County</th>
                                <th>Login Time</th>
                                <th>Logout Time</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
</div>
                                                  
<script>
    $(function() {
        $('#users-history').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('user.history') !!}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                { data: 'ip', name: 'ip' },
                { data: 'country', name: 'country' },
                { data: 'login', name: 'login' },
                { data: 'logout', name: 'logout' }
            ],
            "lengthMenu": [[25, 50, 100, 500,1000, -1], [25, 50, 100, 500,1000, "All"]],
            "order": [[ 0, "desc" ]] 
        });
    });
</script>
@endsection

