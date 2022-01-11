<div class="form-group">
    {{ Form::button('Сохранить', ['class' => 'btn btn-primary', 'type' => 'submit']) }}
    <a class="btn btn-light ml-2" href="{{ route('admin.sale.index') }}">Назад</a>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            {{ Form::label('stock_id', 'Товарная позиция') }}
            {{ Form::select('stock_id', $stockDom, null, ['class' => 'form-control', 'placeholder' => 'Выберите...']) }}
        </div>
        <div class="col-6 col-md-2">
            {{ Form::label('quantity', 'Кол-во') }}
            {{ Form::number('quantity', $sale->quantity, ['class' => 'form-control']) }}
        </div>
        <div class="col-6 col-md-2">
            {{ Form::label('price', 'Цена, $') }}
            {{ Form::number('price', $sale->price, ['class' => 'form-control', 'step' => '0.01']) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            {{ Form::label('status', 'Статус') }}
            {{ Form::select('status', \App\Sale::$statusDom, null, ['class' => 'form-control']) }}
        </div>
        {{-- <div class="col-12 col-md-4 mb-3 mb-md-0">
            {{ Form::label('ebay_order_number', 'Номер заказа (eBay)') }}
            {{ Form::text('ebay_order_number', $sale->ebay_order_number, ['class' => 'form-control']) }}
        </div> --}}
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            {{ Form::label('track_number', 'Номер отслеживания') }}
            {{ Form::text('track_number', $sale->track_number, ['class' => 'form-control']) }}
        </div>
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            {{ Form::label('account_id', 'Аккаунт продажи') }}
            {{ Form::select(
                'account_id',
                \App\Account::orderBy('id', 'asc')->pluck('title', 'id')->toArray(),
                null,
                ['class' => 'form-control', 'placeholder' => 'Выберите...']
            ) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-4 col-md-2 mb-3 mb-md-0">
            {{ Form::label('paypal_fee', 'PayPal fee, $') }}
            {{ Form::number('paypal_fee', $sale->paypal_fee, ['class' => 'form-control', 'step' => '0.01']) }}
        </div>
        <div class="col-4 col-md-2 mb-3 mb-md-0">
            {{ Form::label('ebay_fee', 'Market fee, $') }}
            {{ Form::number('ebay_fee', $sale->ebay_fee, ['class' => 'form-control', 'step' => '0.01']) }}
        </div>
        <div class="col-4 col-md-2 mb-3 mb-md-0">
            {{ Form::label('ad_fee', 'ADS fee, $') }}
            {{ Form::number('ad_fee', $sale->ad_fee, ['class' => 'form-control', 'step' => '0.01']) }}
        </div>
        <div class="col-6 col-md-2 mb-3 mb-md-0">
            {{ Form::label('ship_fee', 'Shipping fee, RUB') }}
            {{ Form::number('ship_fee', $sale->ship_fee, ['class' => 'form-control', 'step' => '0.01']) }}
        </div>
        <div class="col-6 col-md-2 mb-3 mb-md-0">
            {{ Form::label('rub_usd', 'RUB/USD') }}
            {{ Form::number('rub_usd', $sale->rub_usd, ['class' => 'form-control', 'step' => '0.01']) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4 col-12 mb-3 mb-md-0">
            {{ Form::label('date_sale', 'Дата продажи') }}
            {{ Form::date('date_sale', $sale->date_sale, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-4 col-12 mb-3 mb-md-0">
            {{ Form::label('date_sent', 'Дата отправки') }}
            {{ Form::date('date_sent', $sale->date_sent, ['class' => 'form-control']) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-12 mb-3 mb-md-0">
            {{ Form::label('description', 'Дополнительно') }}
            {{ Form::textarea('description', $sale->description, [
                'class' => 'form-control',
                'rows' => '3',
                'placeholder' => 'Дополнительная информация'
            ]) }}
        </div>
    </div>
</div>