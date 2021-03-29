<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$organizations->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('organization_trade')}}</th>
                        <th scope="col" class="text-center">{{$language::get('organization_branch')}}</th>
                        <th scope="col" class="text-center">{{$language::get('organization_identity_document')}}</th>
                        <th scope="col">{{$language::get('organization_contact')}}</th>
                        <th scope="col" class="text-center">{{$language::get('phone')}}</th>
                        <th scope="col" class="text-center">{{$language::get('organization_is_active')}}</th>
                        @can('organization.update')
                            <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($organizations as $organization)

                        <tr>
                            <th scope="row">{{$organization->trade}}</th>
                            <td class="text-center">{{$organization->branch ?? '-' }}</td>
                            <td class="text-center">{{$organization->identity_document ?? '-' }}</td>
                            <th scope="row">{{$organization->contact}}</th>
                            <td class="text-center">
                                @if (isset($organization->phone))
                                    {{$organization->phone->number}}
                                    <small>({{$organization->phone->type->name}})</small>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">{!! $organization->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                            @can('organization.update')
                                <td class="text-center">
                                    <a href="{{route('organization.edit', $organization->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('organization'))}} {{$organization->trade}}"><x-bi-pencil-square/></a>
                                </td>
                            @endcan
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" align="center">
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
    {!! $organizations->links() !!}
</div>