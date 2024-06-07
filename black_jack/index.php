<?php

$card_deck = [
    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 10, 10, 11],
    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 10, 10, 11],
    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 10, 10, 11],
    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 10, 10, 11],
];

function get_random_card(&$card_deck)
{
    $randomIndex = array_rand($card_deck);
    $innerRandomIndex = array_rand($card_deck[$randomIndex]);
    $randomNumber = array_splice($card_deck[$randomIndex], $innerRandomIndex, 1);
    return $randomNumber[0];
}

function dealCards()
{
    $sum = 0;
    global $card_deck;
    $cards = [];
    $cards[] = get_random_card($card_deck);
    $cards[] = get_random_card($card_deck);
    foreach ($card_deck as $deck) {
        foreach ($deck as $card) {
            $sum += $card;
            if ($card == 11 and $sum > 21) {
                $sum -= 10;
            }
        }
    }
    return $cards;
}
$player_cards = dealCards();
$dealer_cards = dealCards();


function who_won($player_cards, $dealer_cards)
{
    $player_sum = array_sum($player_cards);
    $dealer_sum = array_sum($dealer_cards);

    if ($player_sum > $dealer_sum) {
        return 1;
    } else if ($player_sum < $dealer_sum) {
        return -1;
    } else if ($player_sum == 21 || $dealer_sum == 21 ) {
        return 2;
    } else if ($player_sum > 21 && $player_cards == 11 || $dealer_sum > 21 && $dealer_cards == 11){
        return 3;
    } else {
        return 0;
    }
}

function game($player_cards, $dealer_cards)
{
    $player_score = 0;
    $dealer_score = 0;

    for ($i = 0; $i < 5; $i++) {
        $player_cards = dealCards($player_cards);
        $dealer_cards = dealCards($dealer_cards);

        $result = who_won($player_cards, $dealer_cards);
        echo 'Result: ' . $result . '<br>';
        if ($result == 1) {
            $player_score++;
        } else if ($result == -1) {
            $dealer_score++;
        } else if ($result == 0) {
            $player_score = $player_score;
            $dealer_score = $dealer_score;
        } else if ($result == 2) {
            foreach ($player_cards as $card) {
                echo $card . " ";
            }
            echo '<br>';
            foreach ($dealer_cards as $card) {
                echo $card . " ";
            }
            echo "!BLACK JACK! <br>";
            break;
        }

        foreach ($player_cards as $card) {
            echo $card . " ";
        }
        echo '<br>';
        foreach ($dealer_cards as $card) {
            echo $card . " ";
        }
        echo '<br>';
        echo 'Player: ' . $player_score . ' vs. Dealer: ' . $dealer_score  . '<br><br>';
    }
    return ($player_score > $dealer_score) ? 'Player wins' : 'Dealer wins';
}

echo game($player_cards, $dealer_cards);
