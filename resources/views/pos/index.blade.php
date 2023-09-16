@extends('master.back')

@section('content')




<div class="content-wrapper">

    <section class="content-header">

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class="mb-0 bc-title"><b>Pos Orders</b></h3>
                    <h3 class="mb-0 bc-title"><a class="btn btn-primary" href="pos/create">New Order</a></h3>
                    </div>
            </div>
        </div>

    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">@lang('order')</h3>
                    </div><!-- end of box header -->
                    <div class="box-body">
                    
                        <div class="gd-responsive-table">
                            <table class="table table-bordered table-striped" id="admin-table" width="100%" cellspacing="0">
            
                                <thead>
                                    <tr>
                          <th>{{ __('Order ID') }}</th>
                          <th>{{ __('Sub Total') }}</th>
                          <th>{{ __('Discount') }}</th>
                          <th>{{ __('Total') }}</th>
                          <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pos_orders as $order)
                                    <tr>
                                        <td>{{$order->transaction_number}}</td>
                                        <td>{{$order->sub_total}}</td>
                                        <td>{{$order->discount}}</td>
                                        <td>{{$order->total}}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{'pos/products/'.$order->id}}">Details</a>
                                            <a class="btn btn-primary" href="{{'pos/invoice/'.$order->id}}">Invoice</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
            
                            </table>
                        </div>

                    </div><!-- end of box body -->
                </div><!-- end of box -->
            </div><!-- end of col -->
        </div><!-- end of row -->
    </section><!-- end of content -->
</div><!
@endsection
