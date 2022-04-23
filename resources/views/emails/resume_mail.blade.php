<p>Dear Concern,</p>
@php
    $data=$emailData['templateData'];
@endphp
<p>A candidate named <strong>{{ $data['full_name'] }}</strong> has applyed for <strong>{{ $data['designation'] }}</strong> position. Please check
    below:</p>

<p>Full Name: {{ $data['full_name'] }}</p>
<p>Email: {{ $data['email'] }}</p>
<p>Phone Number: {{ $data['phone_number'] }}</p>
<p>Designation: {{ $data['designation'] }}</p>
<p>Cover Letter:</p>
<p>{{ $data['cover_letter'] }}</p>

{{-- <p>Sincerely,
    <br>Stella Sanitary
    <br>ED.T. Road, Pahartali,
    <br>Chittagong, Bangladesh.</p> --}}
