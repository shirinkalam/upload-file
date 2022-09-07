@extends('layouts.app')

@section('title','آپلود فایل')

@section('content')

<div>
    <div>
        <div>
            @include('partials.alerts')
        </div>
        <div>
            <div></div>
            <div>
                <form action="{{route('file.new')}}" method="POST">
                    @csrf
                    <div>
                        <div>
                            <input type="file" name="file">
                            <label for="file">فایل خود را انتخاب کنید</label>
                        </div>
                    </div>
                    <div>
                        <div>
                            <input type="checkbox" name="is-private">
                            <label for="is-private">به صورت خصوصی آپلود شود</label>
                        </div>
                    </div>
                    <div>
                        <div>
                            <button type="submit">آپلود فایل</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
