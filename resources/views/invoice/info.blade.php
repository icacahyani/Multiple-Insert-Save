@extends('include.include')
@section('content')
	<div class="continer">
		<section class="panel">
			<div class="panel panel-footer">
				<header class="panel panel-default">
					<h3>Sale To ..	</h3>
				</header>
			</div>
			<div class="panel panel-footer">
				{!! Form::open(array('route' => 'create', 'id' => 'frmsave' , 'method' => 'post')) !!}
					<div class="row">
						<div class="col-lg-6 col-sm-6">
							<div class="form-group">
								<input type="text" name="fn" class="form-control" placeholder="First Name">
							</div>
						</div>
						<div class="col-lg-6 col-sm-6">
							<div class="form-group">
								<input type="text" name="ln" class="form-control" placeholder="Last Name">
							</div>
						</div>
						<div class="col-lg-6 col-sm-2">
							<div class="form-group">
								<select name="sex" class="form-control">
									<option value="0" selected="true" disabled="true">Gender</option>
									<option value="1">Male</option>
									<option value="2">Female</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-sm-4">
							<div class="form-group">
								<input type="text" name="email" class="form-control" placeholder="Email">
							</div>
						</div>
						<div class="col-lg-3 col-sm-3">
							<div class="form-group">
								<input type="text" name="phone" class="form-control" placeholder="Phone">
							</div>
						</div>

						<div class="col-lg-3 col-sm-3">
							<div class="form-group">
								<input type="text" name="location" class="form-control" placeholder="Location">
							</div>
						</div>

						<div class="col-lg-2 col-sm-2">
							<div class="form-group">
								{!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
							</div>
						</div>
						<div class="col-lg-12 col-sm-12">
							<table class="table table-bordered">
								<thead>
									<th>Product Name</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Dis</th>
									<th>Amount</th>
									<th style="text-align: center"><a href="#" class="add"><i class="glyphicon glyphicon-plus"></i></a></th>
								</thead>
								<tbody>
									<tr>
										<td>
											<select name="productname[]" class="form-control productname">
												<option value="0" selected="true" disabled="true">Select Product</option>
												@foreach($product_list as $key => $p)
													<option value="{!! $key !!}">{!! $p !!}</option>
												@endforeach
											</select>
										</td>
										<td><input type="number" name="qty[]" class="form-control qty"></td>
										<td><input type="number" name="price[]" class="form-control price" readonly style="background-color: white;"></td>
										<td><input type="number" name="dis[]" class="form-control dis"></td>
										<td><input type="text" name="amount[]" class="form-control amount" readonly style="background-color: white;"></td>
										<td><a href="#" class="btn btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a></td>
									</tr>
								</tbody>
								<tfoot>
									<td colspan="3"></td>
									<td><b>Total</b></td>
									<td class="total"></td>
								</tfoot>
							</table>
						</div>
					</div>
				{!! Form::hidden('_token', csrf_token()) !!}
				{!! Form::close()!!}
			</div>
		</section>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript">

		$('tbody').delegate('.productname', 'change', function(){
			var tr = $(this).parent().parent();
			var id = tr.find('.productname').val();
			var dataId = {'id':id};
			$.ajax({
				type		: 	'GET',
				url			: 	'{!! URL::route('findPrice') !!}',
				dataType	: 	'json',
				data 		: 	dataId,
				success:function(data){
					tr.find('.price').val(data.price);
				}
			});
		});
		
		$('tbody').delegate('.productname', 'change', function(){
			var tr = $(this).parent().parent();
			tr.find('.qty').focus();	
		});

		// Menampilkan data
		$('tbody').delegate('.qty, .price, .dis', 'keyup', function () {
			var tr = $(this).parent().parent();
			var qty = tr.find('.qty').val();
			var price = tr.find('.price').val();
			var dis = tr.find('.dis').val();
			var amount = (qty * price) - (qty * price * dis)/100;
			tr.find('.amount').val(amount);
			total();
		})

		// menghitung total amount
		function total() {
			var total = 0;
			$('.amount').each(function(i, e){
				var amount = $(this).val()-0;
				total += amount;
			})
			$('.total').html('Rp. '+ total.formatMoney());
		};

		// format uang untuk di total
		Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator){
			var n = this,
				decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2: decPlaces,
				decSeparator = decSeparator == undefined ? "." : decSeparator,
				thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
				sign = n < 0 ? "-" : "",
				i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
				j = (j = i.length) > 3 ? j % 3 : 0;
			return sign + (j ? i.substr(0, j) + thouSeparator : "")
			+ i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator);
		};

		// menampilkan fungsi tambah
	    $(function () {
	        $('.add').click(function () {
				var tambah = '<tr>'+
								'<td>'+
									'<select name="productname[]" class="form-control productname">'+
										'<option value="0" selected="true" disabled="true">Select Product</option>'+
										'@foreach($product_list as $key => $p)'+
											'<option value="{!! $key !!}">{!! $p !!}</option>'+
										'@endforeach'+
									'</select>'+
								'</td>'+
								'<td><input type="number" name="qty[]" class="form-control qty"></td>'+
								'<td><input type="number" name="price[]" class="form-control price" readonly style="background-color: white;"></td>'+
								'<td><input type="number" name="dis[]" class="form-control dis"></td>'+
								'<td><input type="text" name="amount[]" class="form-control amount" readonly style="background-color: white;"></td>'+
								'<td><a href="#" class="btn btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a></td>'+
							  '</tr>';
				$('tbody').append(tambah);
			});

	        // fungsi hapus form
			$('tbody').delegate('.delete', 'click', function () {
				var leng = $('tbody tr').length;
				if (leng == 1) {
					alert('You Can not Remove Last One ');
				}else{
	            	$(this).parent().parent().remove();
	            	total();
	            }
	        });
	    });
	</script>
@endsection