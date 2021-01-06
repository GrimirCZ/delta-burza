<div>
    <x-own-header>
        Zpráva od {{$contact->name}}
    </x-own-header>

    <div class="py-4">
        <x-dashboard-card>
            <dl>
                <dt class="font-bold py-2">Jméno</dt>

                <dd>
                    {{$contact->name}}
                </dd>
                @if($school->email != null)
                    <dt class="font-bold py-2">Email</dt>

                    <dd>
                        <a href="mailto:{{$contact->email}}" class="link">
                            {{$contact->email}}
                        </a>
                    </dd>
                @endif
                @if($school->phone != null)
                    <dt class="font-bold py-2">Telefon</dt>

                    <dd>
                        <a href="tel:{{$contact->phone}}" class="link">
                            {{$contact->phone}}
                        </a>
                    </dd>
                @endif

                <dt class="font-bold py-2">Čas</dt>

                <dd>
                    {{format_datetime($contact->created_at)}}
                </dd>

                @if($contact->registration_id != null)
                    <dt class="font-bold py-2">Z výstavy</dt>
                    <dd>
                        @php
                            $ex = $contact->registration->exhibition;
                        @endphp
                        <a href="/vystava/{{$ex->id}}" class="link">
                            {{format_date($ex->date)}} - {{$ex->city}} ({{$ex->name}})
                        </a>
                    </dd>
                @endif

                <dt class="font-bold py-2">Zpráva</dt>

                <dd>
                    {{$contact->body}}
                </dd>
            </dl>
        </x-dashboard-card>
    </div>
</div>
