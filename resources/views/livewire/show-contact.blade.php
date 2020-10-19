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
                <dt class="font-bold py-2">Email</dt>

                <dd>
                    <a href="mailto:{{$contact->email}}" class="link">
                        {{$contact->email}}
                    </a>
                </dd>
                <dt class="font-bold py-2">Telefon</dt>

                <dd>
                    <a href="tel:{{$contact->phone}}" class="link">
                    {{$contact->phone}}
                    </a>
                </dd>
                <dt class="font-bold py-2">Zpráva</dt>

                <dd>
                    {{$contact->body}}
                </dd>
            </dl>
        </x-dashboard-card>
    </div>
</div>
