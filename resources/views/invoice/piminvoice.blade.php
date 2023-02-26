@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp 
@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.saffs.layouts.saff-dash-layout'))

@section('title', 'Supplier')

@section('content')

    <body>
        <div>
            <a href="{{ route('invoice.index') }}" class="btn btn-primary">Back</a>
        </div>
        @foreach ($invoices as $invoice)
            @if ($invoiceid == $invoice->id)
                <div class="row justify-content-center">
                    <embed src="{{ $invoice->invoices_file }}" type="application/pdf" width="80%" height="1000px">
                </div>
            @endif
    </body>
    @endforeach
@endsection
