const Web3Provider = require('web3');
const BotTelegram = require('./BotTelegram');
class Web3Withdraw {

    /**
     * 
     * @param {*} contract          // Contract address
     * @param {*} rpc               // Chain RPC
     * @param {*} abi               // ABI for contract
     * @param {*} decimal 
     * @param {*} ownerAddress      // Sender
     * @param {*} ownerPrivateKey   // Sender private key
     */
    constructor(contract, rpc, abi, decimal, ownerAddress, ownerPrivateKey) {
        this.web3 = new Web3Provider(rpc);
        this.contractAddress = contract;
        this.ownerAddress = ownerAddress;
        this.decimal = decimal;
        this.ownerPrivateKey = ownerPrivateKey;
        this.contract = new this.web3.eth.Contract(abi, contract);
    }

    /**
     * Send native while Contract Address is 0x0000000000000000000000000000000000001010 from ownerPrivateKey
     * @param {*} toAddress 
     * @param {*} amount 
     * @returns 
     */
    async sendWithdraw(toAddress, amount) {
        try {
            if (this.contractAddress == '0xbb4CdB9CBd36B01bD1cBaEBF2De08d9173bc095c' ||
                this.contractAddress == '0x0000000000000000000000000000000000001010' || this.contractAddress == '0xC02aaA39b223FE8D0A0e5C4F27eAD9083C756Cc2' ||
                this.contractAddress == "") {
                return await this.sendWithdrawNative(toAddress, amount);
            } else {
                return await this.sendWithdrawToken(toAddress, amount);
            }
        } catch (error) {
            return { error: true, toAddress, message: JSON.stringify(error) };
        }
    }

    /**
     * Send Native transaction on EVM Blockchain from ownerPrivateKey
     * @param {*} toAddress 
     * @param {*} amount 
     * @returns 
     */
    async sendWithdrawNative(toAddress, amount) {
        try {
            const signinData = await this.signTransactionNative(toAddress, amount);
            if (signinData !== false && signinData.rawTransaction) {
                return await this.sendSignedTransaction(toAddress, signinData.rawTransaction);
            } else {
                return false;
            }
        } catch (error) {
            return { error: true, toAddress, message: JSON.stringify(error) };
        }
    }

    /**
     * Send ERC20 transaction with contractAddress on EVM Blockchain from ownerPrivateKey
     * @param {*} toAddress 
     * @param {*} amount 
     * @returns 
     */
    async sendWithdrawToken(toAddress, amount) {
        try {
            const signinData = await this.signTransaction(toAddress, amount);
            if (signinData !== false && signinData.rawTransaction) {
                console.log(toAddress);
                return await this.sendSignedTransaction(toAddress, signinData.rawTransaction);
            } else {
                return false;
            }
        } catch (error) {
            return { error: true, toAddress, message: JSON.stringify(error) };
        }
    }

    async signTransaction(toAddress, amount) {
        try {
            const decimals = this.decimal
            if (decimals) {
                let amountDecimal = +amount * +`1e${decimals}`;
                amountDecimal = amountDecimal.toLocaleString('fullwide', { useGrouping: false })
                amountDecimal = BigInt(amountDecimal).toString()
                let gasPrice = await this.web3.eth.getGasPrice()
                const data = this.contract.methods.transfer(toAddress, amountDecimal).encodeABI();
                const gasLimit = await this.estimateGasLimit(this.ownerAddress, this.contractAddress, data);
                const txObj = {
                    gasPrice: this.web3.utils.toHex(gasPrice),
                    gasLimit: this.web3.utils.toHex(gasLimit),
                    to: this.contractAddress,
                    value: '0x00',
                    data: data
                }
                return await this.web3.eth.accounts.signTransaction(txObj, this.ownerPrivateKey);
            } else {
                return false;
            }
        } catch (error) {
            return { error: true, toAddress, message: JSON.stringify(error) };
        }
    }

    async signTransactionNative(toAddress, amount) {
        try {
            const decimals = this.decimal
            if (decimals) {
                let amountDecimal = +amount * +`1e${decimals}`;
                amountDecimal = amountDecimal.toLocaleString('fullwide', { useGrouping: false })
                amountDecimal = BigInt(amountDecimal).toString()
                let gasPrice = await this.web3.eth.getGasPrice()
                const gasLimit = await this.estimateGasLimitNative(this.ownerAddress, toAddress);
                const txObj = {
                    gasPrice: this.web3.utils.toHex(gasPrice),
                    to: toAddress,
                    value: this.web3.utils.toHex(amountDecimal),
                    gasLimit: this.web3.utils.toHex(gasLimit)
                }
                return await this.web3.eth.accounts.signTransaction(txObj, this.ownerPrivateKey);

            } else {
                return false;
            }
        } catch (error) {
            return { error: true, toAddress, message: JSON.stringify(error) };
        }
    }

    async sendSignedTransaction(toAddress, rawTransaction) {

        try {
            const data = await this.web3.eth.sendSignedTransaction(rawTransaction);
            return { error: false, toAddress, data };
        } catch (error) {
            BotTelegram.sendMessageError("sendSignedTransaction:" + toAddress + error.toString());
            return { error: true, toAddress, message: error.toString() };
        }
    }

    /**
     * Estimate gas price
     * @param {*} from 
     * @param {*} to 
     * @param {*} dataEncodeABI 
     * @returns 
     */
    async estimateGasLimit(from, to, dataEncodeABI) {
        try {
            const gasLimit = await this.web3.eth.estimateGas({ "from": from, "to": to, "data": dataEncodeABI })
            const gasLimitE = +gasLimit + ((+gasLimit * 10) / 100);
            return gasLimitE.toFixed();
        } catch (error) {
            return 100000;
        }
    }

    async estimateGasLimitNative(from, to) {
        try {
            const gasLimit = await this.web3.eth.estimateGas({ "from": from, "to": to })
            const gasLimitE = +gasLimit + ((+gasLimit * 10) / 100);
            return gasLimitE.toFixed();
        } catch (error) {
            BotTelegram.sendMessageError(`Web3Withdraw - estimateGasLimitNative: ${error}`);
            return 100000;
        }
    }
}
module.exports = Web3Withdraw;