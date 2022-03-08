@component('mail::message')

Dear {{  $message  }},
{{  $circumstance->information  }}

Please check out information on {{  $circumstance->name  }} linked below,

@foreach($links as $link)
       echo $link;
@endforeach


@component('mail::button', ['url' => route('homepage')])
Monitoring Student Performance
@endcomponent

Regards,<br>
       Monitoring Student Performance 
@endcomponent