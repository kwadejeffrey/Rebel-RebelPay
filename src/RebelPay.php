<?php

namespace Rebel\RebelPay;

use Rebel\RebelPay\Traits\StartRequest;
use Rebel\RebelPay\Traits\Transactions;

class RebelPay
{
    use StartRequest, Transactions;

    public function makePayment($data)
    {

        try {
            $response = $this->startRequest($data);

            return \redirect($response->data->authorization_url);
        } catch (\Exception $e) {

        }
    }

    public function getAllTransactions($perPage = 70, $page = 1, $status = null)
    {
        try {
            return $this->fetchTransactions($perPage, $page, $status);
        } catch (\Exception $e) {

        }
    }

    public function getSuccessfulTransactions($perPage = 70, $page = 1, $status = 'success')
    {
        try {
            $response = $this->fetchTransactions($perPage, $page, $status);

            return $response;
        } catch (\Exception $e) {

        }
    }

    public function getFailedTransactions($perPage = 70, $page = 1, $status = 'failed')
    {
        try {
            $response = $this->fetchTransactions($perPage, $page, $status);

            return $response;
        } catch (\Exception $e) {

        }
    }

    public function getAbandonedTransactions($perPage = 70, $page = 1, $status = 'abandoned')
    {
        try {
            $response = $this->fetchTransactions($perPage, $page, $status);

            return $response;
        } catch (\Exception $e) {

        }
    }

    public function getTransaction($id)
    {
        try {
            return $this->fetchTransaction($id);
        } catch (\Exception $e) {

        }
    }

    /**
     * export Transaction in CVS format
     */
    public function exportTransactions()
    {
        try {
            $response = $this->traitExport();

            return \redirect($response->data->path);
        } catch (\Exception $e) {

        }
    }

    /**
     * Get data like total amount, total transactions on transactions
     */
    public function totalTransactions()
    {
        try {
            return $this->transactionTotal();
        } catch (\Exception $e) {

        }
    }
}
