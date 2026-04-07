<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Box Label</title>

</head>

<body>

	<img src="{{URL::asset('assets/images/line.png')}}"
		style="position: absolute; margin-left: 573px; margin-top: -150px;">
	<table>
		<tr>

			<th style="border: 1px solid black; width: 70%; text-align: left;">
				<h2 style="padding: 7px;">{{ $product->sku }}</h2>
				<p style="padding-left: 7px;">
					{{ $product->title }} <br>
					(Parts - {{ $parts }})
				</p>
				<p style="border-top: 1px solid black; padding-top: 20px; padding-left: 7px;">
					{{ $dimentions }}
				</p>
			</th>

			<th style="border: 1px solid black; width: 70%;">
				<p style="padding: 7px;">Reference</p>
				<h4 style="border-top: 1px solid black; padding-top: 20px;">
					QTY
					<br>
					1
				</h4>
			</th>

			<th style="padding-left: 150px;">
				<div>
					<img src="{{URL::asset('assets/images/logos/casabianca_home_logo.png')}}" style="width: 300px;">
					<br>
				</div>
			</th>

		</tr>

		<tr>
			<th></th>
			<th>
				<div
					style="position: absolute; margin-top: -10px!important; margin-left:60.5px; color: transparent!important;">
					1<br>111</div>
			</th>
		</tr>
		<tr>
			<th></th>
			<th></th>
			<th>
				<div>
					<img src="{{ $image }}" style="width: 300px; position: absolute; padding-left: 200px;">
				</div>
			</th>
		</tr>
		<tr>
			<div>
				<table style="width: 100%;">

					<tr>
						<th>Length</th>
						<th>Width</th>
						<th>Height</th>
						<th>Weight</th>
						<th></th>
					</tr>

					<tr>
						<th style="border: 1px solid black!important; padding: 15px;">
							<span>63</span>
						</th>

						<th style="border: 1px solid black!important; padding: 15px;">
							<span>63</span>
						</th>

						<th style="border: 1px solid black!important; padding: 15px;">
							<span>4 <span style="font-size: 10px;">IN</span></span>
						</th>

						<th style="border: 1px solid black!important; padding: 15px;">
							<span>155 <span style="font-size: 10px;">LBS</span></span>
						</th>

						<th style="border: 1px solid black!important; padding: 15px;">
							<span>CBF: 9.188</span>
						</th>

					</tr>


					<tr>
						<th style="border: 1px solid black!important; padding: 15px;">
							<span>160</span>
						</th>

						<th style="border: 1px solid black!important; padding: 15px;">
							<span>160</span>
						</th>

						<th style="border: 1px solid black!important; padding: 15px;">
							<span>10 <span style="font-size: 10px;">CM</span></span>
						</th>

						<th style="border: 1px solid black!important; padding: 15px;">
							<span>70 <span style="font-size: 10px;">KG</span></span>
						</th>

						<th style="border: 1px solid black!important; padding: 15px;">
							<span>CBM: 0.260</span>
						</th>

					</tr>

				</table>
			</div>
			<th></th>
			<th style="margin-left: 50px; position: absolute; padding-top: -20px;"></th>
		</tr>

		<tr>
			<th></th>
			<th>
				<div
					style="position: absolute; margin-top: -10px!important; margin-left:60.5px; color: transparent!important;">
					1<br>111</div>
			</th>


		</tr>

		<tr style="border: 1px solid black;">
			<div style="position: absolute;">
				<table style="width: 35%;">
					<tr style="border: 1px solid black;">
						<th style="border-left: 1px solid black!important; border-right: 1px solid black!important;">
							<h3>Box&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; of
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2</h3>

							<h6 style="color: red;">- FRAGILE HANDLE WITH CARE -</h6>
							<p>This shipment left our dock in perfect
								conditions. Upon arrival, please inspect
								for damage and incorrect quantity
								before signing.</p>

							<h6 style="color: red;">ANY DAMAGE TO CONTENTS MUST
								BE NOTED ON BILL OF LADING FOR
								CLAIM AGAINST CARRIER</h6>

							<h6 style="text-align: left; padding-left: 30px;">
								DESIGNED IN USA


							</h6>
							<h6 style="text-align: left; padding-left: 30px;">

								Made in China

							</h6>
						</th>




						<th>

							<div
								style="padding-top: -100px!important; position: absolute; width: 35%; /*border-right: 1px solid black;*/ padding-left: 1px; padding-right: 1px;">
								<h3>
									<img src="{{URL::asset('assets/images/warning.png')}}" width="20px">
									WARNING:
								</h3>
								<p style="font-size: 10px; text-align: center;">WARNING:
									<br>
									This product can expose you to
									chemicals including Formaldehyde
									(gas) known to cause both cancer
									and birth defects or other
									reproductive harm, which is known to
									the State of California to cause
									cancer or birth defects or other
									reproductive harm. For more
									information go to www.P65Warnings.
									ca.gov/furniture
								</p>

								<p style="text-align: left; padding-left: 10px;">Complies to California 93120</p>
								<p style="text-align: left; padding-left: 10px;">Phase 2 MDF</p>
								<p style="text-align: left; padding-left: 10px;">Made in China</p>
								<p style="text-align: left; padding-left: 10px;">Production
									Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span>7/4/2024</span></p>
							</div>



						</th>

						<th></th>

					</tr>
				</table>
			</div>
		</tr>


	</table>



</body>

</html>