# РАБОТА С ЗАКАЗОМ В БИТРИКС D7

Все классы для работы с магазином собраны в модуле sale, 
поэтому для работы примером используем use для пространства модуля интернет-магазина.

`use Bitrix\Sale;`

---

### Заказ (Sale\Order)

Заказ представляет собой объект класса `Bitrix\Sale\Order`. 
Нужно запомнить, что пока не вызван метод `save()` этот объект необязательно связан с сохранённым заказом. 
Также пока вы не вызовете `save()`, изменения в заказе не будут сохранены в базе данных.

Существующий заказ можно получить следующим образом:

```php 
/** int $orderId ID заказа */
$order = Sale\Order::load($orderId);

/** mixed $orderNumber номер заказа */
$order = Sale\Order::loadByAccountNumber($orderNumber);
```

Поля заказа можно получить короткими вызовами:

```php 
$order->getId(); // ID заказа
$order->getSiteId(); // ID сайта
$order->getDateInsert(); // объект Bitrix\Main\Type\DateTime
$order->getPersonTypeId(); // ID типа покупателя
$order->getUserId(); // ID пользователя

$order->getPrice(); // Сумма заказа
$order->getDiscountPrice(); // Размер скидки
$order->getDeliveryPrice(); // Стоимость доставки
$order->getSumPaid(); // Оплаченная сумма
$order->getCurrency(); // Валюта заказа

$order->isPaid(); // true, если оплачен
$order->isAllowDelivery(); // true, если разрешена доставка
$order->isShipped(); // true, если отправлен
$order->isCanceled(); // true, если отменен
```

Также любое поле по имени можно получить так:

```php 
$order->getField("ORDER_WEIGHT"); // Вес заказа
$order->getField('PRICE'); // Сумма заказа
// Изменение поля:
$order->setField('USER_DESCRIPTION', 'Комментарий к заказу');
$order->save();
```

Список доступных полей можно получить, вызвав `$order->getAvailableFields()`.

Заказ имеет связь один-ко-многим с несколькими объектами в виде коллекций - коллекция товаров в корзине (`Sale\Basket`), 
коллекция отгрузок (`Sale\ShipmentCollection`), коллекция оплат (`Sale\PaymentCollection`) и коллекция свойств заказа (`Sale\PropertyValueCollection`).

Самый простой способ получить список способов доставки и оплаты - короткие вызовы:

```php 
$paymentIds = $order->getPaymentSystemId(); // массив id способов оплат
$deliveryIds = $order->getDeliverySystemId(); // массив id способов доставки
```

Чтобы получить список примененных к заказу скидок, нужно вызвать:

```php 
$discountData = $order->getDiscount()->getApplyResult();
```

В массиве `$discountData['DISCOUNT_LIST']` содержится список скидок, в `$discountData['COUPON_LIST']` содержится список купонов. 
Т.к. скидки можно отключать в админке, следует проверять поле APPLY: если Y - скидка/купон применёны, если N - были отключены менеджером.

---

### Корзина заказа (Sale\Basket)

```php
/** Sale\Basket $basket */
$order->setBasket($basket);

$basket = $order->getBasket();
```

### Свойства заказа (Sale\PropertyValueCollection)

Свойства заказа - объекты Bitrix\Sale\PropertyValue - собраны в коллекции propertyCollection

```php 
$propertyCollection = $order->getPropertyCollection();
```

Получить значения всех свойств и группы свойств можно так:

```php 
$ar = $propertyCollection->getArray(); // массив ['properties' => [..], 'groups' => [..] ];
$ar = $propertyCollection->getGroups(); // массив групп
$ar = $propertyCollection->getGroupProperties($groupId); // массив свойств, относящихся к группе
```

У многих свойств заказа есть определенное встроенное назначение 
(атрибуты IS_EMAIL, IS_PAYER, IS_LOCATION, IS_LOCATION4TAX, IS_PROFILE_NAME, IS_ZIP, IS_PHONE, IS_ADDRESS). 
Такие свойства можно получить следующими методами:

```php 
$emailPropValue = $propertyCollection->getUserEmail();
$namePropValue  = $propertyCollection->getPayerName();
$locPropValue   = $propertyCollection->getDeliveryLocation();
$taxLocPropValue = $propertyCollection->getTaxLocation();
$profNamePropVal = $propertyCollection->getProfileName();
$zipPropValue   = $propertyCollection->getDeliveryLocationZip();
$phonePropValue = $propertyCollection->getPhone();
$addrPropValue  = $propertyCollection->getAddress();
```

Получить значение свойства по ID:

```php 
$somePropValue = $propertyCollection->getItemByOrderPropertyId($orderPropertyId);
```

В любом случае получаем значение свойства - экземпляр класса **Bitrix\Sale\PropertyValue**. 
Из него мы можем получить значение свойства:

```php 
$somePropValue->getValue(); // значение свойства
$somePropValue->getViewHtml(); // представление значения в читаемом виде (напр. для местоположения - путь страна, регион, город)
```

И информацию о самом свойстве:

```php 
$arProp  = $somePropValue->getProperty(); // массив данных о самом свойстве
$propId  = $somePropValue->getPropertyId(); // ID свойства
$propName = $somePropValue->getName(); // Название
$isRequired = $somePropValue->isRequired(); // true, если свойство обязательное
$propPerson = $somePropValue->getPersonTypeId(); // Тип плательщика
$propGroup  = $somePropValue->getGroupId(); // ID группы
```

Чтобы изменить значение свойства следует вызвать метод setValue и сохранить сущность

```php 
$somePropValue->setValue("value");
$order->save(); 
// можно $somePropValue->save(), но пересчета заказа не произойдёт
```

### Оплаты заказа (Sale\PaymentCollection)

```php 
$paymentCollection = $order->getPaymentCollection();
```

Из коллекции оплат также можно получить информацию об оплате, что и из объекта заказа. Оплата с внутреннего счета также считается одной из оплат:

```php 
$paymentCollection->isPaid(); // true, если все оплаты оплачены
$paymentCollection->hasPaidPayment(); // true, если хотя бы одна оплата оплачена
$paymentCollection->getPaidSum(); // оплаченная сумма
$paymentCollection->isExistsInnerPayment(); // true, если осуществлена оплата с внутреннего счета
```

Коллекция содержит объекты оплаты **Sale\Payment** с информацией об оплатах:

```php 
foreach ($paymentCollection as $payment) {
    $sum = $payment->getSum(); // сумма к оплате
    $isPaid = $payment->isPaid(); // true, если оплачена
    $isReturned = $payment->isReturn(); // true, если возвращена

    $ps = $payment->getPaySystem(); // платежная система (объект Sale\PaySystem\Service)
    $psID = $payment->getPaymentSystemId(); // ID платежной системы
    $psName = $payment->getPaymentSystemName(); // название платежной системы
    $isInnerPs = $payment->isInner(); // true, если это оплата с внутреннего счета
}
```

Оплатить или вернуть оплату можно методами setPaid(), setReturn():

```php 
$onePayment = $paymentCollection[0];
$onePayment->setPaid("N"); // отмена оплаты
$onePayment->setPaid("Y"); // оплата
$onePayment->setReturn("Y"); // возврат (деньги возвращаются на внутренний счет или в платежную систему, если обработчик реализует интерфейс Sale\PaySystem\IRefund)
// после любых действий нужно сохранить сущность:
$order->save();
```

Инициировать оплату (вывести шаблон оплаты: форму, кнопку и т.п.) можно следующим образом:

```php 
$service = Sale\PaySystem\Manager::getObjectById($onePayment->getPaymentSystemId());
$context = \Bitrix\Main\Application::getInstance()->getContext();
$service->initiatePay($onePayment, $context->getRequest());
```