<?php

/**
 * Выставляет победителя для завершившихся лотов
 *
 * @param mysqli $sql_resource
 */
function set_winners(mysqli $sql_resource): void
{
    $transport = new Swift_SmtpTransport('phpdemo.ru', 25);
    $transport->setUsername("keks@phpdemo.ru");
    $transport->setPassword("htmlacademy");
    $mailer = new Swift_Mailer($transport);
    $offers = get_completed_offers($sql_resource);

    if (count($offers)) {
        foreach ($offers as $offer) {
            $last_bet = get_last_bet($sql_resource, $offer['id']);

            set_winner($sql_resource, $offer['id'], $last_bet['user_id']);

            $message = new Swift_Message();
            $message->setSubject("Ваша ставка победила");
            $message->setFrom(["keks@phpdemo.ru" => "Кекс"]);
            $message->setTo([$offer['email'] => $offer['name']]);
            $content = include_template('email.php', [
                'data' => $offer,
            ]);
            $message->setBody($content, 'text/html');

            $mailer->send($message);
        }
    }
}
