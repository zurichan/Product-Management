$(document).ready(() => {

    // VARIABLES DECLARATIONS
    var remove_product = Array.from(document.querySelectorAll('.remove-product'));
    var update_product = Array.from(document.querySelectorAll('.update-product'));
    var product_id = Array.from(document.querySelectorAll('.product_id'));
    var product_name = Array.from(document.querySelectorAll('.product_name'));

    // REMOVING A PRODUCT
    remove_product.forEach((product, i) => {

        $(product).click(() => {

            swal({
                title: "Removing Product: " + product_name[i].innerHTML,
                text: "Once deleted, you will not be able to recover.",
                icon: "warning",
                closeOnClickOutside: false,
                buttons: true,
                dangerMode: true,

            }).then((willDelete) => {

                if (willDelete) {

                    var remove_product = 'pass';

                    $.ajax({
                        type: 'POST',
                        url: '../process validation/process-product.php',
                        data: {
                            remove_product: remove_product,
                            product_id: product_id[i].innerHTML
                        }
                    })

                    swal("Poof! Your Product has been deleted!", {
                        icon: "success",
                        closeOnClickOutside: false
                    });

                    $('.swal-button--confirm').click(() => {
                        document.location.reload();
                    })

                } else {
                    swal("Your Product is safe!");
                }
            });
        });
    });

    // UPDATING A PRODUCT
    update_product.forEach((product, i) => {

        $(product).click(() => {

            var index = i + 1;
            var product_name = $('#' + index).children('td[data-target=product_name]').text();
            var orig_price = $('#' + index).children('td[data-target=product_price]').text();
            var product_stocks = $('#' + index).children('td[data-target=product_stocks]').text();
            var product_id = $('#' + index).children('td[data-target=product_id]').text();
           
            var price_2 = orig_price.replace('.00', '');
            var price = price_2.replace('₱', '');

            // pop-up update modal
            $('#updating-product_id').val(product_id);            
            $('#update_product_name').val(product_name);
            $('#update_product_price').val(price);
            $('#update_product_stock').val(product_stocks);

            $('#update-product').modal('toggle');
        });
    })
})