@component('mail::message')
# Your grade is low

Dear {{$user->fullname}},

This is an automated message to notify you early that
your grade is too low for {{  $message  }}, Please reach out if you need
any help.

Current Class Grade: {{$score}}

Regards,<br>
       Monitoring Student Performance 
@endcomponent
