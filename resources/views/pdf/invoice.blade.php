<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>FAKTURA - DAŇOVÝ DOKLAD</title>
        <link rel="stylesheet" href="{{public_path()."/css/invoice.css"}}">
    </head>
    <body>
        <div class="title">
            <h1>FAKTURA - DAŇOVÝ DOKLAD</h1>
        </div>
        <div class="header">
            <table>
                <tbody>
                <tr>
                    <td colspan="6" style="font-size: 12px">
                        <b>DELTA – Střední škola informatiky a ekonomie, s.r.o.</b>
                    </td>
                    <td class="text-right" colspan="4">
                        Daňový doklad číslo:
                        <b>{{$order->invoice_year}}11{{fill_number_to_length($order->invoice_number, 4)}}</b>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="company_info">
            <table>
                <tr>
                    <td>
                        Dodavatel:
                        <div>
                            <div class="bold">
                                DELTA-Střední škola informatiky<br/> a ekonomie s.r.o.<br/>
                                Ke Kamenci 151<br/>
                                530 03 Pardubice<br/>
                            </div>
                            <div class="mt-8">IČ: <b>62061178</b></div>
                        </div>
                    </td>
                    <td>
                        Odběratel:
                        <div>
                            <div class="bold">
                                {{$school->name}}<br/>
                                {{$school->address}}<br/>
                                {{$school->psc}} {{$school->city}}<br/>
                            </div>
                            <div class="mt-8">IČ: <b>{{$school->ico}}</b></div>
                        </div>
                    </td>
                </tr>
            </table>
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
                    @if($or->price > 0)
                        <tr>
                            <td>{{$or->registration->exhibition->city}} ({{$or->registration->exhibition->name}})
                                {{format_date($or->registration->exhibition->date)}}</td>
                            <td class="text-right">
                                {{$or->price}},- Kč
                            </td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="2">
                        <div class="dashed-divider"></div>
                    </td>
                </tr>
                @php
                $price = $order->price();
                @endphp
                <tr>
                    <td>Celkem</td>
                    <td class="text-right">
                        {{$price}},- Kč
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="double-divider"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Odpočet zálohy dle zálohové faktury č. {{$order->proforma_invoice_number}}</b>
                    </td>
                    <td class="text-right">
                       <b>-{{$price}},- Kč</b>
                    </td>
                </tr>
                <tr class="mt-24">
                    <td><b>Celkem k platbě</b></td>
                    <td class="text-right">
                       <b>0,- Kč</b>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="double-divider"></div>
            <div class="spacer text-right">
                <img src="{{resource_path()."/imgs/sign.png"}}" class="img-small" alt="podpis">
            </div>
            <p>Nejsme plátci DPH</p>
        </div>
        <p class="contact-info">
            Vystavila: Alena Ferešová<br/>
            tel.: <a href="tel:466 611 106">466 611 106</a><br/>
            e-mail: <a href="mailto:alena.feresova@delta-skola.cz">alena.feresova@delta-skola.cz</a><br/>
            Škola je zapsána v obchodním rejstříku vedeném Krajským soudem v Hradci Králové v oddíle C, vložka 7239 ke
            dni 29. 11. 1994.
        </p>
    </body>
</html>
