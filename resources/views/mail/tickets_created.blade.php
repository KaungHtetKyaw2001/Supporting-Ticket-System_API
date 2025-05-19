@component('mail::message')
# Your ticket is created

Some details about the ticket create...

@component('mail::button', ['url'=>'Link'])
    More Details
@endcomponent

Thanks, <br>
Laravel
@endcomponent
