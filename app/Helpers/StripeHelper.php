<?php

namespace App\Helpers;

class StripeHelper
{
    /**
     * Retorna o nome amigável do plano a partir do price_id.
     */
    public static function getPlanLabel(string $priceId): string
    {
        return match ($priceId) {
            config('stripe.prices.monthly')    => 'Mensal',
            config('stripe.prices.one_year')   => '1-Ano',
            config('stripe.prices.three_year') => '3-Anos',
            default                            => 'Desconhecido',
        };
    }

    /**
     * Formata valor em centavos para reais (R$ 9999 → 99,99).
     */
    public static function formatCurrency(int|float $valueInCents): string
    {
        return 'R$ ' . number_format($valueInCents / 100, 2, ',', '.');
    }

    /**
     * Converte um timestamp Unix (Stripe) para data no formato brasileiro.
     */
    public static function formatDate(int $timestamp): string
    {
        return date('d/m/Y H:i:s', $timestamp);
    }



}