@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <h1> Заказы </h1>
        <div class="form-group">
            <a href="{{ route('admin.stock.create') }}" class="btn btn-success" role="button"> @lang('backend/product.create') </a>
        </div>
    </div>
    <div class="container mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-left" width="10%">Поставщик</th>
                    <th scope="col" class="text-left" width="40%">Товар</th>
                    <th scope="col" class="text-center" width="10%">Статус</th>
                    <th scope="col" class="text-center" width="10%">Цена</th>
                    <th scope="col" class="text-center" width="5%">Количество</th>
                    <th scope="col" class="text-center" width="10%">Сумма</th>
                    <th scope="col" class="text-center" width="15%">Дата заказа</th>
                    <th scope="col" class="text-center" width="15%">Дата получения</th>
                    <th scope="col" class="text-center" width="5%" class="text-center"><i class="fas fa-pen text-secondary"></i></th>
                    <th scope="col" class="text-center" width="5%" class="text-center"><i class="fas fa-trash text-danger"></i></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="">
                        <td>{{ $order->supplier->title }}</td>
                        <td>{{ $order->product->title }}</td>
                        <td class="text-center">{{ \App\Stock::$statusDom[$order->status] }}</td>
                        <td class="text-center">{{ $order->price }}</td>
                        <td class="text-center">{{ $order->quantity }}</td>
                        <td class="text-center">{{ $order->price * $order->quantity }}</td>
                        <td class="text-center">{{ $order->date_order }}</td>
                        <td class="text-center">{{ $order->date_instock }}</td>
                        <td>
                            <a href="{{ route('admin.stock.edit', $order) }}">
                                <button type="button" class="btn btn-primary"><i class="fas fa-pen"></i></button>
                            </a>
                        </td>
                        <td class="text-center text-danger">
                            {{ Form::open(['route' => ['admin.stock.destroy', $order], 'method' => 'delete']) }}
                                {{ Form::button('<i class="fas fa-trash"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger',
                                    'onclick'=>'return confirm("Удалить ?")',
                                ]) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9"> @lang('messages.not_found') </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
        {{-- {{ $products->links() }} --}}
    </div>
@endsection