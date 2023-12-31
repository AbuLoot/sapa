<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
  <style>
    @media only screen and (max-width: 600px) {
      .inner-body {
        width: 100% !important;
      }

      .footer {
        width: 100% !important;
      }
    }

    @media only screen and (max-width: 500px) {
      .button {
        width: 100% !important;
      }
    }
  </style>

  <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table class="content" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td class="header"><a href="http://autorex.kz/">AutoRex</a> </td>
          </tr>
          <!-- Email Body -->
          <tr>
            <td class="body" width="100%" cellpadding="0" cellspacing="0">
              <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                <!-- Body content -->
                <tr>
                  <td class="content-cell">
                    <h2>Спасибо за покупку, ваш заказ в обработке. С уважением компания AutoRex.</h2>
                    <h3>Номер вашего заказа: {{ $order->id }}</h3>
                    <b>Ваше Имя: {{ $order->name }}</b><br>
                    <b>Номер телефона: {{ $order->phone }}</b><br>
                    <b>Email: {{ $order->email }}</b><br>
                    <b>Для города: {{ $order->region->title ?? null }}</b><br>
                    <b>Дата заказа: {{ $order->created_at }}</b><br>
                    <b>Товары:<br>
                      <?php
                        $countAllProducts = unserialize($order->count);
                        $i = 0;
                      ?>
                      @foreach ($countAllProducts as $id => $countProduct)
                        @if (isset($order->products[$i]) AND $order->products[$i]->id == $id)
                          {{ $countProduct['quantity'] . ' шт. ' . $order->products[$i]->title  }}<br>
                        @endif
                        <?php $i++; ?>
                      @endforeach
                    </b><br>
                    <b>Сумма: {{ $order->amount }}〒</b><br>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
