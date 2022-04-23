<p>Dear Concern,</p>
@php
    $templateData=$emailData['templateData']
@endphp
<p>A user named <strong>{{ $templateData['full_name'] }}</strong> has contacted using contact us form. Please check
    below:</p>

<p>Full Name: {{ $templateData['full_name'] }}</p>
<p>Email: {{ $templateData['email'] }}</p>
<p>Phone Number: {{ $templateData['phone_number'] }}</p>
{{-- <p>Subject: {{ $templateData['subject'] }}</p> --}}
<p>Message:</p>
<p>{{ $templateData['message'] }}</p>

{{-- <p>Sincerely,
    <br>Stella Sanitary
    <br>ED.T. Road, Pahartali,
    <br>Chittagong, Bangladesh.</p> --}}
