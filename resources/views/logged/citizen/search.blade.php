<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$citizens->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('citizen_name')}}</th>
                        <th scope="col">{{$language::get('citizen_email')}}</th>
                        <th scope="col" class="text-center">{{$language::get('citizen_identity_document')}}</th>
                        <th scope="col" class="text-center">{{$language::get('phone')}}</th>
                        <th scope="col" class="text-center">{{$language::get('citizen_is_active')}}</th>
                        @can('citizen.update')
                            <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($citizens as $citizen)

                        <tr>
                            <th scope="row">{{$citizen->name}}</th>
                            <td>{{$citizen->email}}</td>
                            <td class="text-center">{{$citizen->identity_document}}</td>
                            <td class="text-center">
                                @if (isset($citizen->phone))
                                    {{$citizen->phone->number}}
                                    <small>({{$citizen->phone->type->name}})</small>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">{!! $citizen->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                            @can('citizen.update')
                                <td class="text-center">
                                    <a href="{{route('citizen.edit', $citizen->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('citizen'))}} {{$citizen->name}}"><x-bi-pencil-square/></a>
                                </td>
                            @endcan
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" align="center">
                                {{$language::get('no_records_found')}}
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    {!! $citizens->links() !!}
</div>