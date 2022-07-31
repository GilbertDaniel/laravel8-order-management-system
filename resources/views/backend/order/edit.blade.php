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
                        <form action="{{ route('orders.update', $order->id) }}" method="POST">
                            @method('PUT')
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
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 newProductRow">
                                                @foreach ($order->order_details as $order_detail)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                            <select id="product_id" name="product_id[]"
                                                                class="block w-full mt-1 product_id">
                                                                <option value="Choose Product" selected>Choose Product
                                                                </option>
                                                                {{-- @foreach ($products as $product)
                                                                    <option data-price={{ $product->price }}
                                                                        value="{{ $product->id }}">{{ $product->name }}
                                                                    </option>
                                                                @endforeach --}}
                                                                @foreach ($products as $product)
                                                                    @if ($product->id == $order_detail->product_id)
                                                                        <option value="{{ $product->id }}" data-price={{ $order_detail->price }} selected>
                                                                            {{ $product->name }}</option>
                                                                    @else
                                                                        <option value="{{ $product->id }}" data-price={{ $product->price }}>
                                                                            {{ $product->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                            <x-input id="price" class="price block mt-1 w-full"
                                                                type="number" min="0.00" name="price[]" value="{{$order_detail->price}}" autofocus
                                                                readonly />
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                            <x-input id="quantity" class="quantity block mt-1 w-full"
                                                                type="number" min="1" name="quantity[]" value="{{$order_detail->quantity}}"
                                                                autofocus />
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                            <x-input id="sub_total" class="sub_total block mt-1 w-full"
                                                                type="number" name="sub_total[]" value="{{$order_detail->sub_total}}" readonly />

                                                                <input type="hidden" name="order_detail_id[]" class="order_id" value="{{$order_detail->order_id}}">
                                                            </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfooter class="bg-gray-50">
                                                <tr>
                                                    <td scope="col"
                                                        class="px-6 py-3 text-left text-base font-bold text-gray-500 uppercase tracking-wider"
                                                        colspan="2">
                                                        Total
                                                    </td>
                                                    <td scope="col"
                                                        class="px-6 py-3 text-right text-base font-bold text-gray-500 uppercase tracking-wider">
                                                        <h1><b class="final_total">{{$order->final_total}}</b></h1>
                                                        <input type="hidden" name="final_total" class="final_total" value="{{$order->final_total}}">
                                                    </td>
                                                    <td scope="col"
                                                        class="px-6 py-3 text-right text-base font-bold text-gray-500 uppercase tracking-wider">
                                                        <x-button class="ml-3">
                                                            {{ __('Update') }}
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
