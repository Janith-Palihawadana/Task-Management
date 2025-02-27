<?php
function minCoins($amount) {
    $coins = [25, 10, 5, 1];
    $numCoins = 0;
    
    foreach ($coins as $coin) {
        if ($amount >= $coin) {
            $numCoins = intdiv($amount, $coin) + $numCoins ;
            $amount = $amount % $coin;
        }
    }
    
    return $numCoins;
}
$amount = 63; 
echo "Minimum coins needed: " . minCoins($amount);
?>
