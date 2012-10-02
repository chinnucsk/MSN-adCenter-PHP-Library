<?php

/**
 * An easy to use MSN adCenter PHP Library
 *
 * @name      MSN adCenter PHP Library
 * @author    Michael Taggart <mtaggart@envoymediagroup.com>
 * @author    Michael Pearson <michael@phpgrease.net>
 * @copyright (c) 2010 Envoy Media Group
 * @link      http://www.envoymediagroup.com
 * @license   MIT
 * @version   $Rev$
 * @internal  $Id: msncustomers.class.php 8 2010-03-29 08:38:50Z mjpearson $
 *
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */
class MSNCustomers extends MSNAdCenter {
    const NAME = 'Customers';

    /* @var array request object helper */

    static public $_objStruct = array(
	'CustomerAddress' => NULL,
	'CustomerFinancialStatus' => NULL,
	'CustomerLifeCycleStatus' => NULL,
	'Id' => NULL,
	'Industry' => NULL,
	'LastModifiedByUserId' => NULL,
	'LastModifiedTime' => NULL,
	'MarketCountry' => NULL,
	'MarketLanguage' => NULL,
	'Name' => array(),
	'Number' => array(),
	'ServiceLevel' => NULL,
	'TimeStamp' => NULL
    );

    /**
     *
     * @return array 'Customer' helper structure
     */
    static public function getObjStruct() {
	return self::$_objStruct;
    }

    

    /**
     *
     * @param int $customerId Customer ID
     * @return mixed default response type (Object, Array or Raw XML)
     */
    static public function getAccountsInfo($customerId) {
	$params = array();
	$params['CustomerId'] = $customerId;
	return self::execRespond('GetAccountsInfo', $params);
    }

    /**
     *
     * @return mixed default response type (Object, Array or Raw XML)
     */
    static public function getAccount() {
	return self::execRespond('GetAccount');
    }

}

?>