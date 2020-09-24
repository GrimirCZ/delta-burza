<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Faktura - Daňový doklad</title>
        <link rel="stylesheet" href="{{public_path()."/css/invoice.css"}}">
    </head>
    <body>
        <h1 class="title">FAKTURA - DAŇOVÝ DOKLAD</h1>
        <div class="header">
            <table>
                <tbody>
                <tr>
                    <td>
                        <b>DELTA – Střední škola informatiky a ekonomie, s.r.o.</b>
                    </td>
                    <td class="text-right">
                        Daňový doklad číslo: <b>2020{{$order->id}}</b>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="company_info">
            <div class="company_info__wrapper">
                Dodavatel:
                <div class="company_info__content">
                    <div class="company_info__content__address">
                        DELTA-Střední škola informatiky a ekonomie s.r.o.<br/>
                        Ke Kamenci 151<br/>
                        530 03 Pardubice<br/>
                    </div>
                    <div class="company_info__content__ico">IČ: 62061178</div>
                </div>
            </div>
            <div class="company_info__wrapper second">
                Odběratel:
                <div class="company_info__content">
                    <div class="company_info__content__address">
                        {{$school->name}}<br/>
                        <div class="address_line">{{$school->address}}<br/></div>
                        <div class="address_line">{{$school->psc}} {{$school->city}}<br/></div>
                    </div>
                    <div class="company_info__content__ico">IČ: {{$school->ico}}</div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="receipt_info">
            <table>
                <tr>
                    <td>Peněžní ústav:</td>
                    <td class="text-right"><b>ČSOB Pardubice</b></td>
                    <td>Datum vystavení dokladu:</td>
                    <td class="text-right"><b>{{format_date_now()}}</b></td>
                </tr>
                <tr>
                    <td>Číslo účtu:</td>
                    <td class="text-right"><b>101831946/0300</b></td>
                    <td>Datum splatnosti:</td>
                    <td class="text-right"><b>{{format_date($order->due_date)}}</b></td>
                </tr>
            </table>
        </div>
        <div class="items">
            <p>Na základě objednávky on-line výstav středních škol a učilišť na portále BurzaŠkol.Online Vám fakturujeme
                následující výstavy</p>

            <table>
                <tbody>
                @foreach($order->ordered_registrations as $or)
                    <tr>
                        <td>{{$or->registration->exhibition->city}} ({{$or->registration->exhibition->name}}
                            ) {{format_date($or->registration->exhibition->date)}}</td>
                        <td class="text-right">
                            @if($or->price == 0)
                                zdarma
                            @else
                                {{$or->price}},- Kč
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2">
                        <div class="dashed-divider"></div>
                    </td>
                </tr>
                <tr>
                    <td>Celkem k platbě:</td>
                    <td class="text-right">
                        {{$order->price()}},- Kč
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="double-divider"></div>
            <div class="spacer"></div>
            <p>Nejsme plátci DPH</p>
        </div>
        <p class="contact-info">
            Vystavila: Alena Ferešová<br />
            tel.: <a href="tel:466 611 106">466 611 106</a><br />
            e-mail: <a href="mailto:alena.feresova@delta-skola.cz">alena.feresova@delta-skola.cz</a><br />
            Škola je zapsána vobchodním<br />
            rejstříku vedeném Krajským soudem vHradci Králové voddíle C, vložka 7239 ke dni 29. 11. 1994.
        </p>
    </body>
</html>
