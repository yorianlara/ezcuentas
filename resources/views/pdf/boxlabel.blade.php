<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pdf4</title>
	<style type="text/css">
		.tg {
			border-collapse: collapse;
			border-spacing: 0;
		}

		.tg td {
			border-color: black;
			border-style: solid;
			border-width: 1px;
			font-family: Arial, sans-serif;
			font-size: 14px;
			overflow: hidden;
			padding: 5px 5px;
			word-break: normal;
		}

		.tg th {
			border-color: black;
			border-style: solid;
			border-width: 1px;
			font-family: Arial, sans-serif;
			font-size: 14px;
			font-weight: normal;
			overflow: hidden;
			padding: 5px 5px;
			word-break: normal;
		}

		.tg .tg-cly1 {
			text-align: center;
			vertical-align: middle
		}

		.tg .tg-hjji {
			font-size: 24px;
			text-align: center;
			vertical-align: top
		}

		.tg .tg-baqh {
			text-align: center;
			vertical-align: top
		}

		.tg .tg-9l91 {
			font-size: 24px;
			font-weight: bold;
			text-align: left;
			vertical-align: top
		}

		.tg .tg-0lax {
			text-align: left;
			vertical-align: top
		}

		.tg .tg-0lak {
			text-align: left;
			vertical-align: bottom
		}
	</style>
</head>

<body>
	<table class="tg" width="100%">
		<thead>
			<tr>
				<th class="tg-9l91" colspan="4"
					style="border-top: none; border-right: none; border-bottom: none; border-left: none;">{{
					$product->sku }}</th>
				<th class="tg-baqh" style="border-top: none;">Reference:<br></th>
				<th class="tg-cly1" rowspan="3" style="border-top: none; border-bottom: none; border-right: none;">
					<img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/images/logos/casabianca_home_logo.png'))) }}" width="250px">
				</th>
			</tr>
			<tr>
				<th class="tg-0lax" colspan="4" style="border-top: none; border-right: none; border-left: none;">
					{{ $product->title }} <br>
					(Parts - {{ $parts }})
				</th>
				<th class="tg-baqh" style="border-bottom: none;"><br>QTY<br>1</th>
			</tr>
			<tr>
				<th class="tg-0lax" colspan="4" style="border-left: none;">{{ $dimentions }}</th>
				<th class="tg-0lax" style="border-top: none; border-right: none; border-left: none;"></th>
			</tr>
		</thead>
		<tbody>

			<tr>
				<td class="tg-baqh"
					style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
					<br><br><b>Length</b>
				</td>
				<td class="tg-baqh"
					style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
					<br><br><b>Width</b>
				</td>
				<td class="tg-baqh"
					style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
					<br><br><b>Height</b>
				</td>
				<td class="tg-baqh"
					style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
					<br><br><b>Weight</b>
				</td>
				<td class="tg-0lax"
					style="border-top: none; border-right: none; border-bottom: none; border-left: none;"><br><br></td>
				<td class="tg-cly1" rowspan="9" style="border-top: none; border-bottom: none; border-right: none;">
					<img src="{{ $image }}" width="300px">
				</td>
			</tr>

			<tr>
				<td class="tg-0lax">{{ $product->depth }}</td>
				<td class="tg-0lax">{{  $product->depth }}</td>
				<td class="tg-0lax">{{ $product->height }}&nbsp;in</td>
				<td class="tg-0lax">{{ $product->weight }}&nbsp;lbs</td>
				@php
					$cbf = (floatval( $product->depth) * floatval( $product->depth) * floatval($product->height))/1728;
					$cbf = round($cbf,3);
					$baseCM = 2.54;
					$baseKG = 0.45359237;
				@endphp
				<td class="tg-0lax"><b>CBF: </b>{{ $cbf }}</td>
			</tr>
			<tr>
				@php
					$depth = round(floatval($product->depth) * $baseCM,2);
					$height = round(floatval($product->height) * $baseCM,2);
					$weight = round(floatval($product->weight) * $baseCM,2);
					$kilos = round(floatval($product->weight) * $baseKG,2);
					$cbm = round(($depth * $height * $weight) / 1000000,3);
				@endphp
				<td class="tg-0lax">{{ $depth }}</td>
				<td class="tg-0lax">{{ $height }}</td>
				<td class="tg-0lax">{{ $weight }} cm</td>
				<td class="tg-0lax">{{ $kilos }} kg</td>
				<td class="tg-0lax"><b>CBM:</b> {{ $cbm }}</td>
			</tr>
			<tr>
				<td class="tg-0lax" colspan="3" style="border-top: none; border-right: none; border-bottom: none; border-left: none;"></td>
				<td class="tg-0lax" colspan="2" style="border-top: none; border-right: none; border-bottom: none;"></td>
			</tr>
			<tr>
				<td class="tg-hjji" colspan="3" style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
					<b>BOX {{ $cont }} of {{ $total }}</b>
				</td>
				<td class="tg-hjji" colspan="2" style="border-top: none; border-right: none; border-bottom: none;">
					<img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/images/ri_2.png'))) }}" style="width: 25px;">
					<b>WARNING:</b>
				</td>
			</tr>
			<tr>
				<td class="tg-cly1" colspan="3" style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
					<span style="font-size: 10px; color: red;">
						- FRAGILE HANDLE WITH CARE -
					</span>
				</td>
				<td class="tg-baqh" colspan="2" rowspan="3" style="border-top: none; border-bottom: none;">
					<p style="font-size: 16px;">
					This product can expose you to chemicals
					including Formaldehyde (gas) known to cause both cancer and birth defects or
					other reproductive harm, which is known to the State of California to cause cancer or birth
					defects or other reproductive harm. For more information go to<br>
					www.P65Warnings.ca.gov/furniture.
					</p>
				</td>
			</tr>
			<tr>
				<td class="tg-baqh" colspan="3" style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
					This shipment left our dock in perfect conditions. Upon arrival, please inspect for damage and incorrect quantity before signing.
				</td>
			</tr>
			<tr>
				<td class="tg-baqh" colspan="3" style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
					<span style="color: red;">
						ANY DAMAGE TO CONTENTS MUST BE NOTED ON BILL OF LADING FOR CLAIM AGAINST CARRIER.
					</span>
				</td>
			</tr>
			<tr>
				<td class="tg-0lak" colspan="3" style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
					DESIGNED IN USA<br>
					Made in China
				</td>
				<td class="tg-0lak" colspan="2" style="border-bottom: none;">
					Complies to California 93120<br>
					Phase 2 MDF<br>
					Made in China<br>
					<br>
					Production Date: 17/04/2024
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>