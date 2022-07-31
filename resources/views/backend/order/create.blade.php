<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-validation-errors />
            <x-success-message />
            <div class="flex items-center justify-end mt-4 mb-4">
                <a href="{{ route('orders') }}">
                    <x-button class="ml-3">
                        {{ __('Back to List') }}
                    </x-button>
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col">
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="order_list">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-base font-bold text-gray-500 uppercase tracking-wider">
                                                        Product
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-base font-bold text-gray-500 uppercase tracking-wider">
                                                        Price
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-base font-bold text-gray-500 uppercase tracking-wider">
                                                        Quantity
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-right text-base font-bold text-gray-500 uppercase tracking-wider">
                                                        Sub Total
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-right text-base font-bold text-gray-500 uppercase tracking-wider">
                                                        <x-button class="ml-3 add_product_row">
                                                            {{ __('Add Product') }}
                                                        </x-button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 newProductRow">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                        <select id="product_id" name="product_id[]"
                                                            class="block w-full mt-1 product_id">
                                                            <option value="Choose Product" selected>Choose Product
                                                            </option>
                                                            @foreach ($products as $product)
                                                                <option data-price={{ $product->price }}
                                                                    value="{{ $product->id }}">{{ $product->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                        <x-input id="price" class="price block mt-1 w-full"
                                                            type="number" min="0.00" name="price[]" autofocus
                                                            readonly />
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                        <x-input id="quantity" class="quantity block mt-1 w-full"
                                                            type="number" min="1" name="quantity[]" autofocus />
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                        <x-input id="sub_total" class="sub_total block mt-1 w-full"
                                                            type="number" name="sub_total[]" readonly />
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                                                        {{-- <x-button class="ml-3 remove_product_row"> {{ __('remove') }}
                                                        </x-button> --}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfooter class="bg-gray-50">
                                                <tr>
                                                    <td scope="col"
                                                        class="px-6 py-3 text-left text-base font-bold text-gray-500 uppercase tracking-wider"
                                                        colspan="3">
                                                        Total
                                                    </td>
                                                    <td scope="col"
                                                        class="px-6 py-3 text-right text-base font-bold text-gray-500 uppercase tracking-wider">
                                                        <h1><b class="final_total">0.00</b></h1>
                                                        <input type="hidden" name="final_total" class="final_total">
                                                    </td>
                                                    <td scope="col"
                                                        class="px-6 py-3 text-right text-base font-bold text-gray-500 uppercase tracking-wider">
                                                        <x-button class="ml-3">
                                                            {{ __('Create') }}
                                                        </x-button>
                                                    </td>
                                                </tr>
                                            </tfooter>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    // add product row
    $('.add_product_row').on('click', function(event) {
        event.preventDefault();
        var products = $('.product_id').html();
        var newProductRow = ($('.newProductRow tr').length - 0) + 1;
        var newRow = '<tr>' +
            '<td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">' +
            '<select id="product_id" name="product_id[]" class="block w-full mt-1 product_id"><option value="Choose Product">Choose Product</option>' +
            products +
            '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">' +
            '<input id="price" class="price rounded-md shadow-sm border-gray-300 block mt-1 w-full" type="number" min="0.00" name="price[]" readonly/>' +
            '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">' +
            '<input id="quantity" class="quantity rounded-md shadow-sm border-gray-300 block mt-1 w-full" type="number" min="1" name="quantity[]"/>' +
            '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">' +
            '<input id="total" class="sub_total rounded-md shadow-sm border-gray-300 block mt-1 w-full" type="number" name="sub_total[]" readonly />' +
            '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">' +
            '<button class="ml-3 remove_product_row inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">remove</button>' +
            '</td>' +
            '</tr>';
        $('.newProductRow').append(newRow);
    });

    // remove product row
    $('.newProductRow').delegate('.remove_product_row', 'click', function(event) {
        event.preventDefault();
        $(this).parent().parent().remove();
    });
    // calculate order total
    function orderTotalAmount() {
        var orderTotal = 0;
        $('.sub_total').each(function(i, e) {
            var amount = $(this).val() - 0;
            orderTotal += amount;
        });

        $('.final_total').html(orderTotal)
        $('.final_total').val(orderTotal)
    }
    // calculate price qty after choose item
    $('.newProductRow').delegate('.product_id', 'change', function(event) {
        event.preventDefault();
        var row = $(this).parent().parent();
        var price = row.find('.product_id option:selected').attr('data-price');
        row.find('.price').val(Math.round(price));

        var qty = row.find('.quantity').val() - 0;
        var price = row.find('.price').val() - 0;

        var sub_total = (qty * price);
        row.find('.sub_total').val(sub_total);

        orderTotalAmount();


    });
    // calculate price qty after choose new item
    $('.newProductRow').delegate('.quantity', 'keyup', function(event) {
        event.preventDefault();
        var row = $(this).parent().parent();

        var qty = row.find('.quantity').val() - 0;
        var price = row.find('.price').val() - 0;

        var sub_total = (qty * price);
        row.find('.sub_total').val(sub_total);

        orderTotalAmount();


    });
</script>
