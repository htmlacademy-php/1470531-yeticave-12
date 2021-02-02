<?php

/**
 * Выставляет победителя для завершившихся лотов
 *
 * @param mysqli $sql_resource
 */
function set_winners(mysqli $sql_resource): void {
    $offers = get_completed_offers($sql_resource);

    if (count($offers)) {
        foreach ($offers as $offer) {
            $last_bet = get_last_bet($sql_resource, $offer['id']);

            set_winner($sql_resource, $offer['id'], $last_bet['user_id']);
        }
    }
}
