<template>
    <div class="">
        <!-- <p>{{ subtotal }}</p> -->
        <div v-if="!isLoggedIn">
            <button class="btn btn-success" style="width: 300px;"
            @click="connectWallet"
            v-if="isMetamaskSupported">Pay with Metamask</button>
            <span v-else>Install Metamask extension</span>
        </div>
        <div v-else>
            {{ computedAddress }}
        </div>
    </div>
</template>

<script lang="ts" setup>
import { onMounted, ref, computed } from 'vue';
import Axios from "axios";
import Web3 from 'web3';

const isLoggedIn = ref(false);
const address = ref("");
const isMetamaskSupported = ref(false);
let contract;
const subtotal = ref(null);
let amount;

onMounted(async () => {
    isMetamaskSupported.value = window.ethereum !== 'undefined';
    await Axios.get('/api/checkout').then(response => {
        subtotal.value = parseInt(response.data.data.total.replace(/,/g, ""), 10);
        console.log(response.data.data);
        
    }).catch(error => {
        console.error('Error fetching subtotal:', error);
    });
    const web3 = new Web3("https://data-seed-prebsc-2-s2.bnbchain.org:8545");
    amount = web3.utils.toWei(subtotal.value, 'ether');
    const contractAddress = '0x02b717aA57EA74c547FA58890043e1EDc57c9657';
    var abi = 
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
    contract = new web3.eth.Contract(abi, contractAddress);
    // console.log(subtotal.value);
    
    // amount = Number(BigInt(subtotal.value) * 10n ** 18n);
    // console.log(amount);
    
});

    async function connectWallet() {
        try {
            const accounts = await window.ethereum.request({method: "eth_requestAccounts"});
            address.value = accounts[0];
            const account = address.value;
            const transaction = contract.methods.buyProduct(amount).encodeABI();
            console.log(amount);
            await window.ethereum.request({ 
                "method": "eth_sendTransaction",
                "params": [
                    {
                    "to": "0x02b717aA57EA74c547FA58890043e1EDc57c9657",
                    "from": account,
                    "data": transaction,
                    }
                ]
            });

            await Axios.post('/web3/buy-product');
            window.location.href = "/order-success/CB84E5503F";
        } catch (error) {
            console.error("Error:", error);
        }
        
    };
const computedAddress = computed(() => address.value.substring(0, 4) + "....")

</script>


<!-- // Axios.post("/web3/buy-product", {
    //     senderAddress: address.value
    // })
    //     .then((response) => {
    //         console.log(response);
    //     })
    //     .catch((error) => {
    //       console.log(error);
    // }); -->