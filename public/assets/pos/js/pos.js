$(document).ready(function() {
    $('#main-category').on('change', function(e) {
        var main_id = e.target.value;
        $.ajax({
            url: "/admin/pos/sub-category",
            type: "POST",
            data: {
                main_id: main_id
            },
            success: function(data) {
                $('#sub-category').empty();
                $.each(data.sub_categories, function(index, sub) {
                    $('#sub-category').append('<option value="' + sub.id + '">' + sub.name + '</option>');
                })
                $('#product-show').empty();
                $.each(data.products, function(index, product) {
                    var sizes = [];
                    $.each(product.attributes[0].options, function(index, size) {
                        sizes.push(size.name);
                    });

                    // console.log(typeof(sizes));


                    $('#product-show').append(`<tr>`);
                    $('#product-show').append(`<td> <img src="${images_path}/${product.thumbnail}" style="max-height:20%; max-width:20%"></td>`);
                    $('#product-show').append(`<td> ${product.name} </td>`);
                    $('#product-show').append(`<td> ${product.stock} </td>`);
                    $('#product-show').append(`<td> ${product.discount_price} </td>`);
                    $('#product-show').append(`<td> <a 
                    id="product-${product.id}" 
                    data-name="${product.name}" 
                    data-id="${product.id}" 
                    data-price= "${product.discount_price}" 
                    data-sizes="${sizes}"
                    class="btn btn-success btn-sm add-product-btn" 
                    ><i class="fa fa-plus"></i> 
                    </a> </td>`);
                    $('#product-show').append(`</tr>`);

                });

            }
        })
    });
});


$(document).ready(function() {
    $('#sub-category').on('change', function(e) {
        var sub_id = e.target.value;

        $.ajax({
            url: "/admin/pos/sub-category/products",
            type: "POST",
            data: {
                sub_id: sub_id
            },
            success: function(data) {
                console.log(data.products);

                $('#product-show').empty();
                $.each(data.products, function(index, product) {
                    var sizes = [];
                    $.each(product.attributes[0].options, function(index, size) {
                        sizes.push(size.name);
                    });




                    $('#product-show').append(`<tr>`);
                    $('#product-show').append(`<td> ${product.name} </td>`);
                    $('#product-show').append(`<td> ${product.stock} </td>`);
                    $('#product-show').append(`<td> ${product.discount_price} </td>`);
                    $('#product-show').append(`<td> <a 
                    id="product-${product.id}" 
                    data-name="${product.name}" 
                    data-id="${product.id}" 
                    data-price= "${product.discount_price}" 
                    data-sizes="${sizes}"
                    class="btn btn-success btn-sm add-product-btn" 
                    ><i class="fa fa-plus"></i> 
                    </a> </td>`);
                    $('#product-show').append(`</tr>`);

                });

            }
        })
    });
});


$(document).ready(function() {

    //add product btn
    $('body').on('click', '.add-product-btn', function(e) {
        e.preventDefault();
        var name = $(this).data('name');
        var id = $(this).data('id');
        var price = $.number($(this).data('price'), 2);
        var sizes = $(this).data('sizes').split(',');
        var rand = Math.random();

        // console.log(sizes);
        // $(this).removeClass('btn-success').addClass('btn-default disabled');

        var html =
            `<tr>
                <td>${name}</td>
                <td>
                <input type="number" name="products[${id}-${rand}][quantity]" data-price="${price}" class="form-control input-sm product-quantity" min="1" value="1"></td>
               <input type="hidden" name="products[${id}-${rand}][id]" value="${id}">
                <td class="product-size">`;
        html += `<select name="products[${id}-${rand}][size]" class="form-control">`;
        if (sizes && sizes.length > 0) {
            for (let i = 0; i < sizes.length; i++) {
                html += `<option>${sizes[i]}</option> `
            }
        }

        html += `</select>
                </td>               
                <td class="product-price">${price}</td>               
                <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
            </tr>`;

        $('.order-list').append(html);

        //to calculate total price
        calculateTotal();
    });

    //disabled btn
    $('body').on('click', '.disabled', function(e) {

        e.preventDefault();

    }); //end of disabled

    //remove product btn
    $('body').on('click', '.remove-product-btn', function(e) {

        e.preventDefault();
        var id = $(this).data('id');

        $(this).closest('tr').remove();
        $('#product-' + id).removeClass('btn-default disabled').addClass('btn-success');

        //to calculate total price
        calculateTotal();

    }); //end of remove product btn

    //change product quantity
    $('body').on('keyup change', '.product-quantity', function() {

        var quantity = Number($(this).val()); //2
        var unitPrice = parseFloat($(this).data('price').replace(/,/g, '')); //150
        console.log(unitPrice);
        $(this).closest('tr').find('.product-price').html($.number(quantity * unitPrice, 2));
        calculateTotal();

    }); //end of product quantity change

    //list all order products
    $('.order-products').on('click', function(e) {

        e.preventDefault();

        $('#loading').css('display', 'flex');

        var url = $(this).data('url');
        var method = $(this).data('method');
        $.ajax({
            url: url,
            method: method,
            success: function(data) {

                $('#loading').css('display', 'none');
                $('#order-product-list').empty();
                $('#order-product-list').append(data);

            }
        })

    }); //end of order products click

    //print order
    $(document).on('click', '.print-btn', function() {

        $('#print-area').printThis();

    }); //end of click function

}); //end of document ready

//calculate the total
function calculateTotal() {

    var price = 0;

    $('.order-list .product-price').each(function(index) {

        price += parseFloat($(this).html().replace(/,/g, ''));

    }); //end of product price

    $('.total-price').html($.number(price, 2));

    //check if price > 0
    if (price > 0) {

        $('#add-order-form-btn').removeClass('disabled')

    } else {

        $('#add-order-form-btn').addClass('disabled')

    } //end of else

    var total_data = $('#total-val').html();
    $('#total-input').val(total_data);


} //end of calculate total



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$('#update-price').click(function(e) {
    e.preventDefault();

    var old_price = document.getElementById("total-input").value;
    var discount = document.getElementById("discount").value;
    var total_input = document.getElementById('total-div');
    var discount_input = document.getElementById('discount-val');
    var new_price = parseInt(old_price.replace(",", "")) - discount;

    discount_input.textContent = "total : " + new_price;
    total_input.style.display = "none";
    discount_input.style.display = "block";

});