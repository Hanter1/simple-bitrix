# Немного о Bitrix 

Здесь собрана информация, которая помогла мне узнать CMS Bitrix, надеюсь и вам будет полезна данная информация!

## Что такое Bitrix Framework?
- Созданная на основе PHP платформа для разработки веб-приложений.
- В отличие от многих других фреймворков, сразу получаем не только набор классов для построения приложений, но и интерфейс, и множество функционала по настройке системы.
- На этой платформе разработаны 1С БУС(CMS) и 1С Корпоративный портал и Bitrix24(CRM)

## Архитектура битрикс

### Элементы структуры Bitrix Framework:
- Модули - это объёмный блок кода, отвечающий за определенную функциональность продукта. Модуль может содержать API всех уровней, пользовательские интерфейсы, компонент, административные страницы и т.д.
- Компонент - логически сгруппированный код, отвечающий за выборку, подготовку и вывод данных.

### Архитектура сайта, проекта
- созданная для сайта БД
- файлы: ядро битрикс
- файлы: файллы проекта
- страницы сайта: публичная часть
- страницы сайта: административная часть

### Bitrix и MVC
- В разрезе компонентов:
- M - данные, полученные с помощью API
- V - шаблон компонента
- C - class.php и/или component.php

### В D7, ORM
- Можно более явно описать модели
- Можно создавать контроллеры
- Представлений в чистом виде по-прежнему нет
- Можно реализовать роутинг с единой точкой входа

### Bitrix Framework реализован на файлах
- меньший порог входа
- простота формирования структуры сайта, построение меню, хлебных крошек
- хранение кода и структуры сайта в системе контроля версий
- гибкая настройка прав доступа
- локализация

### Установка
- Виртуальная машина
- bitrixsetup.php
- архив

### Что учесть в конфигах:

- mbstring.func_overload = 0
- mbstring.internal_encoding = UTF-8
- short_open_tag = On
- memory_limit = 256М
- max_input_vars = 10000
- max_execution_time = 60

## Файл Init.php
- подключается максимально рано
- нельзя делать какой-либо вывод на странице
- нужен для подключения/хранения вспомогательного кода
- располагается по пути: 
-/bitrix/php_interface/init.php
-/local/php_interface/init.php

## Oldcore и D7
<table>
    <tr>
        <th>Oldcore - старое API</th>
        <th>D7 - новое API</th>
    </tr>
    <tr>
<td>
        -Глобальное пространство имен</br>
        -Нет единообразия</br>
        -Сущности описываются массивами</br>
        -Иногда можно быстрее получить результат
</td>
        <td>
                - Неймспейсы согласно принадлежности к модулям</br>
                - API основано на ОRM</br>
                - Сущности описываются объектами</br>
                - Больше возможностей
        </td>
    </tr>
</table>

## Популярные стандартные компоненты
- breadcrumb
- menu
- system.pagenavigation
- news/news.list/news.detail
- catalog/catalog.sections.top/catalog.sections.list/catalog.section/catalog.item
- catalog.smart.filter
- system.auth.*
- search.page/search.title/search.form

## События
- Определенные точки в коде, чтобы мы могли повлиять на ход алгоритма
- Является реализацией паттерна Наблюдатель.</br>
Определение паттерна:</br>
Наблюдатель - это поведенческий паттерн проектирования, который создает механизм подписки, позволяющий одним объектам следить и реагировать на события, происходящие в других объектах.
- У каждого модуля есть свой набор доступных событий. 

## Агенты
- Агент - код, выполняемый периодически.
- Список агентов хранится в системе в специальной таблице
#### Параментры агентов:
- собственно выполняемый код
- время выполнения
- периодичность выполнения
- и параметры назначения следующего времени выполнения (строго или нестрого периодический)
