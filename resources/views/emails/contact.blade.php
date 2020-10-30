<h1>Zpráva uchazeče prostřednictvím portálu BurzaŠkol.Online</h1>

<div>
    @if(isset($contact->name))
        <p>
            Jméno: <span id="name">{{$contact->name}}</span>
        </p>
    @endif
    @if(isset($contact->email))
        <p>
            Email: <span id="email">{{$contact->email}}</span>
        </p>
    @endif
    @if(isset($contact->phone))
        <p>
            Telefon: <span id="phone">{{$contact->phone}}</span>
        </p>
    @endif
    @if(isset($contact->registration_id))
        @php
            $exhibition = $contact->registration->exhibition;
        @endphp
        <div>
            Výstava: <span>{{format_date($exhibition->date)}} - {{$exhibition->city}} ({{$exhibition->name}})</span>
            @if($exhibition->organizer_id != 1)
                <div style="padding-left: 4em">Pořadatel: {{$exhibition->organizer->short_name}}</div>
            @endif
        </div>
    @endif
</div>

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
