from telebot.async_telebot import AsyncTeleBot
from telebot.util import quick_markup
import pymysql
import asyncio
from telebot import types
#Подключение к бд
def query(query:str):
    try:
        connect = pymysql.connect(
            host="127.0.0.1",
            user="root",
            database="reforbo",
            port=3306,
            cursorclass=pymysql.cursors.DictCursor
        )
        print("bd connected!")
        try:
            with connect.cursor() as cursor:
                cursor.execute(query)
                if "SELECT" in query:
                    return cursor.fetchall()
                else:
                    connect.commit()
        finally:
            connect.close()
    except Exception as ex:
        print("Connection refused...")
        print(ex)

bot = AsyncTeleBot('7033606586:AAGEWSPHNVOHfADUIlwUfa8gO4-3KWqnYJw')

# Handle '/start' and '/help'
@bot.message_handler(commands=['help', 'start'])
async def send_welcome(message):
    butons = dict()
    subjects = query("SELECT * FROM object")
    for i in subjects:
        butons[i['name']] = {"callback_data":'{"id":'+str(i["id"])+',"type":"subject"}'}
    markup = quick_markup(butons, row_width=1)
    await bot.send_message(message.chat.id, f"Привет, {message.from_user.first_name}, я тебе предлагаю выбрать предмет, по которому тебе нужна лекция",reply_markup=markup)
#Выбор предета
@bot.callback_query_handler(func = lambda call: True)
async def select(call):
    data = eval(call.data)
    if data['type'] == 'subject':
        thems = query(f"SELECT * FROM `them` WHERE `id_object`={data['id']}")
        butons = dict()
        print(data['id'])
        for i in thems:
            butons[i['name']] = {"callback_data":'{"id":'+str(i["id"])+',"type":"them"}'}
        butons['Выбрать другой предмет'] = {"callback_data":"{'type':'reset'}"}
        print(butons)
        markup = quick_markup(butons, row_width=1)
        await bot.send_message(call.message.chat.id, f"Выбери тему, по которому тебе нужна лекция",reply_markup=markup)

    elif data['type'] == 'them':
        lectures = query(f"SELECT id, name FROM lecture WHERE `id_them`={data['id']}")
        butons = dict()
        for i in lectures:
            butons[i['name']] = {"callback_data":'{"id":'+str(i["id"])+',"type":"lecture"}'}
        butons['Выбрать другой предмет'] = {"callback_data":"{'type':'reset'}"}
        print(butons)
        markup = quick_markup(butons, row_width=1)
        await bot.send_message(call.message.chat.id, f"Выбери тему, по которому тебе нужна лекция",reply_markup=markup)
#Получение файла
    elif data['type'] == "lecture":
        lecture = query(f"SELECT * FROM lecture WHERE `id`={data['id']}")[0]
        markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
        reset =types.KeyboardButton("Выбрать предмет")
        markup.add(reset)
        if(bool(lecture['file'])):
            file = open(f".{lecture['text']}",'rb')
            await bot.send_message(call.message.chat.id, f"{lecture['name']}",reply_markup=markup)
            await bot.send_document(call.message.chat.id, file)
        else:
            await bot.send_message(call.message.chat.id, f"{lecture['name']}\n{lecture['text']}",reply_markup=markup)
    elif data['type'] == 'reset':
        butons = dict()
        subjects = query("SELECT * FROM object")
        for i in subjects:
            butons[i['name']] = {"callback_data":'{"id":'+str(i["id"])+',"type":"subject"}'}
        markup = quick_markup(butons, row_width=1)
        await bot.send_message(call.message.chat.id, f"{call.message.from_user.first_name}, я тебе предлагаю выбрать предмет, по которому тебе нужна лекция",reply_markup=markup)
    else:
        bot.reply_to(call.message.chat.id,f"{call.message.from_user.first_name}, выберете из предложенных вариантов")

@bot.message_handler(content_types=['text'])
async def restart(message):
    if(message.text == "Выбрать предмет"):
        butons = dict()
        subjects = query("SELECT * FROM object")
        for i in subjects:
            butons[i['name']] = {"callback_data":'{"id":'+str(i["id"])+',"type":"subject"}'}
        markup = quick_markup(butons, row_width=1)
        await bot.send_message(message.chat.id, f"Привет, {message.from_user.first_name}, я тебе предлагаю выбрать предмет, по которому тебе нужна лекция",reply_markup=markup)
asyncio.run(bot.polling())