<?php
namespace App\Utils;

class OrderUtil extends Util
{
    /**
     * Generates item sku
     *
     * @param string $string
     *
     * @return generated sku (string)
     */
    public function generateOrderNo($string)
    {
        return str_pad($string, 4, '0', STR_PAD_LEFT);
    }
}
?>
