<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tear Sheet</title>

</head>
<h1 style="position: relative; color: #676767; writing-mode: vertical-lr;
transform: rotate(-90deg); margin: -100px 400px auto -650px;">{{ strtoupper($producto->name) }}</h1>

<body>
    <table style="width: 100%;">
        <tr>
            <td>
                <img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/images/lineaspdf-02.png'))) }}" 
                    style="margin: -55px auto auto -45px; position: absolute;">
                <img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/images/logos/casabianca_home_logo.png'))) }}" 
                    style="margin-left: -50px; position: absolute; z-index: 999;" width="300px">
            </td>
            <td style="width: 30%!important;">
                <img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/images/lineaspdf-01.png'))) }}" 
                    style="margin: -40px auto auto -130px; position: absolute;">
                <p style="margin: auto auto auto -50px; position: absolute; ">
                    <b><u>PRODUCT DETAILS</u></b>
                </p>
                <p style="margin: 25px auto auto -50px; position: absolute; text-align: left; ">
                    <b>Size:</b> {{ intval($producto->width) }}" W X {{ intval($producto->depth) }}" D X {{intval($producto->height) }}" H
                    <br>
                    <b>Weigth:</b> {{ intval($producto->weight) }} lbs
                    <br>
                    @foreach ($producto->attributes as $attributes )
                     <b>{{ $attributes->attribute->name }}:</b> {{ $attributes->values->name }} <br>
                    @endforeach
                    
                    <b>Country of Origin:</b> {{ $producto->origin->name }}
                    <br>
                    <br>
                    <b><u>MATERIALS</u></b>
                    <br>
                    @foreach ($producto->pmc as $pmc )
                     {{ $pmc->part->name }}: {{ $pmc->material->name }} <br>
                    @endforeach
                    <br>
                    <b><u>PRODUCT DETAILS</u></b>
                    <br>
                    <table>
                        <td>
                            <th>Box</th>
                            <th>Dimensions</th>
                            <th>Lbs</th>
                        </td>
                        @foreach ($producto->product_shipping_detail as $box )
                    </table>

                    Box|&nbsp;&nbsp;&nbsp;Dimensions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|
                    Lbs
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;1 | 99 L x 46 W x 9 H in&nbsp;&nbsp;&nbsp;| 80
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;2 | 95 L x 17 W x 12 H in&nbsp;| 85
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;3 | 77 L x 42 W x 2 H in&nbsp;&nbsp;&nbsp;| 72
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;4 | 80 L x 77 W x 2 H in&nbsp;&nbsp;&nbsp;| 70
                </p>


                <p style="margin: 550px auto auto -50px; position: absolute; ">
                    <b><u>LTL PALLET DIMENSIONS</u></b>
                </p>
                <p style="margin: 580px auto auto -50px; position: absolute; text-align: left; ">
                    Class: 250
                    <br>
                    X-Large | 96 L x 40 W x 80 H in | 398 lbs
                </p>


                <p style="margin: 660px auto auto -50px; position: absolute; text-align: left; font-size: 12px;">
                    All product specifications, statements, information and data in this datasheet or made
                    available on the website are subject to change.
                </p>

                <p style="margin: 700px auto auto 30px; position: absolute; text-align: left; font-size: 12px;">
                    Latest revision: 7/24/2024
                </p>


            </td>
        </tr>

        <tr>
            <td>
                <img src="{{ $image }}" style="margin-top: 60px; margin-left: 80px; position: absolute; width: 50%;">

                <!--<h1 style="position: absolute; color: #676767; writing-mode: vertical-lr;
transform: rotate(-90deg); margin: 300px auto auto -80px; font-size: 30px;">{{ strtoupper($producto->name) }}</h1>-->

                <div style="position: absolute; margin: 570px auto auto 50px; text-align: left;">
                    <h3>{{ $producto->sku }}</h3>
                    <p>{{ $producto->title }}<br>
                    {{ intval($producto->width) }}" W X {{ intval($producto->depth) }}" D X {{
                        intval($producto->height) }}" H</p>
                </div>

            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
    </table>
</body>

</html>