const Web3Provider = require('web3');
const provider = 'https://bsc-dataseed1.binance.org/';
class Web3Wallet {
    constructor() {
        this.web3 = new Web3Provider(provider);
    }

    async sleep(milliseconds) {
        return new Promise(resolve => setTimeout(resolve, milliseconds));
    }

    async createWallet() {
        try {
            return this.web3.eth.accounts.create(this.web3.utils.randomHex(32));
        } catch (error) {
            return false;
        }
    }
}
module.exports = Web3Wallet;
