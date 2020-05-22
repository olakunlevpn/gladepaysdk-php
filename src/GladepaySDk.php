<?php
/**
 *
 *
 * @package Gladepay SDK PHP
 * @package https://github.com/olakunlevpn/gladepaysdk-php
 * @author  Olakunlevpn <olakunlevpn@live.com>
 * @license https://opensource.org/licenses/MIT The MIT Public License
 * @version 0.0.6
 */

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

           if (empty($this->merchant_id) || empty($this->merchant_key)) {
            throw new \Exception('Error: No Merchant Key or Merchant ID passed');
        }
       }


   


    /**
     * sanitize amount input
     * sanitize amount against nagative value
     * @param string $data amount to remove nagative value
     *
     */
    public function sanitize($data)
    {
         return $data;
         $data = @trim($data);
         if(get_magic_quotes_gpc())
         {
             $data = stripslashes($data);
         }
         return @mysql_real_escape_string($data);
     }


     /**
      * Get Numeric amount input
      * This function does nothing believe me.  kindly ignore it
      * @param string $data amount to ensure user inputs is number
      *
      */
    public function get_numeric($val)
     {
         if (is_numeric($val)) {
           return $val + 0;
         }
         return floatval($val);
    }




        /**
         * All  Airtime and Bills
         *
         * @param string action "This method retrieves the list of category"
         * * All methods return an array.
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
     * * All methods return an array.
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
     * * All methods return an array.
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
     * * All methods return an array.
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
     * All methods return an array.
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
    * Card payment
    *
    * @param string $user_details user information details such as first name, last name, address,  Ip address and finger print and others
    * @param string $card_details Client full Card information
    * @param string $amount Amount to be card on the card, this will include fees
    * @param string $country User country extracted from the input form
    * @param string $currency User country current code EG: NG
    * @param string $type
    * @return string All methods return an array.
    */
    /*{ Example of card information and user information
    "action":"initiate",
    "paymentType":"card",
    "user": {
        "firstname":"Abubakar",
        "lastname":"Ango",
        "email":"test@gladepay.com",
        "ip":"192.168.33.10",
        "fingerprint": "cccvxbxbxb"
    },
    "card":{
        "card_no":"5438898014560229",
        "expiry_month":"09",
        "expiry_year":"19",
        "ccv":"789",
        "pin":"3310"
    },
    "amount":"10000",
    "country": "NG",
    "currency": "NGN"
}
 * All methods return an array.
*/
    public function cardPayment($user_details, $card_details, $amount, $country, $currency, $type = false, $type_data = false){
    //$type can be false, recurrent, installment

            $request = [ 'user' => $user_details, 'card' => $card_details, 'amount' => $amount, 'country' => $country, 'currency' => $currency];
            $initalResponse = json_encode($this->initiateTransaction($request, $type, $type_data), true);

            if(isset($initalResponse['status'])){
                if($initalResponse['status'] == 202){
                    $chargeResponse =  json_decode($this->chargeCard($request, $initalResponse['txnRef'], $initalResponse['apply_auth']), true);

                    if(isset($chargeResponse['status'])){
                        if($chargeResponse['status'] == 202){
                            if(isset($chargeResponse['validate'])){
                                return json_encode([
                                    "status" => 202,
                                    "txnRef" => $chargeResponse['txnRef'],
                                    "message" => "Please require the user to enter an OTP and call `validateOTP` with the `txnRef`"
                                ]);
                            }else if (isset($chargeResponse['authURL'])){
                                return json_encode([
                                    "status" => 202,
                                    "txnRef" => $chargeResponse['txnRef'],
                                    "authURL" => $chargeResponse['authURL'],
                                    "message" => "Please load the link contained in `authURL` for the user to validate Payment"
                                ]);
                            }else{
                                return json_encode([
                                    "status" => 500,
                                    "message" => "Unrecognized Response from Gateway."
                                ]);
                            }

                        }
                    }
                }else{
                    return json_encode([
                        "status" => 500,
                        "message" => $initalResponse['message']
                    ]);
                }
            }else{
                return json_encode([
                    "status" => 500,
                    "message" => "Unrecognized Response from Gateway."
                ]);
            }

  }



    /**
    * Initiate Transaction
    *
    * @param string $phrase Phrase to return
    *
    * All methods return an array.
    */
    private function initiateTransaction($request, $type, $type_data)
    {
        $data = [
            "action" => "initiate",
            "paymentType" => "card",
            "user" => $request['user'],
            "card" => $request['card'],
            "amount"=> $request['amount'],
            "country"=>$request['country'],
            "currency"=>$request['currency']
        ];
        switch ($type){
            case 'recurrent':
                $request_data = array_merge($data, ['recurrent' => $type_data]);
            break;
            case 'installment':
                $request_data = array_merge($data, ['installment' => $type_data]);
            break;
            default:
                $request_data = $data;
            break;
        }



          $this->url = $this->APIEndpoint."/payment";
          $this->params = [$request_data];

          return $this->__execute('PUT');


      }






    /**
    * Charge User card
    *
    * @param string $phrase Phrase to return
    *
    * @return string Returns the phrase passed in
    * All methods return an array.
    */

    private function chargeCard($request, $txn_ref, $auth_type)
    {
              $this->url = $this->APIEndpoint."/payment";
              $this->params = [
              "action" => "charge",
              "paymentType" => "card",
              "user" => $request['user'],
              "card" => $request['card'],
              "amount"=> $request['amount'],
              "country"=>$request['country'],
              "currency"=>$request['currency'],
              "txnRef"=>$txn_ref,
              "auth_type" => $auth_type
              ];

        return $this->__execute('PUT');


   }



   /**
   * Charge transaction with Token
   *
   * @param string $phrase Phrase to return
   *
   * @return string Returns the phrase passed in
  * All methods return an array.
   */


   public function chargeWithToken($token, $user_details, $amount){

          $this->url = $this->APIEndpoint."/payment";
          $this->params = [
                        "action" => "charge",
                        "paymentType" => "token",
                        "token" => $token,
                        "user" => $user_details,
                        "amount" => $amount
                        ];

          $tokenResponse =  $this->__execute('PUT');

           if(isset($tokenResponse['status'])){
               if($tokenResponse['status'] == 200){
                   return json_encode([
                       "status" => 200,
                       "txnRef" => $tokenResponse['txnRef'],
                       "message" => "Successful Payment."
                   ]);
               }else{
                   return json_encode([
                       "status" => 500,
                       "message" => "Error processing"
                   ]);
               }

           }else{
               return json_encode([
                   "status" => 500,
                   "message" => "Unrecognized Response from Gateway."
               ]);
           }
       }



       /**
        * Validate User OTP
        *
        * @param string $phrase Phrase to return
        *
        * @return string Returns the phrase passed in
        * All methods return an array.
        */
    public function validateOTP($txnRef, $otp)
     {
           $this->url = $this->APIEndpoint."/payment";
           $this->params = [
                 "action" => "validate",
                 "txnRef" => $txnRef,
                 "otp" => $otp
             ];
           return $this->__execute('PUT');
     }



     /**
      * Verify Transaction
      *
      * @param string $phrase Phrase to return
      *
      * @return string Returns the phrase passed in
      * All methods return an array.
      */
   public function verifyTransaction($txnRef)
   {
       $this->url = $this->APIEndpoint."/payment";
       $this->params = [
         "action" => "verify",
         "txnRef" => $txnRef
         ];
       return $this->__execute('PUT');
   }



   /**
    * Account Payment
    *
    * @param string $phrase Phrase to return
    *
    * @return string Returns the phrase passed in
    * All methods return an array.
    */

  public function accountPayment($user_details, $account_details, $amount){


          $this->url = $this->APIEndpoint."/payment";
          $this->params = [
          "action" => "charge",
          "paymentType" => "account",
          "user" => $user_details,
          "account" => $account_details,
          "amount"=> $amount
          ];

        return $this->__execute('PUT');

  }


  /**
   * Payment Validation
   *
   * @param string $phrase Phrase to return
   *
   * @return string Returns the phrase passed in
   * All methods return an array.
   */
   public function validateAccountPayment($txnRef, $otp){

             $this->url = $this->APIEndpoint."/payment";
             $this->params = [
               "action" => "validate",
               "txnRef" => $txnRef,
               "validate" => "account",
               "otp" => $otp
             ];

         return $this->__execute('PUT');
   }


   /**
    * Get account supported payment
    *
    * @param string $phrase Phrase to return
    *
    * @return string Returns the phrase passed in
    * All methods return an array.
    */

    public function getAccountPaymentSupportedBanks(){

          $this->url = $this->APIEndpoint."/resources";
          $this->params = [
          "inquire" => "supported_chargable_banks"
          ];

      return $this->__execute('PUT');


    }



    /**
     * Get user card details with card number
     *
     * @param string $phrase Phrase to return
     *
     * @return string Returns the phrase passed in
     * All methods return an array.
     */

    public function getCardDetails($card_number){

        $this->url = $this->APIEndpoint."/resources";
        $this->params = [
        "inquire"=> "card", "card_no" => $card_number
        ];

        return $this->__execute('PUT');


    }


    /**
     * Get transaction charges/fees
     *
     * @param string $phrase Phrase to return
     *
     * @return string Returns the phrase passed in
     * All methods return an array.
     */
    public function getCharges($paymentType, $amount, $card_no = false){
    //Card number can not be false where $paymentType is card

        $request_data = [
        "inquire" => "charges",
        "amount" => $amount
        ];

        if($paymentType == "card"){
        $request_data += ["card_no" => $card_no];
        } else{
        $request_data += ["type" => $paymentType];
        }

        $this->url = $this->APIEndpoint."/resources";
        $this->params = [$request_data];

        return $this->__execute('PUT');



    }


    /**
     * Transfer Money from bank account
     *
     * @param string $amount amount value to transfer
    * @param string $bankcode user bank identification code (Bank ID)
    * @param string $accountnumber rceiver account number
    * @param string $sender_name  sender name such as firstname and last name
      * @param string $narration  Transaction description
     *
     * @return string Returns the phrase passed in
    * All methods return an array.
     */


    public function moneyTransfer($amount, $bankcode, $accountnumber, $sender_name, $narration){

            $this->url = $this->APIEndpoint."/disburse";
            $this->params = [
            "action" => "transfer",
            "amount" => $amount,
            "bankcode" => $bankcode,
            "accountnumber" =>$bankcode,
            "sender_name" => $sender_name,
            "narration" => $narration
            ];

        return $this->__execute('PUT');

    }


    /**
     * Verify Money Transfer
     *
     * @param string $txnRef transaction reference
     *
     * @return string Returns the phrase passed in
     * All methods return an array.
     */


    public function verifyMoneyTransfer($txnRef){

          $this->url = $this->APIEndpoint."/disburse";
          $this->params = [
          "action" => "verify",
          "txnRef" => $txnRef
          ];

        return $this->__execute('PUT');


    }






    /**
     *  list of banks
     *
     * @return string Returns the phrase passed in
     * All methods return an array.
     */

    public function getAllBanks(){

            $this->url = $this->APIEndpoint."/resources";
            $this->params = [
                  "inquire" => "banks"
              ];
            return $this->__execute('PUT');

  }


  /**
   *  Verify account number
   *
   * @return string $number user account number
   * @return string $code  selected bank code from getAllBanks();
   * All methods return an array.
   */

  public function verifyAccountNumber($number, $code){

          $this->url = $this->APIEndpoint."/resources";
          $this->params = [
                "inquire" => "accountname",
                "accountnumber" => $number,
                "bankcode" => $code
            ];
          return $this->__execute('PUT');

}




/**
 * Payment Validation
 *
 * @param string $txnRef transaction reference number
 * @param string $amount amount to be refund
 * @param string $comment reason for refund (comment)
 *
 * All methods return an array.
 */
 public function refundAction($txnRef, $amount, $comment){

           $this->url = $this->APIEndpoint."/payment";
           $this->params = [
             "action" => "refund",
             "txnRef" =>  $txnRef,
             "amount" => $amount,
             "comment" => $comment //Reason for refund
           ];

       return $this->__execute('PUT');
 }





  /**
     * Get webhook payload
     *
     * @param bool $decodeJson      Set true to decode the JSON
     * @param bool $decodeAsArray   Set true to decode the JSON as array
     * @return type
     */
    public static function getWebhookPayload(bool $decodeJson = true, bool $decodeAsArray = true) {
        if ($decodeJson) {
            return json_decode(file_get_contents('php://input'), $decodeAsArray);
        } else {
            return file_get_contents('php://input');
        }
    }




    /**
     * Verify BVN
     *
     * @param string $bvn User BVN
     *
     * @return string Returns the phrase passed in
     * All methods return an array.
     */


    public function verifyBVN($bvn){

          $this->url = $this->APIEndpoint."/resources";
          $this->params = [
          "inquire" => "bvn",
          "bvn" => $bvn
          ];

        return $this->__execute('PUT');


    }




    /**
     * Verify BVN
     *
    * @param string $client_id client id for account identification
    * @param string $interestRate interest rate of the loan EG: 10 5 or 15
    *@param string $tax_rate tax rate
    *@param string $period savings period
    * @return string Returns the phrase passed in
    * All methods return an array.
     */


    public function createSavings($client_id, $interestRate, $tax_rate, $period){

          $this->url = $this->APIEndpoint."/investments";
          $this->params = [
              "action" => "create_savings",
              "name" => "Main Account",
              "client_id" =>  $client_id,
              "interestSettings" => [
              "interestRate"  =>  $interestRate,
              "interestFrequency" =>  "annualized|every_month|every_four_weeks|every_week|every_day"
            ],
              "tax_applied" =>  true,
              "tax_rate" => $tax_rate,
              "period" =>  $period
          ];

        return $this->__execute('PUT');


    }





    /**
     * Create Personalized Account
     *
     * @param string $names Name to appear on the account details EG: Firstname, Lastname (Other name is Optional)
     * @param string $reference A reference number that will be used to track the account number generated and payments
     * @param string $email Email address that belongs to the customer
     *
     * All methods return an array.
     */


    public function createPersonalizedAccount($names, $reference, $email){

          $this->url = $this->APIEndpoint."/resources";
          $this->params = [
            "request" => "personalized-accounts",
          	"name" => $names,
          	"reference" => $reference,
          	"email" => $email
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
