<h1>Zpráva uchazeče prostřednictvím portálu BurzaŠkol.Online</h1>

<p>
    @if(isset($contact->name))
        Jméno: <span id="name">{{$contact->name}}</span><br/>
    @endif
    @if(isset($contact->email))
        Email: <span id="email">{{$contact->email}}</span><br/>
    @endif
    @if(isset($contact->phone))
        Telefon: <span id="phone">{{$contact->phone}}</span><br/>
    @endif
    @if(isset($contact->registration_id))
        @php
            $exhibition = $contact->registration->exhibition;
        @endphp
        Výstava: <span>{{format_date($exhibition->date)}} - {{$exhibition->city}} ({{$exhibition->name}})</span>
        @if($exhibition->organizer_id != 1)
            <br><span><pre>&#9;</pre>Pořadatel: {{$exhibition->organizer->short_name}}</span>
        @endif
    @endif
</p>

@if(isset($contact->body))
    <p>
        Zpráva:<br/>
        <span class="message">{{$contact->body}}</span>
    </p>
@endif

<p>
    DELTA - Střední škola informatiky a ekonomie, s.r.o.,<br/>
    Provozovatel portálu: BurzaŠkol.Online<br/>
    Ke Kamenci 151, 530 03 Pardubice<br/>
    <a href="https://www.delta-skola.cz">www.delta-skola.cz</a>, <a href="mailto:info@delta-skola.cz">info@delta-skola.cz</a>,
    <a href="tel:466 611 106">466 611 106</a>
</p>
