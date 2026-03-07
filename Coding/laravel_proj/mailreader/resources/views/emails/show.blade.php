<h2>{{ $email->subject }}</h2>
<p><b>From:</b> {{ $email->from_email }} ({{ $email->from_name }})</p>
<p><b>Date:</b> {{ $email->mail_date }}</p>
<hr>
<div>{!! $html !!}</div>
<hr>
<h4>Attachments:</h4>
<ul>
@foreach ($normalAttachments as $att)
    <li><a href="{{ asset($att->path) }}" target="_blank">{{ $att->filename }}</a></li>
@endforeach
</ul>