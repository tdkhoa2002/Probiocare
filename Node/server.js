const express = require('express')
const Web3Wallet = require('./Web3Wallet.js')
const Web3Withdraw = require('./Web3Withdraw.js')
const Web3Buy = require('./Web3Buy.js')
// const abi = import('./abi.json')
require('dotenv').config()
const app = express()
app.use(express.json());

/**
 * Create web3 wallet address
 */
app.get('/create-wallet', async function (req, res) {
    const web3wallet = new Web3Wallet();
    const wallet = await web3wallet.createWallet();
    if (wallet != false) {
        return res.json({ status: "successs", 'data': wallet });
    } else {
        return res.json({ status: "error", 'message': 'Create wallet has error' });
    }
})

//Conect wallet web3
app.get('/connect-wallet', async function(res) {
    try {
        console.log("connect wallet");
        if (window.ethereum) {
            const accounts = await window.ethereum.request({
                "method": "eth_requestAccounts",
                "params": []
            });
            return res.json({ status: "success", data: accounts });
        } else {
            return res.json({ status: "error", message: "MetaMask is not installed or not enabled." });
        }
    } catch (error) {
        console.error(error);
        return res.json({ status: "error", message: error.toString() });
    }
})

app.post('/buy-product-web3', async function (req, res) {
    try {
        const dataRequest = req.body;
        console.log(dataRequest);
        const abi = 
        [
            {
                "inputs": [
                    {
                        "internalType": "uint256",
                        "name": "amount",
                        "type": "uint256"
                    }
                ],
                "name": "buyProduct",
                "outputs": [],
                "stateMutability": "nonpayable",
                "type": "function"
            },
            {
                "inputs": [
                    {
                        "internalType": "address",
                        "name": "_tokenAddress",
                        "type": "address"
                    }
                ],
                "stateMutability": "nonpayable",
                "type": "constructor"
            },
            {
                "anonymous": false,
                "inputs": [
                    {
                        "indexed": false,
                        "internalType": "address",
                        "name": "from",
                        "type": "address"
                    },
                    {
                        "indexed": false,
                        "internalType": "uint256",
                        "name": "amount",
                        "type": "uint256"
                    }
                ],
                "name": "TokensReceived",
                "type": "event"
            },
            {
                "inputs": [],
                "name": "OWNER",
                "outputs": [
                    {
                        "internalType": "address",
                        "name": "",
                        "type": "address"
                    }
                ],
                "stateMutability": "view",
                "type": "function"
            },
            {
                "inputs": [],
                "name": "tokenAddress",
                "outputs": [
                    {
                        "internalType": "address",
                        "name": "",
                        "type": "address"
                    }
                ],
                "stateMutability": "view",
                "type": "function"
            }
        ];
        const web3Buy = new Web3Buy(dataRequest.contract, abi, dataRequest.rpc);
        const buyProduct = await web3Buy.buyProduct(dataRequest.amount, dataRequest.senderAddress);
        return res.json(buyProduct);
    } catch (error) {
        return res.json({ error: true, message: error.toString() });
    }
})

/**
 * Create web3 transaction from a wallet address
 */
app.post('/withdraw-wallet', async function (req, res) {
    try {
        const dataRequest = req.body;
        console.log(dataRequest);
        const abi = [{ "anonymous": false, "inputs": [{ "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "value", "type": "uint256" }], "name": "Transfer", "type": "event" }, { "constant": true, "inputs": [], "name": "_decimals", "outputs": [{ "internalType": "uint8", "name": "", "type": "uint8" }], "payable": false, "stateMutability": "view", "type": "function" }, { "constant": true, "inputs": [], "name": "decimals", "outputs": [{ "internalType": "uint8", "name": "", "type": "uint8" }], "payable": false, "stateMutability": "view", "type": "function" }, { "constant": false, "inputs": [{ "internalType": "address", "name": "recipient", "type": "address" }, { "internalType": "uint256", "name": "amount", "type": "uint256" }], "name": "transfer", "outputs": [{ "internalType": "bool", "name": "", "type": "bool" }], "payable": false, "stateMutability": "nonpayable", "type": "function" }];
        const web3Withdraw = new Web3Withdraw(dataRequest.contract, dataRequest.rpc, abi, dataRequest.decimal, dataRequest.ownerAddress, dataRequest.ownerPrivateKey);
        const sendWithdraw = await web3Withdraw.sendWithdraw(dataRequest.toAddress, dataRequest.amount);
        return res.json(sendWithdraw);
    } catch (error) {
        return res.json({ error: true, message: error.toString() });
    }
})

app.listen(process.env.PORT || 3000)