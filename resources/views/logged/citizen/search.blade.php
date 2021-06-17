<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$citizens->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('citizen_name')}}</th>
                        <th scope="col" class="text-center">{{$language::get('phone')}}</th>
                        <th scope="col">{{$language::get('address_neighborhood')}}</th>
                        <th scope="col" class="text-center">{{$language::get('citizen_identity_document')}}</th>
                        <th scope="col" class="text-center">{{$language::get('citizen_is_active')}}</th>
                        <th scope="col" class="text-center">{{$language::get('citizen_dependents')}}</th>
                        @can('citizen.update')
                            <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                        @endcan
                        <th scope="col" class="text-center">{{$language::get('view')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($citizens as $citizen)

                        <tr>
                            <th scope="row" style="white-space: nowrap;">{{$citizen->name}}</th>
                            <td class="text-center" style="white-space: nowrap;">
                                <a href='javascript:;' class='copyme' title='{{$citizen->phone->type->name ?? ""}} ({{$language::get("copy_me")}})' data-id='{{$citizen->id}}' data='{{$citizen->phone->number ?? ""}}'>
                                    {{$citizen->phone->number ?? ''}}
                                    @if ($citizen->phone && $citizen->phone->type->name == 'WhatsApp')
                                        <img width='15px' src="{{ asset('images/whatsapp.png') }}" />
                                    @endif
                                </a>
                                <br />
                                <span id='copied_{{$citizen->id}}' style='color:green; display:none;'>Copiado <x-bi-check2-square/></span>
                            </td>
                            <td style="white-space: nowrap;">{{$citizen->address->neighborhood}}</td>
                            <td class="text-center" style="white-space: nowrap;">{{$citizen->identity_document}}</td>
                            <td class="text-center" style="white-space: nowrap;">{!! $citizen->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                            <td class="text-center">
                                <a href="{{route('citizen.dependent', $citizen->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('citizen'))}} {{$citizen->name}}"><x-bi-people-fill/> {{'('.$citizen->dependents->count().')'}}</a>
                            </td>
                            @can('citizen.update')
                                <td class="text-center">
                                    <a href="{{route('citizen.edit', $citizen->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('citizen'))}} {{$citizen->name}}"><x-bi-pencil-square/></a>
                                </td>
                            @endcan
                            <td class="text-center">
                                <a class='view' href='javascript:;' title="{{$language::get('view_me')}}" url='{{route("citizen.view", $citizen->id)}}' data-title="{{$citizen->name}}">
                                    <x-bi-eye/>
                                </a>
                            </td>
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
    {!! $citizens->links() !!}
</div>

@include('logged.common.script')

@include('logged.common.modal')

@include('logged.request.script_view_requester')