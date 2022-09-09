@extends('layouts.app')

@section('title','آپلود فایل')
@section('links')
<link rel="stylesheet" href="{{asset('css/style.css')}}">

@section('content')
<div class="table-users">
    <div class="header">Printed AME Data Table</div>
    <table cellspacing="0">
      <thead class="fixedHeader">
        <tr>
          <th>نام فایل</th>
          <th width="100px">نوع فایل</th>
          <th>حجم فایل</th>
          <th>زمان فایل</th>
          <th>سطح دسترسی</th>
          <th>عملیات</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($files as $file)
        <tr>
            <td>{{$file->name}}</td>
            <td>{{$file->type}}</td>
            <td>{{number_format($file->size / (1024 * 1024),2)}} مگابایت</td>

            @if(is_null($file->time))
            <td>ندارد</td>
            @else
            <td>{{$file->time}}ثانیه</td>
            @endif

            @if($file->is_private)
            <td>خصوصی</td>
            @else
            <td>عمومی</td>
            @endif

            <td><a href="{{route('file.show',$file->id)}}">دانلود</a></td>
            <td><a href="{{route('file.delete',$file->id)}}">حذف</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
