@extends('layouts.app')

@section('content')
<div class="container mt-2 pt-2">

    <div class="row mb-3">
        <div class="col-12 col-md-10">
            <h2>{{$language::get('permissions')}}: {{$role->name}}</h2>
        </div>
        <div class="col-12 col-md-2">
            <a href="{{route('role.index')}}">
                <button type="button" class="btn btn-outline-secondary btn-block">
                    {{$language::get('return')}}
                </button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <fieldset>

                <div class="col">
                    <center><small>{{$language::get('role_permission_label')}}</small></center>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-info">
                                    <th scope="col">{{$language::get('permission')}}</th>
                                    <th scope="col" class="text-center">{{$language::get('permission_access')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($role->permissions as $access)
                                    <tr permissao-id="permission_{{$access->permission->id}}" parent="{{$access->permission->parent}}">
                                        <th scope="row">{{$access->permission->label}}</th>
                                        <td class="text-center">
                                            <input type="checkbox" class="access" role_id="{{$role->id}}" permission_id="{{$access->permission->id}}"
                                            {{ ($access->is_allowed) ? 'checked="checked"' : '' }} data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                            data-on="{{$language::get('permission_access_is_alowed')}}" data-off="{{$language::get('permission_access_not_allowed')}}">
                                            <small class="alert-danger" id="role_{{$role->id}}_permission_{{$access->permission->id}}" style="display: none;"><br />{{$language::get('role_permission_update_error')}}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </fieldset>

            <div class="form-group row mt-5 justify-content-md-center">
                <div class="col-md-2">
                    <a href="{{route('role.index')}}">
                        <button type="button" class="btn btn-outline-secondary btn-block">
                            {{$language::get('return')}}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('.access').change(function(){
        var that = this;
        var is_allowed = $(this).is(':checked');
        $.post("{{route('role.access', $role->id)}}", {
            _token: '{{csrf_token()}}',
            role_id: $(this).attr('role_id'),
            permission_id: $(this).attr('permission_id'),
            is_allowed: is_allowed
        }, function (data) {
            if (!data.success) {
                $('#role_'+$(that).attr('role_id')+'_permission_'+$(that).attr('permission_id')).show();
            }
        });
    });

</script>

@endsection
