@extends('maxim.layouts.layouts')
@section('title','IPO Maxim')
@section('print-body')

	<center>
		<a href="#" onclick="myFunction()" class="print">Print & Preview</a>
	</center>


	@foreach($buyerDetails as $details)
		<div class="row header-top-a">
			<div class="col-md-2 col-sm-2">

			</div>
			<div class="col-md-8 col-sm-8 buyerName">
				<h2 align="center">{{$details->buyer_name}}</h2>
			</div>
			<div class="col-md-2 col-sm-2"></div>
		</div>
	@endforeach
	<div class="row header-bottom">
		<div class="col-md-12 col-sm-12 header-bottom-b">
			<span>Internal Purchase Order</span>
		</div>
		<hr>
	</div>

	<div class="row body-top">
		<div class="col-md-6 col-sm-6 col-xs-7 body-list">
			@foreach($buyerDetails as $details)
				<ul>
					<li><strong>Booking ID: {{$details->booking_order_id}}</strong></li>
					<li><strong>Company Name: {{$details->buyer_name}}</strong></li>
					<li><h5>Date : {{Carbon\Carbon::now()->format('Y-m-d')}}</h5></li>
				</ul>
			@endforeach
		</div>

		<div class="col-md-6 col-sm-6 col-xs-5 valueGenarate">
			@php ($i=0)
			@foreach ($sentBillId as $billdata)
				@for($i;$i <= 0;$i++)
				<table class="tables table-bordered">
					<tr>
						<td colspan="2">
							<div>
								<p>MAY PORTION</p>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<p>Booking No : {{$billdata->ipo_id}}</p>
							</div>
						</td>
					</tr>
				</table>
			@endfor
			@endforeach

		</div>
	</div>
<table class="table table-bordered mainBody">
    <thead>
    	<tr>
        	<th width="5%">SI</th>
        	<th width="10%">PO/CAT</th>
        	<th width="10%">Item code</th>
        	<th width="15%">Description</th>
        	<th width="10%">Size</th>
        	<th width="10%">TOTAL PCS/MTR</th>
        	<th width="10%">{{$increase}}%</th>
        	<th width="10%">1ST DELIVERY</th>
            <th width="10%">Request Date</th>
            <th width="10%">Confirmation Date</th>
        </tr>
    </thead>
    <tbody>
    	<?php
    		$j = 1;
    		$totalAllQty = 0;
    		$totalAllIncrQty = 0;
    		$totalUsdAmount = 0;
    		$BDTandUSDavarage = 80;
    		$rowspanValue = 0;
    	 ?>
    	 	@foreach($sentBillId as $counts)
    	 		<?php
    	 			$count = 1;
    	 			$rowspanValue += $count;
    	 		 ?>
    	 	@endforeach

    		@foreach ($sentBillId as $key => $item)

    			<?php
    				$i = 0;
    				$k = 0;
    				$totalQty =0;
    				$totalIncrQty = 0;
    				$itemsize = explode(',', $item->item_size);
    				$qty = explode(',', $item->item_quantity);
                    $itemQuaInc = explode(',', $item->initial_increase);

    				$itemlength = 0;
    				foreach ($itemsize as $itemlengths) {
    					$itemlength = sizeof($itemlengths);
    				}
    				$itemQtyValue = array_combine($itemsize, $qty);
    			?>


	    			<tr>
	    				<td>{{$j++}}</td>
	    				<td rowspan="{{$itemlength}}">{{$item->poCatNo}}</td>
	    				<td rowspan="{{$itemlength}}">{{$item->item_code}}</td>
	    				<td rowspan="{{$itemlength}}">{{$item->erp_code}}</td>
			    			@if ($itemlength >= 1 )
				    			<td colspan="2" class="colspan-td">
				    				<table >
				    					@foreach ($itemQtyValue as $size => $Qty)
				    					<?php
				    						$i++;
				    						$totalQty += $Qty;
				    					?>
				    					<tr>
				    						<td width="50%">{{$size}}</td>
							    			<td width="50%">{{$Qty}}</td>
				    					</tr>
				    					@endforeach

				    					@if( $i > 1 )
				    					<tr>
				    						<td></td>
				    						<td width="100%">{{$totalQty}}</td>
				    					</tr>
				    					@endif
				    				</table>
				    			</td>
				    			<td class="colspan-td">
				    			<div class="middel-table">
				    				<table>
				    					@foreach ($itemQtyValue as $size => $Qty)
				    					<?php
				    						$k++;
				    						$totalIncrQty += ceil(($Qty*$itemQuaInc[$k-1])/100 + $Qty);
				    					?>
				    					<tr>
							    			<td style="padding:5px;" width="100%">{{ceil(($Qty*$itemQuaInc[$k-1])/100 + $Qty)}} ({{ $itemQuaInc[$k-1] }}%)</td>
				    					</tr>
				    					@endforeach

				    					@if( $k > 1 )
				    					<tr>
				    						<td width="100%">{{$totalIncrQty}}</td>
				    					</tr>
				    					@endif
				    				</table>
				    				</div>
				    			</td>
				    		@endif
			    		<?php
    						$totalAllQty += $totalQty;
    						$totalAllIncrQty += $totalIncrQty;
    					?>
    					<td></td>
    					<td style="padding-top: 20px;">
    						{{Carbon\Carbon::parse($billdata->created_at)->format('d-m-Y')}}
    					</td>
    					<td></td>
	    			</tr>
    		@endforeach

    	<tr>
			<td colspan="5">
				<div class="grandTotal" style="">
					<span>GRAND TOTAL</span>
				</div>
			</td>
			<td>{{$totalAllQty}}</td>
			<td>{{$totalAllIncrQty}}</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="10">
				<p><strong>Remarks: TAKE GOODS FROM STOCK WITH {{$increase}}%</strong></p>
			</td>
		</tr>

		<tr>
			<td colspan="10">
				<h6>1. Quality confirm to sample card</h6>
			</td>
		</tr>

		 <tr>
		 	<td colspan="10">
		 		<h6>2. Please pack as the enclosed background and mark the styleNo. on the parcel or carton.</h6>
		 	</td>
		 </tr>

    	<tr>
			<td colspan="3"><strong>PrintShop: </strong></td>
			<td colspan="2"><strong>QC: </strong></td>
			<td colspan="2"><strong>CS Superviser: </strong></td>
			<td colspan="3"><strong>CS: </strong></td>
		</tr>
	</tbody>
</table>

<script type="text/javascript">
	function myFunction() {
		$('.colspan-td table').css('font-family','arial, sans-serif');
		$('.colspan-td table').css('border-collapse','collapse');
		$('.colspan-td table').css('width','100%');
		$('.colspan-td table td').css('border','1px solid #DBDBDB');
		$('.colspan-td table td').css('padding','5px');
		$('.colspan-td table tr:first-child td').css('border-top', '0');
		$('.colspan-td table tr td:first-child').css('border-left', '0');
		$('.colspan-td table tr:last-child td').css('border-bottom', '0');
		$('.colspan-td table tr td:last-child').css('border-right', '0');
	    window.print();
	}
</script>
@endsection
