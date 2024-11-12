<style>
    .cart_name {
        max-width: 185px;
    }
    td.text-left a img {
       height: 30px;
}
</style>
@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
    $discount = Session::get('discount') ? Session::get('discount') : 0;
@endphp
<table class="cart_table table table-bordered table-striped text-center mb-0">
    <thead>
        <tr>
            <th style="width: 20%;">Delele</th>
            <th style="width: 40%;">Product</th>
            <th style="width: 20%;">Qty</th>
            <th style="width: 20%;">Price</th>
        </tr>
    </thead>

    <tbody>
        @foreach (Cart::instance('shopping')->content() as $value)
            <tr>
                <td>
                    <a href="{{ route('product', $value->options->slug) }}"><i class="fas fa-trash text-danger"></i></a>
                </td>
                <td class="text-left">
                    <a style="font-size: 14px;" href="{{ route('product', $value->options->slug) }}"><img
                            src="{{ asset($value->options->image) }}" height="30" width="30">
                        {{ Str::limit($value->name, 20) }}</a>
                </td>
                <td width="15%" class="cart_qty">
                    <div class="qty-cart vcart-qty">
                        <div class="quantity">
                            <button class="minus cart_decrement" data-id="{{ $value->rowId }}">-</button>
                            <input type="text" value="{{ $value->qty }}" readonly />
                            <button class="plus  cart_increment" data-id="{{ $value->rowId }}">+</button>
                        </div>
                    </div>
                </td>
                <td>৳{{ $value->price * $value->qty }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-end px-4">Total</th>
            <td>
                <span id="net_total"><span class="">৳ </span><strong>{{ $subtotal }}</strong></span>
            </td>
        </tr>
        <tr>
            <th colspan="3" class="text-end px-4">Delivery charg</th>
            <td>
                <span id="cart_shipping_cost"><span class="">৳ </span><strong>{{ $shipping }}</strong></span>
            </td>
        </tr>
         <tr>
            <th colspan="3" class="text-end px-4">Discount</th>
            <td class="px-4">
                <span id="cart_shipping_cost"><span class="">৳
                    </span><strong>{{ $discount + $coupon }}</strong></span>
            </td>
        </tr>
        <tr>
            <th colspan="3" class="text-end px-4">Total</th>
            <td>
                <span id="grand_total"><span class="">৳
                    </span><strong>{{ $subtotal + $shipping }}</strong></span>
            </td>
        </tr>
    </tfoot>
</table>

<script src="{{ asset('public/frontEnd/js/jquery-3.6.3.min.js') }}"></script>
<!-- cart js start -->
<script>
    $('.cart_remove').on('click', function() {
        var id = $(this).data('id');
        $("#loading").show();
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id
                },
                url: "{{ route('cart.remove_bn') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                        $("#loading").hide();
                    }
                }
            });
        }
    });

    $('.cart_increment').on('click', function() {
        var id = $(this).data('id');
        $("#loading").show();
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id
                },
                url: "{{ route('cart.increment_bn') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                        $("#loading").hide();
                    }
                }
            });
        }
    });

    $('.cart_decrement').on('click', function() {
        var id = $(this).data('id');
        $("#loading").show();
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id
                },
                url: "{{ route('cart.decrement_bn') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                        $("#loading").hide();
                    }
                }
            });
        }
    });

    function cart_count() {
        $.ajax({
            type: "GET",
            url: "{{ route('cart.count') }}",
            success: function(data) {
                if (data) {
                    $(".cart_header").html(data);
                } else {
                    $(".cart_header").empty();
                }
            }
        });
    };
</script>
<!-- cart js end -->
