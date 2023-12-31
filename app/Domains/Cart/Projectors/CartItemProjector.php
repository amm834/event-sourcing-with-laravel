<?php

namespace App\Domains\Cart\Projectors;

use App\Domains\Cart\Events\CartItemAdded;
use App\Models\CartItem;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CartItemProjector extends Projector
{
    public function onCartItemAdded(CartItemAdded $event): void
    {
        (new CartItem)->writeable()->create([
            'uuid' => $event->cartItemUuid,
            'cart_uuid' => $event->cartUuid,
            'product_id' => $event->productUuid,
            'amount' => $event->amount,
            'price_per_item_excluding_vat' => $event->currentPrice->pricePerItemExcludingVat(),
            'price_per_item_including_vat' => $event->currentPrice->pricePerItemIncludingVat(),
            'vat_percentage' => $event->currentPrice->vatPercentage(),
            'vat_price' => $event->currentPrice->vatPrice(),
            'total_item_price_excluding_vat' => $event->amount * $event->currentPrice->pricePerItemExcludingVat(),
            'total_item_price_including_vat' => $event->amount * $event->currentPrice->pricePerItemIncludingVat(),
        ]);
    }
}
