<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Laravel</title>

    <style>
        .status-processing {
            background: #fef08a;
            color: #854d0e;
        }

        .status-shipped {
            background: #e9d5ff;
            color: #6b21a8;
        }

        .status-delivered {
            background: #bbf7d0;
            color: #166534;
        }

        .status-cancelled {
            background: #fecaca;
            color: #991b1b;
        }

    </style>
</head>

<body>
    <div class="max-w-4xl mx-auto my-12 text-gray-900">
        <h2 class="text-2xl font-bold">Order History</h2>

        <div class="orders space-y-12 my-8">

            @foreach ($orders as $order)
                <div class="order border border-gray-200">
                    <div class="bg-gray-100">
                        <div class="flex items-center justify-between px-8 py-4">
                            <div class="flex space-x-16">
                                <div>
                                    <div class="font-semibold">Order Number</div>
                                    <div class="text-sm text-gray-700">{{ $order->id }}</div>
                                </div>
                                <div>
                                    <div class="font-semibold">Date Placed</div>
                                    <div class="text-sm text-gray-700">{{ $order->created_at->format('M d Y') }}</div>
                                </div>
                                <div>
                                    <div class="font-semibold">Total Amount</div>
                                    <div class="text-sm text-gray-700">${{ number_format($order->total / 100, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-4">
                        <div class="flex">
                            <img src="https://via.placeholder.com/200" alt="product">
                            <div class="flex flex-col justify-between ml-6">
                                <div>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Non vel veritatis libero expedita accusantium atque neque impedit ea minus, obcaecati maiores corrupti animi velit cum ipsam natus assumenda consectetur reiciendis!</div>
                                {{-- <div>
                                    <span class="{{ 'status-' . Str::kebab($order->status->name) }} px-4 py-2 inline-block rounded-full text-sm">{{ $order->status->name }} @if ($order->status->name === 'Delivered') on Jan 12, 2022 @endif</span>
                                </div> --}}
                                <div>
                                    <span class="{{ Status::tryFrom($order->status)->getStyles() }} px-4 py-2 inline-block rounded-full text-sm">{{ Status::tryFrom($order->status)->getName() }} @if (Status::tryFrom($order->status) === Status::DELIVERED) on Jan 12, 2022 @endif</span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div> <!-- end order -->
            @endforeach
        </div> <!-- end orders -->

        <div>
            <h2 class="text-2xl">All Statuses</h2>
            <ul class="mt-4">
                @foreach (Status::cases() as $status)
                    <li>{{ $status->getName() }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</body>

</html>
