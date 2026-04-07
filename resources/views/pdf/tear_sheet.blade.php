<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tear Sheet</title>
</head>

<body>
    <div style="text-align:left; margin-bottom: 20px;">
        <img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/images/logos/casabianca_home_logo.png'))) }}" 
            style="width:300px; height:auto;">
    </div>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <!-- Columna 1: Título vertical -->
                <td style="width:4%; vertical-align:middle; text-align:center; background-color: #dfdcdc;">
                <div style="
                    display:block;
                    transform: rotate(-90deg);
                    transform-origin: center center;
                    white-space: nowrap;
                    color:#000;
                    font-size:28px;
                    ">
                    {{ strtoupper($producto->name) }}
                </div>
                </td>


            <!-- Columna 2: Imagen + datos -->
            <td style="width:56%; vertical-align:top; padding:20px;">
            <img src="{{ $image }}" style="max-width:100%; height:auto;">
            <div style="margin-top:12px; text-align:left;">
                <h3 style="margin:0 0 6px 0;">{{ $producto->sku }}</h3>
                <p style="margin:0;">
                {{ $producto->title }}<br>
                {{ intval($producto->width) }}" W × {{ intval($producto->depth) }}" D × {{ intval($producto->height) }}" H
                </p>
            </div>
            </td>

            <!-- Columna 3: Detalles -->
            <td style="width:40%; vertical-align:top; padding:20px; font-size:14px; text-align:left;">
            @if ($producto->attributes && count($producto->attributes))  
            <div style="margin-bottom:12px;"><b><u>PRODUCT DETAILS</u></b></div>
            <div style="margin-bottom:12px;">
                <b>Size:</b> {{ intval($producto->width) }}" W × {{ intval($producto->depth) }}" D × {{ intval($producto->height) }}" H <br>
                <b>Weight:</b> {{ intval($producto->weight) }} lbs <br>
                @foreach ($producto->attributes as $attributes)
                <b>{{ $attributes->attribute->name }}:</b> {{ $attributes->values->name }} <br>
                @endforeach
                <b>Country of Origin:</b> {{ $producto->origin->name }}
            </div>
            @endif
            @if ($producto->pmc && count($producto->pmc))
            <div style="margin-bottom:8px;"><b><u>MATERIALS</u></b></div>
            <div style="margin-bottom:12px;">
                @foreach ($producto->pmc as $pmc)
                {{ $pmc->part->name }}: {{ $pmc->material->name }} <br>
                @endforeach
            </div>
            @endif

            @if ($producto->product_shipping_detail && !empty($producto->product_shipping_detail->shipping_detail))
                <!-- SHIPPING DETAILS -->
                <div style="margin-bottom:8px;"><b><u>SHIPPING DETAILS</u></b></div>
                <table style="width:100%; border-collapse:collapse; font-size:12px; text-align:center;" border="1">
                    <thead>
                        <tr><th>Box</th><th>Dimensions</th><th>Lbs</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($producto->product_shipping_detail->shipping_detail as $shipping_detail)
                            <tr>
                                <td>{{ $shipping_detail->box_content_id ?? '' }}</td>
                                <td>{{ intval($shipping_detail->large ?? 0) }} L × {{ intval($shipping_detail->width ?? 0) }} W × {{ intval($shipping_detail->height ?? 0) }} H in</td>
                                <td>{{ intval($shipping_detail->lbs ?? 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- PALLET DIMENSIONS -->
                <div style="margin-top:12px;"><b><u>{{ optional($producto->product_shipping_detail->ship_via)->name ?? '' }} PALLET DIMENSIONS</u></b></div>
                <div style="margin-bottom:12px;">
                    Class: {{ $producto->product_shipping_detail->freight_class ?? '' }} <br>
                    {{ optional($producto->product_shipping_detail->pallet)->name ?? '' }} |
                    {{ intval(optional($producto->product_shipping_detail->pallet)->pallet_l ?? 0) }} L ×
                    {{ intval(optional($producto->product_shipping_detail->pallet)->pallet_w ?? 0) }} W ×
                    {{ intval(optional($producto->product_shipping_detail->pallet)->pallet_h ?? 0) }} H in |
                    {{ intval($producto->product_shipping_detail->pallet_lbs ?? 0) }} lbs
                </div>
            @endif


            <div style="font-size:12px;">
                All product specifications, statements, information and data in this datasheet or made
                available on the website are subject to change. <br>
                Latest revision: 7/24/2024
            </div>
            </td>
        </tr>
    </table>
</body>
</html>
