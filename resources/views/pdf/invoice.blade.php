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
        <h1 class="title">FAKTURY - DAŇOVÝ DOKLAD</h1>
        <div class="header">
            <b>DELTA – Střední škola informatiky a ekonomie, s.r.o.</b>
            Daňový doklad číslo: <b>2020####</b>
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
            <div class="company_info__wrapper">
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
    </body>
</html>
