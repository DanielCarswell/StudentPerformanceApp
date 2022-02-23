@component('mail::message')
# Dealing with Depression

Dear {{  $message  }},
Dealing with Depression can be hard and mentally draining, there are many 
online sources that can advise you and help ease the burden.

Please check out NHS information on Depression linked below,
https://www.nhsinform.scot/illnesses-and-conditions/mental-health/depression

@component('mail::button', ['url' => route('homepage')])
Monitoring Student Performance
@endcomponent

Regards,<br>
       Monitoring Student Performance 
@endcomponent