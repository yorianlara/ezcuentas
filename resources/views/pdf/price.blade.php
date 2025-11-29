<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Price List</title>
		<style>
		/** Define the margins of your page **/
		@page {
			margin: 80px 25px;
		}
		table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
			border: 1px solid #e3e3e3!important;
        }
        .categoria {
            background: #f4f4f4;
            text-align: left;
            font-weight: bold;
            padding: 10px;
        }
        .img-producto {
            float: left;
            margin-right: 10px;
        }
        .detalle {
            font-size: 10px;
        }
		header {
			position: fixed;
			top: -100px;
			left: 0px;
			right: 0px;
			height: 80px;

			/** Extra personal styles **/
			/* background-color: #03a9f4; */
			/* color: white; */
			text-align: center;
			line-height: 35px;
		}
	</style>

</head>
<header>
	<table style="width: 100%;">
		<!--CONTENIDO TOP-->
		<tr>
			<th style="width: 33%; border: 0 !important;">
				<img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/images/logos/casabianca_home_logo.png'))) }}" width="250px">
			</th>
			<th style="width: 33%; border: 0 !important;">
				<p>
					Price List<br>
					<span>{{ Carbon\Carbon::now()->format('m/d/Y') }}</span>
				</p>
			</th>
			<th style="width: 33%; text-align:right; border: 0 !important;">
				<img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/images/logos/qr_chk_stk.png'))) }}" width="98px">
			</th>
		</tr>
		<!--CONTENIDO TOP-->
	</table>
</header>

<main>
	<table style="width: 100%;">
		@php
		$categoria = "";
		@endphp
		@foreach ($productos as $product)
		@if ($categoria != $product["category"])
		<!--BARRA ARRIBA GRIS-->
		<tr style="background: #f4f4f4;">
			<th colspan="5" style="text-align: center; padding: 15px;">
				{{ strtoupper($product["category"]) }}
			</th>
		</tr>
		<!--BARRA ARRIBA GRIS-->
		@php
		$categoria = $product["category"];
		@endphp
		@endif
		<!--REGISTRO-->
		<tr style="word-break: break-all; width: 100%!important;">
			<th style="width: 10%!important;">
				@if ($product["cover_image"] != '' && $product["cover_image"] != null)
					@php
						$image = explode(".",basename($product["cover_image"]));
						$url = "https://dataloggers.nyc3.digitaloceanspaces.com/muebles/1/products/thumbs/{$image[0]}.jpg";
						$imgCont = @file_get_contents($url);
					@endphp
					<img src="data:image/png;base64, {{ base64_encode($imgCont) }}" style="position: absolute; padding-left: 10px;" width="50px">
					{{-- <img src="{{ $url }}" style="position: absolute; padding-left: 10px;" width="50px"> --}}
				@endif
			</th>
			<th style="width: 30%!important;">
				<p style="text-align: left; font-size: 10px;">
					<span>{{ $product["sku"] }}</span>
					<br>
					<span>{{ $product["title"] }}</span>
					<br>
					<span>{{ $product["sizes"] }}</span>
				</p>
			</th>
			<th style="width: 20%!important;">
				<p style="text-align: center; font-size: 12px;">
					<span>{{ $product["color"] }}</span>
				</p>

			</th>
			<th style="width: 20%!important;">
				<p style="text-align: center; font-size: 12px;">
					<span>{{ $product["stock_available"] }}</span>
				</p>
			</th>
			<th style="border: 1px solid #e3e3e3!important; width: 20%!important;">
				<p style="text-align: center;">
					<span>{{ number_format($product["wholesale_price"],2) }}</span>
				</p>
			</th>
		</tr>
		<!--REGISTRO-->
		@endforeach
	</table>
</main>

</html>