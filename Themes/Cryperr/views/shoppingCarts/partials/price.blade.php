<div class="price-block">
    @if(isset($price_sale) &&$price_sale > 0)
    <span class="old-price">{{ number_format($price_sale) }}$</span>
    @endif
    @if(isset($price_member) && $price_member > 0)
    <span class="price"> {{ number_format($price_member) }}$</span>
    @else
    <span class="price"> {{ number_format($price) }}$</span>
    @endif
</div>