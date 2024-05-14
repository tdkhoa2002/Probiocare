<?php

namespace Modules\Trade\Libraries;

use Web3\Personal;

class Web3Eth
{
    protected $web3;
    public function __construct($rpc)
    {
        $this->web3 = new Personal($rpc);
    }

    public function creatWallet(){
        $this->web3->listAccounts( function ($err, $account) use (&$newAccount) {
            if ($err !== null) {
                echo 'Error: ' . $err->getMessage();
                return;
            }
            $newAccount = $account;
            echo 'New account: ' . $account . PHP_EOL;
        });
    }
}
