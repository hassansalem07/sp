@extends('master.back')

@section('content')




<div class="content-wrapper">

    <section class="content-header">

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class="mb-0 bc-title"><b>Add New Order</b></h3>
                    </div>
            </div>
        </div>

    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-4">

                <div class="box box-primary">

                    <div class="box-header">

                        <h3 class="box-title" style="margin-bottom: 10px">@lang('categories')</h3>

                    </div><!-- end of box header -->

                    <div class="box-body">

                           
                                
                         
                            <div class="panel-group">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <label for="main-category">Main Categories</label>
                                        <br>
                                        @if (!empty($categories))
                                        <select class="form-group col-10" name="main_category" id="main-category">
                                            @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @else
                                        no categories
                                        @endif

                                    </div>
                                    <div class="panel-heading mt-3">
                                        <label for="sub-category">Sub Categories</label>
                                        <br>
                                        @if (!empty($categories))
                                        <select class="form-group col-10" name="sub_category" id="sub-category">
                                        </select>
                                        @else
                                        no categories
                                        @endif
                                    </div>
                                </div><!-- end of panel primary -->
                            </div><!-- end of panel group -->

                    </div><!-- end of box body -->

                </div><!-- end of box -->
{{-- <select name="sizes" id="" multiple>
    @foreach ($sizes as $size)
    <option value="{{$size->name}}">{{$size->name}}</option>
    @endforeach
</select> --}}

            </div><!-- end of col -->
            <div class="col-md-8">
                <div class="box box-primary">

                    <div class="box-header">

                        <h3 class="box-title">Peoducts</h3>
                        <div class="panel-body">

                            @if(isset($category))
                            @if ($category->items->count() > 0)

                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>@lang('Image')</th>
                                        <th>@lang('name')</th>
                                        <th>@lang('stock')</th>
                                        <th>@lang('price')</th>
                                        <th>@lang('add')</th>
                                    </tr>
                                </thead>
                                    @foreach ($category->items as $product)
                                    <?php
                                    $att = \App\Models\Attribute::where('item_id',$product->id)->first();
                                    if(!empty($att->options)){
                                        $sizes = $att->options()->where('stock','>',0)->pluck('name');
                                    } else {
                                        $sizes = null;
                                    }
                                    ?>
                                        <tbody id="product-show">
                                        </tbody>
                                    @endforeach

                                </table><!-- end of table -->

                            @else
                                <h5>@lang('site.no_records')</h5>
                            @endif
                            @endif
                        </div>

                    </div><!-- end of box header -->

                    <div class="box-body">
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header">

                        <h3 class="box-title">@lang('order')</h3>

                    </div><!-- end of box header -->

                    <div class="box-body">

                        <form action="{{route('pos.store')}}" method="post">

                            {{ csrf_field() }}
                            {{ method_field('post') }}

                            {{-- @include('partials._errors') --}}

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>@lang('product')</th>
                                    <th>@lang('quantity')</th>
                                    <th>@lang('size')</th>
                                    <th>@lang('price')</th>
                                    <th>@lang('Delete')</th>
                                </tr>
                                </thead>

                                <tbody class="order-list">

                                </tbody>

                            </table>
                            <!-- end of table -->
                            <div class="row">
                                <div class="col-8" id="total-div">
                                    <h4>@lang('total') : <span id="total-val" class="total-price">0</span></h4>
                                    <input id="total-input" type="hidden" name="sub_total" value="">
                                </div>
                                <div class="col-8" id="discount-val" style="display: none;">
                                    <h4>@lang('total') : <span id="total-val" class="total-price">0</span></h4>
                                    <input id="discount-input" type="hidden" name="after_discount" value="">
                                </div>
                                <div class="col-4">
                                    <label>Discount</label>
                                    <input name="discount" id="discount" required class="form-control" type="number" min="0" value="0">
                                </div>
                            </div>
                                <div class="row justify-content-end mt-1">
                                    <div class="col-4">
                                        <button class="btn btn-primary" id="update-price" type="submit">update price</button>
                                    </div>
                                </div>
                                <div class="row justify-content-first mt-1">
                                    <div class="col-4">
                                        <label  for="notes"><span>Additional Notes</span></label>
                                        <textarea name="notes" id="notes" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-block disabled" id="add-order-form-btn"><i class="fa fa-plus"></i> add order</button>
                        </div>
                        </form>

                    </div><!-- end of box body -->

                </div><!-- end of box -->

                {{-- @if ($client->orders->count() > 0)

                    <div class="box box-primary">

                        <div class="box-header">

                            <h3 class="box-title" style="margin-bottom: 10px">@lang('site.previous_orders')
                                <small>{{ $orders->total() }}</small>
                            </h3>

                        </div><!-- end of box header -->

                        <div class="box-body">

                            @foreach ($orders as $order)

                                <div class="panel-group">

                                    <div class="panel panel-success">

                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#{{ $order->created_at->format('d-m-Y-s') }}">{{ $order->created_at->toFormattedDateString() }}</a>
                                            </h4>
                                        </div>

                                        <div id="{{ $order->created_at->format('d-m-Y-s') }}" class="panel-collapse collapse">

                                            <div class="panel-body">

                                                <ul class="list-group">
                                                    @foreach ($order->products as $product)
                                                        <li class="list-group-item">{{ $product->name }}</li>
                                                    @endforeach
                                                </ul>

                                            </div><!-- end of panel body -->

                                        </div><!-- end of panel collapse -->

                                    </div><!-- end of panel primary -->

                                </div><!-- end of panel group -->

                            @endforeach

                            {{ $orders->links() }}

                        </div><!-- end of box body -->

                    </div><!-- end of box -->

                @endif --}}

            </div><!-- end of col -->

        </div><!-- end of row -->

    </section><!-- end of content -->

</div>



@endsection
