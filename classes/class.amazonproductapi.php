<?php

    /**
     * Class to access Amazons Product Advertising API
     * @author Sameer Borate
     * @link http://www.codediesel.com
     * @version 1.0
     * All requests are not implemented here. You can easily
     * implement the others from the ones given below.
     */
    
    
    /*
    Permission is hereby granted, free of charge, to any person obtaining a
    copy of this software and associated documentation files (the "Software"),
    to deal in the Software without restriction, including without limitation
    the rights to use, copy, modify, merge, publish, distribute, sublicense,
    and/or sell copies of the Software, and to permit persons to whom the
    Software is furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
    THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
    DEALINGS IN THE SOFTWARE.
    */
    
    class AmazonProductAPI
    {
        /**
         * Your Amazon Access Key Id
         * @access private
         * @var string
         */
        private $public_key     = "YOUR AMAZON KEY";
        
        /**
         * Your Amazon Secret Access Key
         * @access private
         * @var string
         */
        private $private_key    = "YOUR AMAZON SECRET KEY";
        
        /**
         * Your Amazon Associate Tag
         * Now required, effective from 25th Oct. 2011
         * see more: https://affiliate-program.amazon.com
         * @access private
         * @var string
         */
        private $associate_tag  = "YOUR AMAZON ASSOCIATE TAG";
        
        /**
         * Constants for product types
         * @access public
         * @var string
         */
        
        /*
            Only three categories are listed here. 
            More categories can be found here:
            http://docs.amazonwebservices.com/AWSECommerceService/latest/DG/APPNDX_SearchIndexValues.html
        */
        const BOOK = "Books";
        
        
        public function __construct($publicKey, $privateKey, $associatetag)
        {
        	$this->public_key = $publicKey;
        	$this->private_key = $privateKey;
        	$this->associate_tag = $associatetag;
		}
        
        /**
         * Check if the xml received from Amazon is valid
         * 
         * @param mixed $response xml response to check
         * @return bool false if the xml is invalid
         * @return mixed the xml response if it is valid
         * @return exception if we could not connect to Amazon
         */
        private function verifyXmlResponse($response)
        {
            if ($response === False)
            {
                throw new Exception("Could not connect to Amazon");
            }
            else
            {
                if (isset($response->Items->Item->ItemAttributes->Title))
                {
                    return ($response);
                }
                else
                {
                    throw new Exception("Invalid xml response.");
                }
            }
        }
        
        
        /**
         * Query Amazon with the issued parameters
         * 
         * @param array $parameters parameters to query around
         * @return simpleXmlObject xml query response
         */
        private function queryAmazon($parameters)
        {
            return $this->aws_signed_request("com", $parameters, $this->public_key, $this->private_key, $this->associate_tag);
        }
        
        
        /**
         * Return details of products searched by various types
         * 
         * @param string $search search term
         * @param string $category search category         
         * @param string $searchType type of search
         * @return mixed simpleXML object
         */
        public function searchProducts($search, $category, $searchType = "UPC")
        {
            $allowedTypes = array("UPC", "TITLE", "ARTIST", "KEYWORD");
            $allowedCategories = array("Books");
            
            switch($searchType) 
            {
                case "UPC" :    $parameters = array("Operation"     => "ItemLookup",
                                                    "ItemId"        => $search,
                                                    "SearchIndex"   => $category,
                                                    "IdType"        => "UPC",
                                                    "ResponseGroup" => "Medium");
                                break;
                
                case "TITLE" :  $parameters = array("Operation"     => "ItemSearch",
                                                    "Title"         => $search,
                                                    "SearchIndex"   => $category,
                                                    "ResponseGroup" => "Medium");
                                break;
            
            }
            
            $xml_response = $this->queryAmazon($parameters);
            
            return $this->verifyXmlResponse($xml_response);

        }
        
        
        /**
         * Return details of a product searched by UPC
         * 
         * @param int $upc_code UPC code of the product to search
         * @param string $product_type type of the product
         * @return mixed simpleXML object
         */
        public function getItemByUpc($upc_code, $product_type)
        {
            $parameters = array("Operation"     => "ItemLookup",
                                "ItemId"        => $upc_code,
                                "SearchIndex"   => $product_type,
                                "IdType"        => "UPC",
                                "ResponseGroup" => "Medium");
                                
            $xml_response = $this->queryAmazon($parameters);
            
            return $this->verifyXmlResponse($xml_response);

        }
        
        
        /**
         * Return details of a product searched by ASIN
         * 
         * @param int $asin_code ASIN code of the product to search
         * @return mixed simpleXML object
         */
        public function getItemByAsin($asin_code)
        {
            $parameters = array("Operation"     => "ItemLookup",
                                "ItemId"        => $asin_code,
                                "ResponseGroup" => "Medium");
                                
            $xml_response = $this->queryAmazon($parameters);
            
            return $this->verifyXmlResponse($xml_response);
        }
        
        
        /**
         * Return details of a product searched by keyword
         * 
         * @param string $keyword keyword to search
         * @param string $product_type type of the product
         * @return mixed simpleXML object
         */
        public function getItemByKeyword($keyword, $product_type)
        {
            $parameters = array("Operation"   => "ItemSearch",
                                "Keywords"    => $keyword,
                                "SearchIndex" => $product_type);
                                
            $xml_response = $this->queryAmazon($parameters);
            
            return $this->verifyXmlResponse($xml_response);
        }
        
        
        public function aws_signed_request($region,$params,$public_key,$private_key, $associate_tag)
		{
			$method = "GET";
		    $host = "ecs.amazonaws.".$region; // must be in small case
		    $uri = "/onca/xml";
		    
		    
		    $params["Service"]          = "AWSECommerceService";
		    $params["AWSAccessKeyId"]   = $public_key;
		    $params["AssociateTag"]     = $associate_tag;
		    $params["Timestamp"]        = gmdate("Y-m-d\TH:i:s\Z");
		    $params["Version"]          = "2009-03-31";

		    /* The params need to be sorted by the key, as Amazon does this at
		      their end and then generates the hash of the same. If the params
		      are not in order then the generated hash will be different thus
		      failing the authetication process.
		    */
		    ksort($params);
		    
		    $canonicalized_query = array();

		    foreach ($params as $param=>$value)
		    {
		        $param = str_replace("%7E", "~", rawurlencode($param));
		        $value = str_replace("%7E", "~", rawurlencode($value));
		        $canonicalized_query[] = $param."=".$value;
		    }
		    
		    $canonicalized_query = implode("&", $canonicalized_query);

		    $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
		    
		    /* calculate the signature using HMAC with SHA256 and base64-encoding.
		       The 'hash_hmac' function is only available from PHP 5 >= 5.1.2.
		    */
		    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $private_key, True));
		    
		    /* encode the signature for the request */
		    $signature = str_replace("%7E", "~", rawurlencode($signature));
		    
		    /* create request */
		    $request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;

		    /* I prefer using CURL */
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL,$request);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		    $xml_response = curl_exec($ch);
		    
		    /* If cURL doesn't work for you, then use the 'file_get_contents'
		       function as given below.
		    */
		    
		    if ($xml_response === False)
		    {
		        return False;
		    }
		    else
		    {
		        /* parse XML */
		        $parsed_xml = @simplexml_load_string($xml_response);
		        return ($parsed_xml === False) ? False : $parsed_xml;
		    }
		}

    }
