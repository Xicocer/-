import telebot
import pymysql
from telebot import types
import os

connection = pymysql.connect(
    host= '127.0.0.1',
    port= 3306,
    user= 'root',
    password= '',
    database='reforbo',
    cursorclass=pymysql.cursors.DictCursor
)
cursor = connection.cursor()

cursor.execute("SELECT `name` FROM object")
objects = cursor.fetchall()
cursor.execute("SELECT `name` FROM them")
thems = cursor.fetchall()
cursor.execute("SELECT `text` FROM lecture")
lec = cursor.fetchall()


bot = telebot.TeleBot('7033606586:AAHKudnKzq7p5A3nhfO3CO5R5mXjYulGA9Y')

@bot.message_handler(commands=['start'])
def greetingAndChoose (massege):
    markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
    btn1 = types.KeyboardButton("Предметы")
    markup.add(btn1)
    bot.send_message(massege.chat.id, f'Привет, {massege.from_user.first_name} {massege.from_user.last_name}. Это бот Лектор, с его помощью можно найти лекции по разным предметам от твоих преподавателей.', reply_markup= markup )

@bot.message_handler(content_types=['text'])
def answer(massege):
    if massege.text.lower() == "предметы":
        for i in range(len(objects)):
            markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
            btn3 = types.KeyboardButton(f"{objects[i]['name']}")
            markup.add(btn3)
            bot.send_message(massege.chat.id,objects[i]['name'],reply_markup= markup)
    elif massege.text.lower() == objects[0]['name'].lower():
        for i in range(len(thems)):
            markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
            btn3 = types.KeyboardButton(f"{thems[i]['name']}")
            markup.add(btn3)
            bot.send_message(massege.chat.id,thems[0]['name'],reply_markup= markup)
    elif massege.text.lower() == thems[0]['name'].lower():
        markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
        btn3 = types.KeyboardButton('Предметы')
        markup.add(btn3)
        file = open(f".{lec[0]['text']}",'rb')
        bot.send_document(massege.chat.id, file)
    else:
        bot.send_message(massege.chat.id,'Я тебя не понимаю' )

bot.infinity_polling()