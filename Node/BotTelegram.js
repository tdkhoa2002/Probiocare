const TeleBot = require('telebot');
require('dotenv').config()
const TELEGRAM_API_KEY = process.env.TELEGRAM_API_KEY
const chat_id = process.env.TELEGRAM_GROUP_ERROR;


class BotTelegram {
    static async sendMessageError(message) {
        if (TELEGRAM_API_KEY !== undefined && chat_id !== undefined) {
            const bot = new TeleBot(TELEGRAM_API_KEY);
            return await bot.sendMessage(chat_id, message);
        }
    }
}
module.exports = BotTelegram;