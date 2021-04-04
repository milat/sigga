<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$organizations->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('organization_trade')}}</th>
                        <th scope="col" class="text-center">{{$language::get('phone')}}</th>
                        <th scope="col">{{$language::get('organization_contact')}}</th>
                        <th scope="col" class="text-center">{{$language::get('organization_branch')}}</th>
                        <th scope="col" class="text-center">{{$language::get('organization_identity_document')}}</th>
                        <th scope="col" class="text-center">{{$language::get('organization_is_active')}}</th>
                        @can('organization.update')
                            <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        @endcan
                        <th scope="col" class="text-center">{{$language::get('view')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($organizations as $organization)

                        <tr>
                            <th scope="row" style="white-space: nowrap;">{{$organization->trade}}</th>
                            <td class="text-center" style="white-space: nowrap;">
                                <a href='javascript:;' class='copyme' title='{{$organization->phone->type->name ?? ""}} ({{$language::get("copy_me")}})' data-id='{{$organization->id}}' data='{{$organization->phone->number ?? ""}}'>
                                    {{$organization->phone->number ?? ''}}
                                    @if ($organization->phone && $organization->phone->type->name == 'WhatsApp')
                                        <img width='15px' src="{{ asset('images/whatsapp.png') }}" />
                                    @endif
                                </a>
                                <br />
                                <span id='copied_{{$organization->id}}' style='color:green; display:none;'>Copiado <x-bi-check2-square/></span>
                            </td>
                            <th scope="row" style="white-space: nowrap;">{{$organization->contact}}</th>
                            <td class="text-center" style="white-space: nowrap;">{{$organization->branch ?? '-' }}</td>
                            <td class="text-center" style="white-space: nowrap;">{{$organization->identity_document ?? '-' }}</td>
                            <td class="text-center" style="white-space: nowrap;">{!! $organization->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                            @can('organization.update')
                                <td class="text-center">
                                    <a href="{{route('organization.edit', $organization->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('organization'))}} {{$organization->trade}}"><x-bi-pencil-square/></a>
                                </td>
                            @endcan
                            <td class="text-center">
                                <a class='view' href='javascript:;' title="{{$language::get('view_me')}}" url='{{route("organization.view", $organization->id)}}' data-title="{{$organization->trade}}">
                                    <x-bi-eye/>
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" align="center">
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

@include('logged.common.script')

@include('logged.common.modal')

@include('logged.request.script_view_requester')