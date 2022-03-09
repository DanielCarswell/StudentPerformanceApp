@component('mail::message')
# Your current grade

Dear {{$user->fullname}},

This is an automated message to notify you of your current overall grade

Current Grade: {{$score}}



@component('mail::button', ['url' => route('homepage')])
Monitoring Student Performance
@endcomponent

Regards,<br>
       Monitoring Student Performance 
@endcomponent