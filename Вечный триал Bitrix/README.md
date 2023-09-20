# Вечный триал Битрикс
Всем привет, есть способ сделать триал на 2500+ дней. Делается по аналогии, но не нужно ставить новую копию Битрикса и брать данные оттуда.
#### Пожалуйста, используйте данную инструкцию исключительно для разработки или реанимации сайта. Не нужно использовать этот метод на боевых сайтах, это противоречит политике 1С-Битрикс.
Не нарушайте законодательство и лицензионную политику 1С-Битрикс.

В файле:

bitrix\modules\main\admin\define.php 

заменяем вашу строку на 
#### define("TEMPORARY_CACHE", "ARtufgYHb2MMdQgebRtmG24A");

В таблице b_option поменять значение ключа admin_passwordh на

#### FVgQeWYUBgQtCUVcBxcGCgsTAQ==

Сделать это можно через phpmyadmin руками или SQL запросом ниже:

#### UPDATE b_option SET VALUE = "FVgQeWYUBgQtCUVcBxcGCgsTAQ==" WHERE b_option.MODULE_ID = "main" AND b_option.NAME = "admin_passwordh";

Очистить папку bitrix/managed cache

Для удаления надписи в админке – правим файл 
  
#### \bitrix\modules\main\interface\prolog_main_admin.php 351 строка.

#### //echo BeginNote('style="position: relative; top: -15px;"');
#### echo BeginNote('style="display:none;"');

Данный способ проверял, и всё работает. Единственное по окончанию срока не будите получать обновление компонентов.

Как вариант продлить срок тестового периода можно официально через форму на сайте 1C-Битрикс https://www.1c-bitrix.ru/bsm_register.php
через 1-2 минуты ключ продления у вас на почте.
