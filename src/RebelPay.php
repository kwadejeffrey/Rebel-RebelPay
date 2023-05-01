<?php

namespace Rebel\RebelPay;

use Rebel\RebelPay\Traits\Customer;
use Rebel\RebelPay\Traits\StartRequest;
use Rebel\RebelPay\Traits\Transactions;

class RebelPay
{
    use StartRequest, Transactions, Customer;

    /**
     * Initialize payment process to Paystack
     *
     * @return string JSON-encoded string representing the customer information.
     */
    public function makePayment(array $data)
    {

        try {
            $response = $this->startRequest($data);

            return \redirect($response->data->authorization_url);
        } catch (\Exception $e) {

        }
    }

    /**
     * Create a customer on Paystack
     */
    public function customer(array $data)
    {
        return $response = $this->createCustomer($data);
    }

    /**
     * Update customer profile
     *
     * @return string JSON-encoded string representing the customer information.
     */
    public function updateCustomer(array $data, string $id)
    {
        return $this->updateClient($data, $id);
    }

    /**
     * Get your Paystack client List
     *
     * @return string JSON-encoded string representing the customer information.
     */
    public function getCustomers()
    {
        return $this->getClients();
    }

    /**
     * Get a specific customer's profile from Paystack
     *
     * @param  string  $identifier Can be either email or customer ID
     * @return string JSON-encoded string representing the customer information.
     */
    public function getCustomer(string $identifier)
    {
        return $this->getClient($identifier);
    }

    public function deactivateCustomer(array $data)
    {
        return $this->deactivateClient($data);
    }

    /**
     * Get list of All Transactions from Paystack
     */
    public function getAllTransactions($perPage = 100, $page = 1)
    {
        try {
            return $this->fetchTransactions($perPage, $page, $status = null);
        } catch (\Exception $e) {

        }
    }

    public function getSuccessfulTransactions($perPage = 100, $page = 1)
    {
        try {
            $response = $this->fetchTransactions($perPage, $page, $status = 'success');

            return $response;
        } catch (\Exception $e) {

        }
    }

    /**
     * Get list of failed transactions from Paystack
     *
     * @param  int  $perPage
     * @param  int  $page
     */
    public function getFailedTransactions($perPage = 100, $page = 1)
    {
        try {
            $response = $this->fetchTransactions($perPage, $page, $status = 'failed');

            return $response;
        } catch (\Exception $e) {

        }
    }

    /**
     * Get list of abandoned transactions from Paystack
     *
     * @param  int  $perPage
     * @param  int  $page
     */
    public function getAbandonedTransactions($perPage = 100, $page = 1)
    {
        try {
            $response = $this->fetchTransactions($perPage, $page, $status = 'abandoned');

            return $response;
        } catch (\Exception $e) {

        }
    }

    /**
     * Get a specific transaction from Paystack
     */
    public function getTransaction(int $id)
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
            $response = $this->traitExportTransactions();

            return \redirect($response->data->path);
        } catch (\Exception $e) {

        }
    }

    /**
     * export Transaction in CVS format
     */
    public function exportFilteredTransactions(string $status = '')
    {
        try {
            $response = $this->traitExportFilteredTransactions($status);

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
