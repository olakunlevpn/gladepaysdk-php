<?php

namespace Olakunlevpn\Gladepaysdk;

class GladepaySDk
{


    const GLADEPAY_PRODUCTION_API_ENDPOINT = 'https://api.gladepay.com';
    const GLADEPAY_TESTNET_API_ENDPOINT = 'https://demo.api.gladepay.com';


    private $APIEndpoint = null;
    private $AuthAPIEndpoint = null;
    private $url = null;
    private $params = [];


    /**
     * Create a new Skeleton Instance
     */
     public function __construct(string $merchant_id, string $merchant_key, bool $testNet = false) {
           $this->merchant_id = $merchant_id;
           $this->merchant_key = $merchant_key;
           $this->testNet = $testNet;
           $this->APIEndpoint = (!$this->testNet) ? self::GLADEPAY_PRODUCTION_API_ENDPOINT : self::GLADEPAY_TESTNET_API_ENDPOINT;
           $this->AuthAPIEndpoint = (!$this->testNet) ? self::GLADEPAY_PRODUCTION_API_ENDPOINT : self::GLADEPAY_TESTNET_API_ENDPOINT;
       }


    /**
     * Friendly welcome
     *
     * @param string $phrase Phrase to return
     *
     * @return string Returns the phrase passed in
     */
    public function echoPhrase()
    {


      $this->url = $this->APIEndpoint;
      return $this->__execute('PUT');



    }




        /**
         * All  Airtime and Bills
         *
         * @param string action "This method retrieves the list of category"
         *
         */

    public function getListOfBillAirtime()
    {


      $this->url = $this->APIEndpoint."/bills";
      $this->params = [
            'action' => 'pull'
        ];
      return $this->__execute('PUT');



    }

    /**
     * Filter bills by category
     *
     * @param string action "This method retrieves the list of category"
     * @param string $category  Category type to filter billers.
     *
     */

    public function getListOfBillByCategory($category)
    {


      $this->url = $this->APIEndpoint."/bills";
      $this->params = [
            'action' => 'pull',
            'category' => $category
        ];
      return $this->__execute('PUT');



    }

    /**
     * Filter bills by ID
     *
     * @param string action "This method retrieves the list of category"
     * @param string $id  get billers by ID.
     *
     */
    public function getListOfBillById($id)
    {


      $this->url = $this->APIEndpoint."/bills";
      $this->params = [
            'action' => 'pull',
            'bills_id' => $id
        ];
      return $this->__execute('PUT');



    }


    /**
     * Resolve Bills Name
     *
     * @param string action "This method retrieves user informations"
     * @param string $paycode  get billers identifier paycode.
     * @param string $reference  Reference which is the user phone number, meter number etc.
     *
     */
    public function billPaymentResolve($paycode, $reference)
    {


      $this->url = $this->APIEndpoint."/bills";
      $this->params = [
            "action" =>"resolve",
            "paycode" => $paycode,
            "reference" => $reference

        ];
      return $this->__execute('PUT');



    }


    /**
     * Make Bills Payment
     *
     * @param string action "This method retrieves user informations"
     * @param string $paycode  get billers identifier paycode.
     * @param string $reference  Reference which is the user phone number, meter number etc.
     *
     */
    public function makeBillPayment($paycode, $reference, $amount, $ref)
    {


      $this->url = $this->APIEndpoint."/bills";
      $this->params = [
              "action" => "pay",
              "paycode" => $paycode,
              "reference" => $reference,
              "amount" => $amount,
              "orderRef" => $ref

        ];
      return $this->__execute('PUT');



    }




    /**
     * Bill payment
     *
     * @param string $phrase Phrase to return
     *
     * @return string Returns the phrase passed in
     */
    public function cardPayment()
    {


      $this->url = $this->APIEndpoint."/bills";
      $this->params = [
            'action' => 'pull'
        ];
      return $this->__execute('PUT');



    }



    public function getAllBanks(){

            $this->url = $this->APIEndpoint."/resources";
            $this->params = [
                  "inquire" => "banks"
              ];
            return $this->__execute('PUT');

  }





    private function __execute(string $requestType = 'POST') {
       $ch = curl_init($this->url);
       if ($requestType === 'GET') {
           curl_setopt($ch, CURLOPT_URL, $this->url . '?' . http_build_query(array_filter($this->params)));
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
       } elseif ($requestType === 'PUT') {
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array_filter($this->params)));
       } elseif ($requestType === 'DELETE') {
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array_filter($this->params)));
       } elseif ($requestType === 'POST') {
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array_filter($this->params)));
       }
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, [
         "key: ".$this->merchant_key,
         "mid:  ".$this->merchant_id
       ]);
       curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

       if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
           curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
       }

       $response = curl_exec($ch);
       curl_close($ch);

       return json_decode($response);
   }



}
