@component('mail::message')
# Your ticket is deleted

Some details about the ticket delete...

@component('mail::button', ['url'=>'Link'])
    More Details
@endcomponent

Thanks, <br>
Laravel
@endcomponent