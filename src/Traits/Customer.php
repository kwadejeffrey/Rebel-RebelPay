<?php

namespace Rebel\RebelPay\Traits;

trait Customer
{
    public function createCustomer(array $data)
    {
        $url = 'https://api.paystack.co/customer';
        $field = http_build_query($data);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.config('rebel-rebelpay.secretkey'),
            'Cache-Control: no-cache',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return $final = json_decode($result);
    }

    public function getClients()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.paystack.co/customer',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.config('rebel-rebelpay.secretkey'),
                'Cache-Control: no-cache',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return 'cURL Error #:'.$err;
        } else {
            return json_decode($response);
        }
    }

    public function getClient($identifier)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.paystack.co/customer/$identifier",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.config('rebel-rebelpay.secretkey'),
                'Cache-Control: no-cache',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return 'cURL Error #:'.$err;
        } else {
            return json_decode($response);
        }
    }

    public function updateClient(array $data, string $id)
    {
        $url = "https://api.paystack.co/customer/$id";
        $field = http_build_query($data);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.config('rebel-rebelpay.secretkey'),
            'Cache-Control: no-cache',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return $final = json_decode($result);
    }

    public function deactivateClient(array $data)
    {
        $url = 'https://api.paystack.co/customer/deactivate_authorization';

        $fields_string = http_build_query($data);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.config('rebel-rebelpay.secretkey'),
            'Cache-Control: no-cache',
        ]);

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);

        return json_decode($result);
    }
}
