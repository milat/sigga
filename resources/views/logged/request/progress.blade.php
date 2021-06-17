<div class="row">
    <div class="col-md-12">
        <fieldset>
            @can ('request.update')
                <div class="row">
                    <div class="col-12 col-md-2 offset-md-10 mb-2">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#progressModal">
                            {{$language::get('create')}}
                        </button>
                    </div>
                </div>
            @endcan

            <div class="row justify-content-center">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="">
                                    <th scope="col">{{$language::get('progress_description')}}</th>
                                    <th scope="col" class="text-center">{{$language::get('progress_created_by_user_id')}}</th>
                                    <th scope="col" class="text-center">{{$language::get('progress_created_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($request->progresses as $progress)

                                    <tr>
                                        <td>{{$progress->description}}</td>
                                        <td class="text-center">{{$progress->creator->email}}</td>
                                        <td class="text-center">{{ date('d/m/Y H:i:s', strtotime($progress->created_at)) }}</td>
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
        </fieldset>
    </div>
</div>

@can ('request.update')
    <div class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="progressModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('request.progress', $request->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{$language::get('create')}} {{$language::get('progress')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="progress_description" name="progress_description" rows="3" placeholder="{{$language::get('progress_description_placeholder')}}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            {{$language::get('insert')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcan