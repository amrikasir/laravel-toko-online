@extends('admin.layout.app')

@section('css')
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
	$('input[name="dates"]').daterangepicker({
		open: 'left',
	}, function(start, end, label) {
		var start = start.format('YYYY-MM-DD');
		var end = end.format('YYYY-MM-DD');
		window.location.href = "{{ route('admin.history') }}?start="+start+"&end="+end +"&page={{ $page }}";
	});
</script>
@endsection

@section('content')
</head>
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-home"></i>
                </span> Pesanan
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col">
                                <h4 class="card-title">Data Pesanan Perlu Di Cek</h4>
                            </div>
                        </div>

						<input type="text" name="dates" class="" />
                        
						<div class="table-responsive">
                            <table class="table table-bordered table-hovered" id="_table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>No Invoice</th>
                                        <th>Pemesan</th>
                                        <th>Total</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Status Pesanan</th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach($data as $order)
										<tr>
											<td>{{ (($page - 1) * $limit) + $loop->iteration }}</td>
											<td>{{ $order->invoice }}</td>
											<td>{{ $order->user->name }}</td>
											<td align="right">{{ $order->subtotal }}</td>
											<td>{{ $order->metode_pembayaran }}</td>
											<td>{{ $order->status_order->name }}</td>
										</tr>
									@endforeach
                                </tbody>
                            </table>
                        </div>
						{{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
