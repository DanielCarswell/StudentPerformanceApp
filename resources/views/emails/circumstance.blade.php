@component('mail::message')

Dear {{  $user->fullname  }},
{{  $information  }}

Please check out information on {{  $cirname  }} linked below,

@foreach($links as $link)
       {{$link->link}}
@endforeach


@component('mail::button', ['url' => route('homepage')])
Monitoring Student Performance
@endcomponent

Regards,<br>
       Monitoring Student Performance 
@endcomponent