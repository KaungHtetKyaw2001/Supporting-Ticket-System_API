@component('mail::message')
# Your ticket is updated

Some details about the ticket update...

@component('mail::button', ['url'=>'Link'])
    More Details
@endcomponent

Thanks, <br>
Laravel
@endcomponent