@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp 
@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.users.layouts.user-dash-layout'))

@section('title', 'Quotation')

@section('content')

    <body>
        <div>
            <a href="{{ route('quotation.index') }}" class="btn btn-primary">Back</a>
        </div>
        @foreach ($quotations as $quotation)
            @if ($quoid == $quotation->id)
                <div class="row justify-content-center">
                    <embed src="{{ $quotation->quotation_file }}" type="application/pdf" width="80%" height="1000px">
                </div>
            @endif
    </body>
    @endforeach
@endsection
