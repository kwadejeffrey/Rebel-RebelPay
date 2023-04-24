<?php

namespace Rebel\RebelPay\Traits;

trait StartRequest
{
    /**
     * Function to initialize payment
     */
    protected function startRequest(array $data, $url = 'https://api.paystack.co/transaction/initialize')
    {

        $field = http_build_query($data);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.env('PAYSTACK_SECRET_KEY'),
            'Cache-Control: no-cache',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return $final = json_decode($result);

    }

    /**
     * Verify transaction using reference key in query string 
     */
    protected function getReference(string $reference)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.env('PAYSTACK_SECRET_KEY'),
                'content-type: application/json',
                'Cache-Control: no-cache',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * We use this function to initialize a callback instead of depending of the paystack dashboard callback webhook
     */
    public function callback()
    {
        $response = json_decode($this->getReference(request('reference')));
        return $response;

    }
}
