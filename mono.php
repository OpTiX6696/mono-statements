<?php

  class Mono {

    private $period;
    private $output_format;
    private $mono_secret_key;
    private $auth;

    function __construct($period, $output_format, $mono_secret_key, $auth) {
      this->period = $period;
      this->output_format = $output_format;
      this->mono_secret_key = $mono_secret_key;
      this->auth = $auth;
    }
  // I have to consume the exchange token API first
  
    function getID() {
      $auth = this->auth;
      $url = "https://api.withmono.com/account/".$auth;
      $url_header = array(
        'Content-Type: application/json'
      );


      $curl = curl_init($url);

      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      curl_setopt($curl, CURLOPT_POST, true);

      curl_setopt($curl, CURLOPT_HTTPHEADER, $url_header);

      $response_ID = curl_exec($curl);

      curl_close($curl);

      echo $response_ID;

      return $response_ID;

    }


  //  curl --request GET \
  //--url https://api.withmono.com/accounts/id/statement
    function getStatement() {
      $id = this->getID()['id'];
      $period = this->period;
      $output_format = "last".this->output_format."months";
      $url = "https://api.withmono.com/accounts/".$id."/statement?period=".$period."&output=".$output_format;
      
      $statement_response = file_get_contents($url);

      if ($statement_response) {
        $array_statement = json_decode($statement_response, true);
        displayJSONResponse($array_statement);
      }
  
    }


    // Just a little something to display it well when I //// eventually get to test it. Not so necessary :


    function displayJSONResponse ($json_response) {
      if($json_response) {
        foreach($json_response as $key=>$value) {
          if(is_array($value)) {
            displayJSONResponse($value);
          } else {
            echo $key."--".$value."</br>" ;
          }
        }
      }
    }

  }

    // Get ID from exchange token
    // WORK TO BE DONE
    // Get code from Mono Widget
    // Use code from Exchange Token together with auth key to get ID

    // Then the getStatement function uses the id to get the statement
  
  
?>

