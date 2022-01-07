@component('mail::message')
# Your grade is low

This is an automated message to notify you early that
your grade is too low for {{  $message  }}, Please reach out if you need
any help.

@component('mail::button', ['url' => route('homepage')])
Monitoring Student Performance
@endcomponent

Regards,<br>
       Monitoring Student Performance 
@endcomponent
