<option value="">-- Select --</option>
@foreach ($datas as $data)
<option value="{{$data->id}}">{{$data->name}}</option>
@endforeach