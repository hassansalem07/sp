@extends('master.back')

@section('content')




<div class="content-wrapper">

    <section class="content-header">

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class="mb-0 bc-title"><b>Order Products</b></h3>
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
                          <th>{{ __(' Name') }}</th>
                          <th>{{ __('Quantity') }}</th>
                          <th>{{ __('Sizes') }}</th>
                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{$product->item->name}}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td>{{$product->sizes}}</td>
                                    
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
