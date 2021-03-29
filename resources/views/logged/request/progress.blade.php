<div class="row">
    <div class="col-md-12">
        <fieldset>
            @can ('request.update')
                <form method="POST" action="{{ route('request.progress', $request->id) }}">
                    <div class="row">
                        @csrf
                        <div class="col-10">
                            <div class="form-group">
                                <textarea class="form-control" id="progress_description" name="progress_description" rows="1" placeholder="{{$language::get('progress_description_placeholder')}}"></textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{$language::get('insert')}}
                            </button>
                        </div>
                    </div>
                </form>
            @endcan

            <div class="row justify-content-center">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="">
                                    <th scope="col">{{$language::get('progress_description')}}</th>
                                    <th scope="col" class="text-center">{{$language::get('progress_user_id')}}</th>
                                    <th scope="col" class="text-center">{{$language::get('progress_created_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($request->progresses as $progress)

                                    <tr>
                                        <td>{{$progress->description}}</td>
                                        <td class="text-center">{{$progress->user->email}}</td>
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