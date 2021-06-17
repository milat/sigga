@extends('layouts.app')

@section('content')

    <div class="container mt-2 pt-2">

        <div class="row mb-3">
            <div class="col-12 col-md-8 col-lg-10">
                <h2>
                    {{$language::get('dependents')}}
                    @can('citizen.update')
                        <td class="text-center">
                            <a href="{{route('citizen.edit', $citizen->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('citizen'))}} {{$citizen->name}}">{{$citizen->name}}</a>
                        </td>
                    @else
                        {{$citizen->name}}
                    @endcan
                </h2>
            </div>
            @can('citizen.insert')
                <div class="col-12 col-md-4 col-lg-2">
                    <a href="{{route('citizen.dependent.create', $citizen->id)}}">
                        <button type="button" class="btn btn-primary btn-block">{{$language::get('create')}}</button>
                    </a>
                </div>
            @endcan
        </div>

        <div class="row justify-content-center">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <caption>{{$citizen->dependents->count()}} {{$language::get('records_found')}}</caption>
                        <thead>
                            <tr class="table-info">
                                <th scope="col">{{$language::get('dependent_name')}}</th>
                                <th scope="col" class="text-center">{{$language::get('phone')}}</th>
                                <th scope="col">{{$language::get('dependent_birth')}}</th>
                                <th scope="col">{{$language::get('dependent_identity_document')}}</th>
                                <th scope="col" class="text-center">{{$language::get('dependent_is_active')}}</th>
                                @can('citizen.update')
                                    <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($citizen->dependents as $dependent)

                                <tr>
                                    <th scope="row" style="white-space: nowrap;">{{$dependent->name}}</th>
                                    <td class="text-center" style="white-space: nowrap;">
                                        <a href='javascript:;' class='copyme' title='{{$dependent->phone->type->name ?? ""}} ({{$language::get("copy_me")}})' data-id='{{$dependent->id}}' data='{{$dependent->phone->number ?? ""}}'>
                                            {{$dependent->phone->number ?? ''}}
                                            @if ($dependent->phone && $dependent->phone->type->name == 'WhatsApp')
                                                <img width='15px' src="{{ asset('images/whatsapp.png') }}" />
                                            @endif
                                        </a>
                                        <br />
                                        <span id='copied_{{$dependent->id}}' style='color:green; display:none;'>Copiado <x-bi-check2-square/></span>
                                    </td>
                                    <td style="white-space: nowrap;">{{ date('d/m/Y', strtotime($dependent->birth)) }} ({{$dependent->age()}} anos)</td>
                                    <td style="white-space: nowrap;">{{$dependent->identity_document}}</td>
                                    <td class="text-center" style="white-space: nowrap;">{!! $dependent->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                                    @can('citizen.update')
                                        <td class="text-center">
                                            <a href="{{route('citizen.dependent.edit', [$citizen->id, $dependent->id])}}" title="{{$language::get('edit')}} {{strtolower($language::get('citizen'))}} {{$citizen->name}}"><x-bi-pencil-square/></a>
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
    </div>

@endsection
