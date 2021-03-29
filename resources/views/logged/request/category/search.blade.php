<div class="row justify-content-center">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover">
                <caption>{{$categories->total()}} {{$language::get('records_found')}}</caption>
                <thead>
                    <tr class="table-info">
                        <th scope="col">{{$language::get('category_name')}}</th>
                        <!-- <th scope="col" class="text-center">{{$language::get('category_colour')}}</th> -->
                        <th scope="col" class="text-center">{{$language::get('category_is_active')}}</th>
                        <th scope="col" class="text-center">{{$language::get('edit')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)

                        <tr>
                            <th scope="row">{{$category->name}}</th>
                            <!-- <th class="text-center" style="background-color: {{$category->colour}}"></th> -->
                            <td class="text-center">{!! $category->is_active ? $language::get('active') : "<span class='inactive'>".$language::get('inactive')."</span>"!!}</td>
                            <td class="text-center">
                                <a href="{{route('category.edit', $category->id)}}" title="{{$language::get('edit')}} {{strtolower($language::get('category'))}} '{{$category->name}}'"><x-bi-pencil-square/></a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" align="center">
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
    {!! $categories->links() !!}
</div>