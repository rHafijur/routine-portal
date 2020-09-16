@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Notifications') }} <b>({{Auth::user()->notification()->where('is_seen',0)->get()->count()}} new)</b></div>

                <div class="card-body">
                    <table class="table">
                        @foreach ($notifications as $notification)
                        <tr>
                            <td>{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</td>
                            <td>
                                <a @if($notification->is_seen==0) style="color:red" @endif href="{{url($notification->link."/?ref=".$notification->id)}}">{{$notification->subject}}</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
