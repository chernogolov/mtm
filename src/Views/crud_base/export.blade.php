@php $orm_resources = [] @endphp
@foreach($res->export_fields as $key)
    @if($res->fields->$key->type == 'orm')
        @php $ext = json_decode($res->fields->$key->ext) @endphp
        @foreach($ext->fields as $field_name => $title)
            @php $orm_resources[$key] = $field_name; @endphp
        @endforeach
    @endif
@endforeach

<table>
    <thead>
    <tr>
        @foreach($res->export_fields as $k)
            <th class="bg-green-100 " style="@if(in_array($res->fields->$k->type, ['gallery', 'rich_text', 'files'])) width: 500px; @else width:100px; @endif " ><strong>{{$k}}</strong></th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @php $count = 0 @endphp
    @foreach($data as $item)
        <tr>
            @foreach($res->export_fields as $key)
                <td class="px-6 py-4 border border-gray-200">
                    @if($res->fields->$key->type == 'text_editor')
                        {!! $item->$key !!}
                    @elseif($res->fields->$key->type == 'list')
                        @php $ext = json_decode($res->fields->$key->ext); $list = []; $v = $item->$key; @endphp
                        @if(isset($ext->list))
                            {{$v}}
                        @endif
                    @elseif($res->fields->$key->type == 'gallery' || $res->fields->$key->type == 'files')
                        @foreach((array)json_decode($item->$key) as $i)
                            {{asset('storage/' . $i)}}
                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach
                    @elseif($res->fields->$key->type == 'orm')
                        @php $k = $orm_resources[$key] @endphp
                        @if(isset($orm_resources[$key]) && isset($item->$key->$k))
                            {{$item->$key->$k}}
                        @else
                            @foreach($item->$key as $v)
                                {{$v->id}}@if(!$loop->last), @endif
                            @endforeach
                        @endif
                    @elseif($res->fields->$key->type == 'integer')
                        {{floatval($item->$key)}}
                    @else
                        {{strval($item->$key)}}
                    @endif
                </td>
            @endforeach
        </tr>
        @php $count = $count + 1 @endphp
    @endforeach
    <tr>
        <td class="px-6 py-4 border border-gray-200" colspan="{{count((array)$res->fields)}}"><strong>Итого:&nbsp;{{$count}}</strong></td>
    </tr>
    </tbody>
</table>
