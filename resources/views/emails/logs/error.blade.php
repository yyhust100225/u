@component('mail::message')
# [{{ $exception->getCode() }}] Line:{{ $exception->getLine() }} {{ $exception->getFile() }}
## ***{{ $exception->getMessage() }}***

{{ $exception->getTraceAsString() }}

Thanks, {{ config('app.name') }}<br>
{{ \Illuminate\Support\Carbon::now()->toDateTimeString() }}
@endcomponent
