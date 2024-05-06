<?php

namespace App\Services;


class Notification
{
    public function send($to, $title, $message)
    {
        $fields = array(
            'to' => $to,
            'notification' => array(
                'body'   => $message,
                'title'     => $title,
                'subtitle'  => '',
                'tickerText'    => '',
                'vibrate'   => 1,
                'sound'     => 1,
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon',
            ),
            'data' => array(
                'title'  => $title,
                'body' => $message
            )
        );

        return $this->sendPushNotification($fields);
    }

    private function sendPushNotification($fields)
    {
        $data = json_encode($fields);

        $headers = array('Authorization: key=AAAA66GDMiE:APA91bFI-1NRJTBZlaRGB16eRFs-UJk-vYdpauCA94seQt5txUD3jAv3AnTxQbX6cWB-yssd1zCMZJacUmm_z8Sa57ykuAvNc95or5yPq6XTDegoRQoOOu6L6YjFKNNNJ9L_aXt-42wU', 'Content-Type: application/json');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);

        //echo $result;
    }
}
