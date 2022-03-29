@component('mail::message')
# Student grade is low

Dear Lecturer,

This is an automated message to notify you early that
your student: {{ $user->fullname }}'s grade is too low for {{  $message  }}, Please reach out to 
them if they need any help.

Current Class Grade: {{$score}}

@component('mail::button', ['url' => route('homepage')])
Monitoring Student Performance
@endcomponent

Regards,<br>
       Monitoring Student Performance 
@endcomponent
